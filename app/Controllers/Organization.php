<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DepartmentModel;
use App\Models\AreaModel;

class Organization extends BaseController
{

    protected $userModel;
    protected $departmentModel;
    protected $areaModel;

    public function __construct()
    {
        $this->userModel        = new UserModel();
        $this->departmentModel  = new DepartmentModel();
        $this->areaModel        = new AreaModel();
    }

    public function index(): string
    {
        
        return   view('shared/header',                              ['title'        => 'Organigrama'])
                .view('shared/sidebar')
                .view('pages/admin/organization/organization',      [
                                                                        'departments'  => $this->departmentModel->getDepartments(),
                                                                        'areas'        => $this->areaModel->getAreas()
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

    public function getOrganizationByArea($areaId)
    {
        return json_encode($this->userModel->getOrganizationChartByArea($areaId));
    }
}
