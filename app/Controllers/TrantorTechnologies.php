<?php

namespace App\Controllers;

class TrantorTechnologies extends BaseController
{

    public function __construct()
    {
    }

    public function index(): string
    {
        
        return   view('shared/header',      ['title'     => 'Trantor Technologies'])
                .view('shared/sidebar')
                .view('pages/user/trantor-technologies/trantor-technologies')
                .view('shared/footer');
    }
}
