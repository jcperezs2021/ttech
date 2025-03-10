<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table              = 'users';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['name', 'lastname', 'email', 'password', 'last_login', 'active', 'photo', 'parent', 'rol', 'ocupation', 'telephone', 'email_secondary', 'cellphone', 'ext'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getUsers($id = null)
    {

        $this->join('ocupations', 'ocupations.id = users.ocupation')
             ->join('users as parent', 'parent.id = users.parent', 'left')
             ->select('users.*, ocupations.name as ocupation_name, CONCAT(parent.name, " ", parent.lastname) as parent_name, CONCAT(users.name, " ", users.lastname) as complete_name');
        
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function createUser($name, $lastname, $email, $password, $photo, $telephone, $rol, $ocupation, $parent, $email_secondary, $cellphone, $ext)
    {
        $data = [
            'name'        => $name,
            'lastname'    => $lastname,
            'email'       => $email,
            'password'    => $password,
            'photo'       => $photo,
            'telephone'   => $telephone,
            'rol'         => $rol,
            'ocupation'   => $ocupation,
            'parent'      => $parent,
            'email_secondary' => $email_secondary,
            'cellphone'   => $cellphone,
            'ext'         => $ext,
        ];

        return $this->insert($data);
    }

    public function setLoginUpdate($id)
    {
        return $this->update($id, [
            'last_login' => date("Y-m-d H:i:s"),
        ]);
    }
    
    public function setNewPassword($id, $password)
    {
        return $this->update($id, [
            'password' => $password,
        ]);
    }

    public function setNewPhoto($id, $photo)
    {
        return $this->update($id, [
            'photo'       => $photo,
        ]);
    }

    public function updateProfile($id, $name, $lastname, $telephone, $cellphone, $ext)
    {
        return $this->update($id, [
            'name'        => $name,
            'lastname'    => $lastname,
            'telephone'   => $telephone,
            'cellphone'   => $cellphone,
            'ext'         => $ext,
        ]);
    }
    
    public function updateUser($id, $name, $lastname, $email, $photo, $telephone, $rol, $ocupation, $parent, $email_secondary, $cellphone, $ext)
    {
        return $this->update($id, [
            'name'        => $name,
            'lastname'    => $lastname,
            'email'       => $email,
            'photo'       => $photo,
            'telephone'   => $telephone,
            'rol'         => $rol,
            'ocupation'   => $ocupation,
            'parent'      => $parent,
            'email_secondary' => $email_secondary,
            'cellphone'   => $cellphone,
            'ext'         => $ext,
        ]);
    }

    public function activeUser($id)
    {
        return $this->update($id, [
            'active' => 1,
        ]);
    }
    
    public function inactiveUser($id)
    {
        return $this->update($id, [
            'active' => 0,
        ]);
    }

    public function getOrganization()
    {
        $users = $this->join('ocupations', 'ocupations.id = users.ocupation')
                      ->select('users.id, CONCAT(users.name, " ", users.lastname) as name, ocupations.name as title, users.parent as pid, users.photo')
                      ->findAll();

        return array_map(function($user) {
            return [
                'id'    => $user->id,
                'Puesto' => $user->title,
                'pid'   => $user->pid,
                'Nombre'  => $user->name,
                'img'   => $user->photo,
            ];
        }, $users);
    }
}
