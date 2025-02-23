<?php

namespace App\Controllers;

use App\Models\FeedModel;

class TrantorInforma extends BaseController
{

    protected $feedModel;

    public function __construct()
    {
        $this->feedModel        = new FeedModel();
    }

    public function index(): string
    {
        
        return   view('shared/header',                                  ['title'     => 'Trantor Informa'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/user/trantor-informa/trantor-informa',     [
                                                                            'feed'      => $this->feedModel->getFeeds(),    
                                                                        ])
                .view('shared/footer');
    }

    public function store()
    {
        // Obtener datos del formulario
        $body_content   = $this->request->getPost('publication');
        $file           = $this->request->getPost('file');
        $images         = $this->request->getPost('images');
        $author         = session()->get('user')->id;

        // Crear registro en BDD
        $this->feedModel->createFeed($author, $body_content, json_encode($file), json_encode($images));

        // Redireccionar a la vista principal
        return redirect()->to('/trantor-informa');
    }
}
