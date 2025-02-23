<?php

namespace App\Controllers;

use App\Models\OcupationModel;
use App\Controllers\HelperUtility;

class Ocupation extends BaseController
{
    protected $ocupationModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->ocupationModel   = new OcupationModel();
    }

    public function index(): string
    {
        $ocupations = $this->ocupationModel->getOcupations();

        return   view('shared/header',              ['title'     => 'Puestos'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/ocupation/ocupation',            [
                                                                        'csrfName'      => csrf_token(),    
                                                                        'csrfHash'      => csrf_hash(),
                                                                        'ocupations'    => $ocupations
                                                                    ])
                .view('shared/footer');
    }

    public function newOcupation(): string
    {
        return   view('shared/header',              ['title'        => 'Nuevo Puesto'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/ocupation/ocupation-new')
                .view('shared/footer');
    }

    public function editOcupation($id): string
    {
        $data['ocupation'] = $this->ocupationModel->getOcupations($id);

        if ($data['ocupation']) {
            return   
                view('shared/header',                           ['title'        => "Editar Puesto"])
               .view('shared/sidebar')
               .view('shared/navbar')
               .view('pages/admin/ocupation/ocupation-edit',    ['data'        => $data])
               .view('shared/footer');
        } else {
            return redirect()->to('/ocupation');
        }
    }

    public function createOcupation()
    {
        $name = $this->request->getPost('name');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage('/ocupation/new', lang('Errors.missing_fields'));
        }

        // Verificar si el ocupation ya existe
        if ($this->ocupationModel->getOcupationByName($name)) {
            return HelperUtility::redirectWithMessage('/ocupation/new', lang('Errors.gral_duplicated'));
        }

        // Crear nuevo ocupation
        if ($this->ocupationModel->createOcupation($name)) {
            return HelperUtility::redirectWithMessage('/ocupation/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/ocupation/new', lang('Errors.error_try_again_later'));
    }

    public function updateOcupation()
    {
        $name   = $this->request->getPost('name');
        $id     = $this->request->getPost('id');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage("/ocupation/edit/$id", lang('Errors.missing_fields'));
        }

        // Verificar si el ocupation existe
        if ($this->ocupationModel->getOcupationByName($name) && $this->ocupationModel->getOcupationByName($name)->id != $id) {
            return HelperUtility::redirectWithMessage("/ocupation/edit/$id", lang('Errors.gral_duplicated'));
        }

        // Actualizar ocupation
        if ($this->ocupationModel->updateOcupation($id, $name)) {
            return HelperUtility::redirectWithMessage("/ocupation/edit/$id", lang('Success.gral_update'), 'success');
        }

        return HelperUtility::redirectWithMessage("/ocupation/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function deleteOcupation()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $ocupation = $this->ocupationModel->getOcupations($id);
        if (!$ocupation) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // Eliminar
        if($this->ocupationModel->deleteOcupation($id)){
            return $this->respondWithCsrf([
                'ok'            => true,
            ]);
        }

        // En caso de error
        return $this->respondWithCsrf([
            'ok'            => false,
            'error'         => lang('Errors.error_try_again_later'),
        ]);
    }


}
