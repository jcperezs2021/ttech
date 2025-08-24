<?php

namespace App\Controllers;

use App\Models\AreaModel;
use App\Controllers\HelperUtility;

class Area extends BaseController
{
    protected $areaModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->areaModel        = new AreaModel();
    }

    public function index(): string
    {
        $areas = $this->areaModel->getAreas();

        return   view('shared/header',              ['title'     => 'Areas'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/area/area',              [
                                                                'csrfName'      => csrf_token(),    
                                                                'csrfHash'      => csrf_hash(),
                                                                'areas'         => $areas
                                                            ])
                .view('shared/footer');
    }

    public function newArea(): string
    {
        return   view('shared/header',              ['title'        => 'Nuevo Area'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/area/area-new')
                .view('shared/footer');
    }

    public function editArea($id): string
    {
        $data['area'] = $this->areaModel->getAreas($id);

        if ($data['area']) {
            return   
                view('shared/header',                           ['title'        => "Editar Area"])
               .view('shared/sidebar')
               .view('shared/navbar')
               .view('pages/admin/area/area-edit',              ['data'        => $data])
               .view('shared/footer');
        } else {
            return redirect()->to('/area');
        }
    }

    public function createArea()
    {
        $name = $this->request->getPost('name');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage('/area/new', lang('Errors.missing_fields'));
        }

        // Verificar si el area ya existe
        if ($this->areaModel->getAreaByName($name)) {
            return HelperUtility::redirectWithMessage('/area/new', lang('Errors.gral_duplicated'));
        }

        // Crear nuevo area
        if ($this->areaModel->createArea($name)) {
            return HelperUtility::redirectWithMessage('/area/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/area/new', lang('Errors.error_try_again_later'));
    }

    public function updateArea()
    {
        $name   = $this->request->getPost('name');
        $id     = $this->request->getPost('id');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage("/area/edit/$id", lang('Errors.missing_fields'));
        }

        // Verificar si el area existe
        if ($this->areaModel->getAreaByName($name) && $this->areaModel->getAreaByName($name)->id != $id) {
            return HelperUtility::redirectWithMessage("/area/edit/$id", lang('Errors.gral_duplicated'));
        }

        // Actualizar area
        if ($this->areaModel->updateArea($id, $name)) {
            return HelperUtility::redirectWithMessage("/area/edit/$id", lang('Success.gral_update'), 'success');
        }

        return HelperUtility::redirectWithMessage("/area/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function deleteArea()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $area = $this->areaModel->getAreas($id);
        if (!$area) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // Eliminar
        if($this->areaModel->deleteArea($id)){
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
