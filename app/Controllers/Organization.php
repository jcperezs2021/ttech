<?php

namespace App\Controllers;

use App\Models\UserModel;

class Organization extends BaseController
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel        = new UserModel();
    }

    public function index(): string
    {
        
        return   view('shared/header',                              ['title'        => 'Organigrama'])
                .view('shared/sidebar')
                .view('pages/admin/organization/organization',      ['org'          => $this->userModel->getOrganization()])
                .view('shared/footer');
    }
}
