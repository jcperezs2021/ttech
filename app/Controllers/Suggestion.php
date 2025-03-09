<?php

namespace App\Controllers;

use App\Models\SuggestionModel;
use App\Controllers\HelperUtility;

class Suggestion extends BaseController
{
    protected $suggestionModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->suggestionModel  = new SuggestionModel();
    }

    public function index(): string
    {
        return   view('shared/header',                                  ['title'     => 'Quejas y Suguerencias'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/user/quejas-sugerencias/quejas-sugerencias')
                .view('shared/footer');
    }

    public function createSuggestion()
    {
        $author     = session('user')->id;
        $name       = $this->request->getPost('name');
        $email      = $this->request->getPost('email');
        $title      = $this->request->getPost('title');
        $message    = $this->request->getPost('message');

        // Validar que los campos no esten vacios
        if(!$this->checkEmptyField([$author, $name, $email, $title, $message])){
            return HelperUtility::redirectWithMessage('/quejas-sugerencias', lang('Errors.missing_fields'));
        }

        // Crear la sugerencia
        if($this->suggestionModel->createSuggestion($author, $name, $email, $title, $message)){
            return HelperUtility::redirectWithMessage('/quejas-sugerencias', lang('Success.suggestion_created'), 'success');
        }
    }

    public function adminIndex(): string
    {
        return   view('shared/header',                                  ['title'     => 'Quejas y Suguerencias'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/suggestion/suggestion',              [
                                                                            'csrfName'      => csrf_token(),    
                                                                            'csrfHash'      => csrf_hash(),
                                                                        ])
                .view('shared/footer');
    }

    public function getSuggestion($id)
    {
        $suggestion = $this->suggestionModel->getSuggestions($id);
        $this->suggestionModel->updateSuggestion($id, 'open');

        if($suggestion){
            return $this->respondWithCsrf([
                'ok'            => true,
                'suggestion'    => $suggestion,
            ]);
        }

        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }


    public function getSuggestions()
    {
        $suggestions = $this->suggestionModel->getSuggestions();

         //Si el arreglo es 0 envia template vacio
         if(count($suggestions) == 0){
            return $this->respondWithCsrf([
                'ok'                => true,
                'suggestions'       => view('pages/admin/suggestion/suggestion-item-empty')
            ]);
        }else{

            // Iterar
            $suggestionsArr = [];
            foreach($suggestions as $key => $suggestion){
                $suggestionsArr[$key] = view('pages/admin/suggestion/suggestion-item', ['suggestion' => $suggestion]);
            }
    
            return $this->respondWithCsrf([
                'ok'                => true,
                'suggestions'       => $suggestionsArr,
                'suggestionsObj'    => $suggestions,
            ]);
        }

        // Error al obtener registro
        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }

    public function setStatusOpen()
    {
        $id = $this->request->getPost('id');

        if($this->suggestionModel->updateSuggestion($id, 'open')){
            return $this->respondWithCsrf([
                'ok'    => true,
            ]);
        }

        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }

    public function setStatusNew()
    {
        $id = $this->request->getPost('id');

        if($this->suggestionModel->updateSuggestion($id, 'new')){
            return $this->respondWithCsrf([
                'ok'        => true,
                'message'   => lang('Success.suggestion_status_new'),
            ]);
        }

        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }

    public function deleteSuggestion()
    {
        $id = $this->request->getPost('id');

        if($this->suggestionModel->deleteSuggestion($id)){
            return $this->respondWithCsrf([
                'ok'        => true,
                'message'   => lang('Success.suggestion_deleted'),
            ]);
        }

        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }

}
