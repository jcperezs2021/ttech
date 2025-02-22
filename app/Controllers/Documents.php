<?php

namespace App\Controllers;

class Documents extends BaseController
{

    public function __construct()
    {
    }

    public function index(): string
    {
        
        return   view('shared/header',      ['title'     => 'Documentos'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/user/documents/documents')
                .view('shared/footer');
    }
    
    public function documents(): string
    {
        
        return   view('shared/header',      ['title'     => 'Documentos'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/documents/documents')
                .view('shared/footer');
    }
}
