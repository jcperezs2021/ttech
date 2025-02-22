<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OcupationModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->userModel        = new UserModel();
        $this->ocupationModel   = new OcupationModel();
    }
    
    public function index(): string
    {
        $users   = $this->userModel->getUsers();
        return   view('shared/header',          ['title'        => 'Usuarios'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/user/user',        ['users'        => $users])
                .view('shared/footer');
    }
   
    public function newUser(): string
    {
        return   view('shared/header',          ['title'        => 'Nuevo usuario'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/admin/user/user-new',    [
                                                            'ocupations'   => $this->ocupationModel->getOcupations(),
                                                            'users'        => $this->userModel->getUsers(),
                                                            'csrfName'     => csrf_token(),
                                                            'csrfHash'     => csrf_hash()
                                                        ])
                .view('shared/footer');
    }
   
    public function editUser($id)
    {
        $data['csrfName']   = csrf_token();
        $data['csrfHash']   = csrf_hash();
        $data['user']       = $this->userModel->getUsers($id);
        $data['users']      = $this->userModel->getUsers();
        $data['ocupations'] = $this->ocupationModel->getOcupations();
        
        if ($data['user']) {
            return   
                view('shared/header',          ['title'        => "Editar usuario"])
               .view('shared/sidebar')
               .view('shared/navbar')
               .view('pages/admin/user/user-edit',   ['data'        => $data])
               .view('shared/footer');
        } else {
            return redirect()->to('/user');
        }
    }

    public function profile(): string
    {
        $users   = $this->userModel->getUsers();
        return   view('shared/header',              ['title'        => 'Mi perfil'])
                .view('shared/sidebar')
                .view('shared/navbar')
                .view('pages/shared/profile/profile-home', [
                                                                'user'         => $this->userModel->getUsers(session('user')->id),
                                                                'csrfName'     => csrf_token(),
                                                                'csrfHash'     => csrf_hash(),
                                                            ])
                .view('shared/footer');
    }

    public function updatePassword()
    {

        // Obtenemos variables
        $oldPassword                = $this->request->getPost('oldPassword');
        $password                   = $this->request->getPost('password');
        $password_confirmation      = $this->request->getPost('password_confirmation');
        $user                       = $this->userModel->getUsers(session('user')->id);

        // Verificamos que la contraseña actual no sea vacía y tenga mas de 6 caracteres
        if (empty($password) || strlen($password) < 6) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.auth_invalid_password_format'),
            ]);
        }

        // Verificamos si la contraseña actual es correcta
        if (!password_verify($oldPassword, $user->password)){
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.auth_invalid_credentials'),
            ]);
        }

        // Verificamos si las contraseñas coinciden
        if ($password !== $password_confirmation) {
            return $this->respondWithCsrf([
                'ok'            => false,
                'error'         => lang('Errors.auth_password_not_match'),
            ]);
        }

        // Actualizamos la contraseña hasheada
        $this->userModel->setNewPassword(session('user')->id, password_hash($password, PASSWORD_BCRYPT));

        // Actualizamos la sesión
        $this->refreshSession();

        // Respondemos
        return $this->respondWithCsrf([
            'ok'            => true,
            'message'       => lang('Success.auth_password_updated'),
        ]);
    }

    public function updatePhoto()
    {
        // Obtenemos la imagen
        $photo = $this->request->getFile('photo');

        // Verificamos si la imagen es válida
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {

            // Obtenemos usuario
            $actualUser = $this->userModel->getUsers(session('user')->id);

            // Subir la imagen
            if (!$this->handlePhotoUpload($photo)) {

                // En caso de error
                return $this->respondWithCsrf([
                    'ok'            => false,
                    'message'       => lang('Errors.gral_upload_file_error'),
                ]);
            }

            // Eliminar la imagen anterior
            if (file_exists(ROOTPATH . 'public/' . $actualUser->photo)) {
                unlink(ROOTPATH . 'public/' . $actualUser->photo);
            }

            // Crear nuevo nombre
            $newName    = $photo->getName();
            $newImage   = 'uploads/images/profiles/' . $newName;

            // Actualizar usuario en la base de datos
            if($this->userModel->setNewPhoto(session('user')->id, $newImage)){

                // Actualizar la sesión
                $this->refreshSession();

                // Respondemos
                return $this->respondWithCsrf([
                    'ok'            => true,
                    'message'       => lang('Success.auth_photo_updated'),
                ]);
            }

            // En caso de error
            return $this->respondWithCsrf([
                'ok'            => false,
                'message'       => lang('Errors.error_try_again_later'),
            ]);

        }else{

            // Respondemos
            return $this->respondWithCsrf([
                'ok'            => false,
                'message'       => lang('Errors.auth_invalid_image'),
            ]);
        }
    }

    private function handlePhotoUpload($photo) : bool
    {
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {

            if (in_array($photo->getClientMimeType(), ['image/jpeg', 'image/png'])) {

                $uploadPath = ROOTPATH . 'public/uploads/images/profiles';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $photo->getRandomName();
                $photo->move($uploadPath, $newName);

                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
    }

    private function refreshSession()
    {
        $user = $this->userModel->getUsers(session('user')->id);
        $this->session->set('user', $user);
    }
}
