<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\HelperUtility;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->lang             = \Config\Services::language();
        $this->lang             ->setLocale('es');
        $this->userModel        = new UserModel();
    }

    public function index(): string
    {
        return view('shared/header', ['title' => 'Login']) . view('pages/shared/auth/login');
    }

    public function register()
    {
        $email          = $this->request->getPost('email');
        $name           = $this->request->getPost('name');
        $lastname       = $this->request->getPost('lastname');
        $password       = $this->request->getPost('password');
        $password2      = $this->request->getPost('password-confirm');
        $telephone      = $this->request->getPost('telephone');
        $photo          = $this->request->getFile('photo');
        $rol            = $this->request->getPost('rol');
        $ocupation      = $this->request->getPost('ocupation');
        $parent         = $this->request->getPost('parent');

        // Validación inicial de los campos requeridos
        if (!$this->validateRegisterInput($email, $name, $lastname, $password, $password2, $telephone, $rol, $ocupation)) {
            return HelperUtility::redirectWithMessage('/user/new', lang('Errors.missing_fields'));
        }

        // Verificar si las contraseñas coinciden
        if ($password !== $password2) {
            return HelperUtility::redirectWithMessage('/user/new', lang('Errors.auth_password_not_match'));
        }

        // Verificar si el usuario ya existe
        if ($this->userModel->getUserByEmail($email)) {
            return HelperUtility::redirectWithMessage('/user/new', lang('Errors.auth_email_exist'));
        }

        // Subir la imagen
        if (!$this->handlePhotoUpload($photo)) {
            return HelperUtility::redirectWithMessage('/user/new', lang('Errors.gral_upload_file_error'));
        }
        
        // Obtener el nombre de la imagen
        $newName = $photo->getName();

        // Ruta de la imagen
        $photoURL = 'uploads/images/profiles/' . $newName;

        // Crear nuevo usuario
        if ($this->createUser($name, $lastname, $email, $password, $photoURL, $telephone, $rol, $ocupation, $parent)) {
            return HelperUtility::redirectWithMessage('/user/new', 'Usuario creado exitosamente', 'success');
        }

        // En caso de error
        return HelperUtility::redirectWithMessage('/user/new', lang('Errors.error_try_again_later'));
    }

    public function activeUser()
    {
        $id = $this->request->getPost('id');

        return $this->respondWithCsrf([
            'ok' => $this->userModel->activeUser($id),
        ]);
    }
    
    public function inactiveUser()
    {
        $user       = $this->session->get('user'); 
        $id         = $this->request->getPost('id');

        // Verificar si se quiere auto desactivar
        if($id == $user->id){
            return $this->respondWithCsrf([
                'ok'     => false,
                'error'  => lang('Errors.auth_inactive_samne_account'),
            ]);
        }
    
        return $this->respondWithCsrf([
            'ok' => $this->userModel->inactiveUser($id),
        ]);
        
    }

    public function updateUser()
    {
        $id             = $this->request->getPost('id');
        $email          = $this->request->getPost('email');
        $name           = $this->request->getPost('name');
        $lastname       = $this->request->getPost('lastname');
        $password       = $this->request->getPost('password');
        $telephone      = $this->request->getPost('telephone');
        $photo          = $this->request->getFile('photo');
        $rol            = $this->request->getPost('rol');
        $ocupation      = $this->request->getPost('ocupation');
        $parent         = $this->request->getPost('parent');

        // Validación inicial de los campos requeridos
        if (!$this->validateUpdateInput($id, $email, $name, $lastname, $telephone, $rol, $ocupation)) {
            return HelperUtility::redirectWithMessage("/user/edit/$id", lang('Errors.missing_fields'));
        }

        // Encontrar al usuario actual
        $actualUser = $this->userModel->getUsers($id);
        $newImage   = $actualUser->photo;

        // Verificar si el usuario existe
        if (!$actualUser) {
            return HelperUtility::redirectWithMessage("/user/edit/$id", lang('Errors.user_not_found'));
        }

        // En caso de modificar el correo validar si el correo existe
        if($email != $actualUser->email){
            if ($this->userModel->getUserByEmail($email)) {
                return HelperUtility::redirectWithMessage("/user/edit/$id", lang('Errors.auth_email_exist'));
            }
        }

        // En caso de modificar la imagen eliminar la anterior y guardar la nueva
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {

            // Subir la imagen
            if (!$this->handlePhotoUpload($photo)) {

                // En caso de error
                return HelperUtility::redirectWithMessage('/user/new', lang('Errors.gral_upload_file_error'));
            }

            if (file_exists(ROOTPATH . 'public/' . $actualUser->photo)) {
                unlink(ROOTPATH . 'public/' . $actualUser->photo);
            }

            $newName    = $photo->getName();
            $newImage   = 'uploads/images/profiles/' . $newName;
        }

        // En caso de modificar la contraseña setear la nueva
        if($password != ""){
            $this->setNewPassword($id, $password);
        }

        // Actualizar usuario
        if ($this->updateUserData($id, $name, $lastname, $email, $newImage, $telephone, $rol, $ocupation, $parent)) {
            return HelperUtility::redirectWithMessage("/user/edit/$id", 'Usuario actualizado exitosamente', 'success');
        }

        return HelperUtility::redirectWithMessage("/user/edit/$id", lang('Errors.error_try_again_later'));
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user     = $this->userModel->getUserByEmail($email);

        // Verificar si el usuario existe, la contraseña es válida y si esta activo
        if ($user && password_verify($password, $user->password) && $user->active == 1) {
            $this->session->set("user", $user);
            $this->userModel->setLoginUpdate($user->id);

            return redirect()->to(base_url('/trantor-informa'));
        }

        // En caso credenciales invalidas
        return HelperUtility::redirectWithMessage('/', lang('Errors.auth_invalid_credentials'));
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('/'));
    }

    // Función auxiliar para validar los campos de registro
    private function validateRegisterInput($email, $name, $lastname, $password, $password2, $telephone, $rol, $ocupation): bool
    {
        return $email && $name && $lastname && $password && $password2 && $telephone && $rol && $ocupation;
    }
    
    // Función auxiliar para validar los campos de update
    private function validateUpdateInput($id, $email, $name, $lastname, $telephone, $rol, $ocupation): bool
    {
        return $id && $email && $name && $lastname && $telephone && $rol && $ocupation;
    }

    // Función auxiliar para crear un usuario
    private function createUser(string $name, string $lastname, string $email, string $password, string $photo, string $telephone, string $rol, string $ocupation, $parent): bool
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $this->userModel->createUser($name, $lastname, $email, $passwordHash, $photo, $telephone, $rol, $ocupation, $parent);
    }
   
    // Función auxiliar para actualizar password a un usuario
    private function setNewPassword(int $id, string $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $this->userModel->setNewPassword($id, $passwordHash);
    }

    // Función auxiliar para actualizar a un usuario
    private function updateUserData(int $id, string $name, string $lastname, string $email, string $photo, string $telephone, string $rol, string $ocupation, $parent): bool
    {
        return $this->userModel->updateUser($id, $name, $lastname, $email, $photo, $telephone, $rol, $ocupation, $parent);
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
}
