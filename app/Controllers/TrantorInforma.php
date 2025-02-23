<?php

namespace App\Controllers;

class TrantorInforma extends BaseController
{

    public function __construct()
    {
    }

    public function index(): string
    {
        
        return   view('shared/header',      ['title'     => 'Trantor Informa'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/user/trantor-informa/trantor-informa',     [
                                                                            'csrfName'      => csrf_token(),    
                                                                            'csrfHash'      => csrf_hash(),
                ])
                .view('shared/footer');
    }

    public function store()
    {
        // Obtiene todo lo qu viene en POST y lo imprimir
        print_r($this->request->getPost());

    }
}
