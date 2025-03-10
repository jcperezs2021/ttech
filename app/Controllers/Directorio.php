<?php

namespace App\Controllers;

use App\Models\UserModel;

class Directorio extends BaseController
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
                .view('pages/user/directorio/directorio',           ['users'          => $this->userModel->getUsers()])
                .view('shared/footer');
    }
}
