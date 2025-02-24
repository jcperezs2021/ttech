<?php

namespace App\Controllers;

use App\Models\FeedModel;
use App\Models\FeedCommentModel;

class TrantorInforma extends BaseController
{

    protected $feedModel;
    protected $feedCommentModel;

    public function __construct()
    {
        $this->feedModel        = new FeedModel();
        $this->feedCommentModel = new FeedCommentModel();
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
    }

    public function index(): string
    {
        
        return   view('shared/header',                                  ['title'     => 'Trantor Informa'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/user/trantor-informa/trantor-informa',     [
                                                                            'csrfName'      => csrf_token(),    
                                                                            'csrfHash'      => csrf_hash(),
                                                                            'feed'          => $this->feedModel->getFeeds(),
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

    public function newFeedComment()
    {
        $author         = session()->get('user')->id;
        $feed           = $this->request->getPost('feed');
        $content        = $this->request->getPost('content');

        // Valida que los campos no vengan vacios
        if(!$this->checkEmptyField([$author, $feed, $content])){
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.missing_fields'),
            ]);
        }

        // Crear registro en BDD
        if($this->feedCommentModel->createFeedComment($author, $feed, $content)){
            return $this->respondWithCsrf([
                'ok' => true,
            ]);
        }

        // Error al crear registro
        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }

    public function newFeedLike()
    {
        $author         = session()->get('user')->id;
        $feed           = $this->request->getPost('feed');

        // Valida que los campos no vengan vacios
        if(!$this->checkEmptyField([$author, $feed])){
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.missing_fields'),
            ]);
        }

        // Obtener Feed
        $feed = $this->feedModel->getFeeds($feed);

        // Validar que el feed exista
        if($feed){

            $newLikesCount      = $feed->likes_count + 1;
            $newLikesDetail     = json_decode($feed->likes_detail);
            $newLikesDetail[]   = $author;

            // Actualizar registro en BDD
            if($this->feedModel->update($feed->id, ['likes_count' => $newLikesCount, 'likes_detail' => json_encode($newLikesDetail)])){
                return $this->respondWithCsrf([
                    'ok'        => true,
                    'likes'     => $newLikesCount,
                    'message'   => lang('Success.like_created'),
                ]);
            }

        }else{
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.feed_not_found'),
            ]);
        }
        
        // Error al crear registro
        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }

    public function removeFeedLike()
    {
        $author         = session()->get('user')->id;
        $feed           = $this->request->getPost('feed');

        // Valida que los campos no vengan vacios
        if(!$this->checkEmptyField([$author, $feed])){
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.missing_fields'),
            ]);
        }

        // Obtener Feed
        $feed = $this->feedModel->getFeeds($feed);

        // Validar que el feed exista
        if($feed){

            $newLikesCount      = $feed->likes_count - 1;
            $newLikesDetail     = json_decode($feed->likes_detail);
            $newLikesDetail     = array_diff($newLikesDetail, [$author]);

            // Actualizar registro en BDD
            if($this->feedModel->update($feed->id, ['likes_count' => $newLikesCount, 'likes_detail' => json_encode(array_values($newLikesDetail))])){
                return $this->respondWithCsrf([
                    'ok'        => true,
                    'likes'     => $newLikesCount,
                    'message'   => lang('Success.like_removed'),
                ]);
            }

        }else{
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.feed_not_found'),
            ]);
        }
        
        // Error al eliminar registro
        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }

    public function createComment()
    {
        $author         = session()->get('user')->id;
        $feed           = $this->request->getPost('feed');
        $content        = $this->request->getPost('content');

        // Valida que los campos no vengan vacios
        if(!$this->checkEmptyField([$author, $feed, $content])){
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.missing_fields'),
            ]);
        }

        // Crear comentario
        $comment = $this->feedCommentModel->createFeedComment($author, $feed, $content);

        if($comment){
            return $this->respondWithCsrf([
                'ok'              => true,
                'message'         => lang('Success.comment_created'),
                'comments_count'  => $this->feedCommentModel->getFeedCommentsCount($feed),
                'comment'         => view('pages/user/trantor-informa/trantor-informa-comment', ['comment' => $this->feedCommentModel->getFeedComment($comment)])
            ]);
        }

        // Error al crear registro
        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }

    public function getComments($feed)
    {
        // Valida que los campos no vengan vacios
        if(!$this->checkEmptyField([$feed])){
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.missing_fields'),
            ]);
        }

        // Obtener comentarios
        $comments = $this->feedCommentModel->getFeedComments($feed);

        //Si el arreglo es 0 envia template vacio
        if(count($comments) == 0){
            return $this->respondWithCsrf([
                'ok'            => true,
                'comments'      => view('pages/user/trantor-informa/trantor-informa-comment-empty')
            ]);
        }else{

            // Iterar comentarios
            $commentViews = [];
            foreach($comments as $key => $comment){
                $commentViews[$key] = view('pages/user/trantor-informa/trantor-informa-comment', ['comment' => $comment]);
            }
    
            return $this->respondWithCsrf([
                'ok'            => true,
                'comments'      => $commentViews,
            ]);
        }

        // Error al obtener registro
        return $this->respondWithCsrf([
            'ok'     => false,
            'error'  => lang('Errors.error_try_again_later'),
        ]);
    }
}
