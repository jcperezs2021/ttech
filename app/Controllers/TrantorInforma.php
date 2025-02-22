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
                .view('pages/user/trantor-informa/trantor-informa')
                .view('shared/footer');
    }
}
