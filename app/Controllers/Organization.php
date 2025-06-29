<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DepartmentModel;

class Organization extends BaseController
{

    protected $userModel;
    protected $departmentModel;

    public function __construct()
    {
        $this->userModel        = new UserModel();
        $this->departmentModel  = new DepartmentModel();
    }

    public function index(): string
    {
        
        return   view('shared/header',                              ['title'        => 'Organigrama'])
                .view('shared/sidebar')
                .view('pages/admin/organization/organization',      [
                                                                        // 'org'          => $this->userModel->getOrganizationChart(),
                                                                        'departments'  => $this->departmentModel->getDepartments(),
                                                                    ])
                .view('shared/footer');
    }

    public function getOrganization()
    {
        
        return json_encode($this->userModel->getOrganizationChart());
    }

    public function getOrganizationByDepartment($departmentId)
    {
        return json_encode($this->userModel->getOrganizationChartByDepartment($departmentId));
    }
}
