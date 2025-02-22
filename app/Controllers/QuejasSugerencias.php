<?php

namespace App\Controllers;

class QuejasSugerencias extends BaseController
{

    public function __construct()
    {
    }

    public function index(): string
    {
        
        return   view('shared/header',      ['title'     => 'Trantor Technologies'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/user/quejas-sugerencias/quejas-sugerencias')
                .view('shared/footer');
    }
}
