<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table              = 'users';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['name', 'lastname', 'email', 'password', 'last_login', 'active', 'photo', 'parent', 'rol', 'ocupation', 'telephone', 'email_secondary', 'cellphone', 'ext', 'date_entry', 'date_discharge', 'employee_number', 'hide_emails', 'ghost', 'has_ghost', 'real_parent', 'department'];
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
             ->join('users as real_parent', 'real_parent.id = users.real_parent', 'left')
             ->join('departments', 'departments.id = users.department', 'left')
             ->select('users.*, ocupations.name as ocupation_name, CONCAT(parent.name, " ", parent.lastname) as parent_name, CONCAT(users.name, " ", users.lastname) as complete_name, CONCAT(real_parent.name, " ", real_parent.lastname) as real_parent_complete_name, departments.name as department_name');
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }
   
    public function getDirectory()
    {

        $this->join('ocupations', 'ocupations.id = users.ocupation')
             ->join('users as parent', 'parent.id = users.parent', 'left')
             ->select('users.*, ocupations.name as ocupation_name, CONCAT(parent.name, " ", parent.lastname) as parent_name, CONCAT(users.name, " ", users.lastname) as complete_name')
             ->where('users.active', 1);

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function createUser($name, $lastname, $email, $password, $photo, $telephone, $rol, $ocupation, $department, $parent, $email_secondary, $cellphone, $ext, $date_entry, $employee_number, $hide_emails, $ghost, $has_ghost, $real_parent)
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
            'department'  => $department,
            'parent'      => $parent,
            'email_secondary' => $email_secondary,
            'cellphone'   => $cellphone,
            'ext'         => $ext,
            'date_entry'  => $date_entry,
            'employee_number' => $employee_number,
            'hide_emails' => $hide_emails,  
            'ghost'       => $ghost,
            'has_ghost'   => $has_ghost,
            'real_parent' => $real_parent,
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
    
    public function setNewParent($id, $parent)
    {
        return $this->update($id, [
            'parent' => $parent,
        ]);
    }

    public function deleteGhost($id)
    {
        return $this->delete($id, true);
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
    
    public function updateUser($id, $name, $lastname, $email, $photo, $telephone, $rol, $ocupation, $department, $parent, $email_secondary, $cellphone, $ext, $date_entry, $date_discharge, $employee_number, $hide_emails, $ghost, $has_ghost, $real_parent)
    {
        return $this->update($id, [
            'name'        => $name,
            'lastname'    => $lastname,
            'email'       => $email,
            'photo'       => $photo,
            'telephone'   => $telephone,
            'rol'         => $rol,
            'ocupation'   => $ocupation,
            'department'  => $department,
            'parent'      => $parent,
            'email_secondary' => $email_secondary,
            'cellphone'   => $cellphone,
            'ext'         => $ext,
            'date_entry'  => $date_entry,
            'date_discharge' => $date_discharge,
            'employee_number' => $employee_number,
            'hide_emails' => $hide_emails,
            'ghost'       => $ghost,
            'has_ghost'   => $has_ghost,
            'real_parent' => $real_parent,
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

    public function getOrganizationChart()
    {
        $users = $this->join('ocupations', 'ocupations.id = users.ocupation')
                ->select('users.id, CONCAT(users.name, " ", users.lastname) as name, ocupations.name as title, users.parent as pid, users.photo, users.ghost')
                ->where('users.active', 1)
                ->findAll();

        // Convertir el resultado en un arreglo asociativo con el ID del usuario como clave
        $usersById = [];
        foreach ($users as $user) {
            $usersById[$user->id] = [
                'id'    => $user->id,
                'name'  => $user->name,
                'title' => $user->title,
                'pid'   => $user->pid,
                'img'   => base_url($user->photo), 
                'ghost' => $user->ghost == 1 ? true : false,
                'children' => []
            ];
        }

        // Construir la estructura del árbol
        $tree = [];
        foreach ($usersById as &$user) {
            if ($user['pid'] === null) {
                $tree[] = &$user;
            } else {
                if (isset($usersById[$user['pid']])) {
                    $usersById[$user['pid']]['children'][] = &$user;
                }
            }
        }

        // Devolver el nodo raíz
        return $tree[0];
    }
    
    public function getOrganizationChartByDepartment($department)
    {

        $users = $this->join('ocupations', 'ocupations.id = users.ocupation')
            ->select('users.id, CONCAT(users.name, " ", users.lastname) as name, ocupations.name as title, users.parent as pid, users.photo, users.ghost')
            ->where('users.active', 1)
            ->where('users.department', $department)
            ->findAll();

        // Convertir el resultado en un arreglo asociativo con el ID del usuario como clave
        $usersById = [];
        foreach ($users as $user) {
            $usersById[$user->id] = [
            'id'    => $user->id,
            'name'  => $user->name,
            'title' => $user->title,
            'pid'   => isset($usersById[$user->pid]) ? $user->pid : null,
            'img'   => base_url($user->photo), 
            'ghost' => $user->ghost == 1 ? true : false,
            'children' => []
            ];
        }

        // Construir la estructura del árbol
        $tree = [];
        foreach ($usersById as &$user) {
            if ($user['pid'] === null) {
            $tree[] = &$user;
            } else {
            if (isset($usersById[$user['pid']])) {
                $usersById[$user['pid']]['children'][] = &$user;
            }
            }
        }

        // Devolver el nodo raíz
        return $tree[0];
    }
}
