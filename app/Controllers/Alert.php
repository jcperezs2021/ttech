<?php

namespace App\Controllers;

use App\Models\AlertModel;

class Alert extends BaseController
{
    protected $alertModel;

    public function __construct()
    {
        $this->alertModel = new AlertModel();
    }

    public function index(): string
    {
        return   view('shared/header',              ['title'     => 'Alertas'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/shared/alerts/alerts',        [
                                                        'csrfName'  => csrf_token(),
                                                        'csrfHash'  => csrf_hash(),
                                                        'alerts'    => $this->alertModel->getAlerts(session()->get('user')->id)
                                                    ])
                .view('shared/footer');
    }

    public function getUnreadAlerts()
    {
        return $this->response->setJSON([
            'ok'            => true,
            'alerts'        => $this->alertModel->getUnreadAlerts(session()->get('user')->id),
        ]);
    }

    public function markAlertAsRead($id)
    {
        return $this->respondWithCsrf([
            'ok' => $this->alertModel->updateAlertReaded($id, 1),
        ]);
    }
}
