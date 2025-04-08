<?php

namespace App\Controllers;

use App\Models\DepartmentModel;
use App\Controllers\HelperUtility;

class Department extends BaseController
{
    protected $departmentModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->departmentModel   = new DepartmentModel();
    }

    public function index(): string
    {
        $departments = $this->departmentModel->getDepartments();

        return   view('shared/header',                              ['title'     => 'Departamentos'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/department/department',            [
                                                                        'csrfName'      => csrf_token(),    
                                                                        'csrfHash'      => csrf_hash(),
                                                                        'departments'    => $departments
                                                                    ])
                .view('shared/footer');
    }

    public function newDepartment(): string
    {
        return   view('shared/header',              ['title'        => 'Nuevo Puesto'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/department/department-new')
                .view('shared/footer');
    }

    public function editDepartment($id): string
    {
        $data['department'] = $this->departmentModel->getDepartments($id);

        if ($data['department']) {
            return   
                view('shared/header',                           ['title'        => "Editar Puesto"])
               .view('shared/sidebar')
               .view('shared/navbar')
               .view('pages/admin/department/department-edit',    ['data'        => $data])
               .view('shared/footer');
        } else {
            return redirect()->to('/department');
        }
    }

    public function createDepartment()
    {
        $name = $this->request->getPost('name');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage('/department/new', lang('Errors.missing_fields'));
        }

        // Verificar si el department ya existe
        if ($this->departmentModel->getDepartmentByName($name)) {
            return HelperUtility::redirectWithMessage('/department/new', lang('Errors.gral_duplicated'));
        }

        // Crear nuevo department
        if ($this->departmentModel->createDepartment($name)) {
            return HelperUtility::redirectWithMessage('/department/new', lang('Success.gral_created'), 'success');
        }

        return HelperUtility::redirectWithMessage('/department/new', lang('Errors.error_try_again_later'));
    }

    public function updateDepartment()
    {
        $name   = $this->request->getPost('name');
        $id     = $this->request->getPost('id');

        // Validación inicial de los campos requeridos
        if (!$name) {
            return HelperUtility::redirectWithMessage("/department/edit/$id", lang('Errors.missing_fields'));
        }

        // Verificar si el department existe
        if ($this->departmentModel->getDepartmentByName($name) && $this->departmentModel->getDepartmentByName($name)->id != $id) {
            return HelperUtility::redirectWithMessage("/department/edit/$id", lang('Errors.gral_duplicated'));
        }

        // Actualizar department
        if ($this->departmentModel->updateDepartment($id, $name)) {
            return HelperUtility::redirectWithMessage("/department/edit/$id", lang('Success.gral_update'), 'success');
        }

        return HelperUtility::redirectWithMessage("/department/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function deleteDepartment()
    {
        $id = $this->request->getPost('id');

        // Verificar si existe
        $department = $this->departmentModel->getDepartments($id);
        if (!$department) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.gral_not_found'),
            ]);
        }

        // Eliminar
        if($this->departmentModel->deleteDepartment($id)){
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
