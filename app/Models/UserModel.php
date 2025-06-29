<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    protected $table              = 'users';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['name', 'lastname', 'email', 'password', 'last_login', 'active', 'photo', 'parent', 'rol', 'ocupation', 'telephone', 'email_secondary', 'cellphone', 'ext', 'date_entry', 'date_discharge', 'employee_number', 'hide_emails', 'ghost', 'has_ghost', 'real_parent', 'department', 'niveles'];
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

    public function createUser($name, $lastname, $email, $password, $photo, $telephone, $rol, $ocupation, $department, $parent, $email_secondary, $cellphone, $ext, $date_entry, $employee_number, $hide_emails, $ghost, $has_ghost, $real_parent, $niveles)
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
            'niveles'     => $niveles,
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
    
    public function updateUser($id, $name, $lastname, $email, $photo, $telephone, $rol, $ocupation, $department, $parent, $email_secondary, $cellphone, $ext, $date_entry, $date_discharge, $employee_number, $hide_emails, $ghost, $has_ghost, $real_parent, $niveles)
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
            'niveles'     => $niveles,
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

    private function buildOrganizationTree($users)
    {
        // 1. Construir arreglo asociativo
        $usersById = [];
        foreach ($users as $user) {
            $usersById[$user->id] = [
                'id'      => $user->id,
                'name'    => $user->name,
                'title'   => $user->title,
                'pid'     => $user->pid, // temporal, se ajusta después
                'img'     => base_url($user->photo),
                'ghost'   => $user->ghost == 1 ? true : false,
                'niveles' => $user->niveles,
                'children'=> []
            ];
        }

        // 2. Ajustar pid si el padre no está en el arreglo
        foreach ($usersById as &$user) {
            if ($user['pid'] !== null && !isset($usersById[$user['pid']])) {
                $user['pid'] = null;
            }
        }
        unset($user); // Rompe la referencia

        // 3. Contar cuántos nodos raíz hay (pid == null)
        $rootCount = 0;
        foreach ($usersById as $user) {
            if ($user['pid'] === null) {
                $rootCount++;
            }
        }

        // 4. Si hay más de uno, usar nodo raíz fake
        if ($rootCount > 1) {
            $rootUser = [
                'id'      => 10000001,
                'name'    => "Trantor Technologies",
                'title'   => null,
                'pid'     => null,
                'img'     => base_url('assets/images/logos/logo-2.png'),
                'ghost'   => false,
                'ghost_p' => true,
                'niveles' => null,
                'children'=> []
            ];

            $usersById = [10000001 => $rootUser] + $usersById;

            // Asignar el root fake como padre a los nodos raíz
            foreach ($usersById as &$user) {
                if ($user['id'] != 10000001 && $user['pid'] === null) {
                    $user['pid'] = 10000001;
                }
            }
            unset($user);
        }

        // 5. Construir el árbol
        foreach ($usersById as &$user) {
            if ($user['pid'] !== null && isset($usersById[$user['pid']])) {
                $usersById[$user['pid']]['children'][] = &$user;
            }
        }
        unset($user);

        // 6. Devolver el nodo raíz (fake si hay varios, único si solo hay uno)
        if (isset($usersById[10000001])) {
            return $usersById[10000001];
        } else {
            // Solo uno, buscar el nodo raíz real
            foreach ($usersById as $user) {
                if ($user['pid'] === null) {
                    return $user;
                }
            }
        }
        return null; // Por si muere
    }

    public function getOrganizationChart()
    {
        $users = $this->join('ocupations', 'ocupations.id = users.ocupation')
            ->select('users.id, CONCAT(users.name, " ", users.lastname) as name, ocupations.name as title, users.parent as pid, users.photo, users.ghost, users.niveles')
            ->where('users.active', 1)
            ->findAll();

        return $this->buildOrganizationTree($users);
    }

    public function getOrganizationChartByDepartment($department)
    {
        $users = $this->join('ocupations', 'ocupations.id = users.ocupation')
            ->select('users.id, CONCAT(users.name, " ", users.lastname) as name, ocupations.name as title, users.parent as pid, users.photo, users.ghost, users.niveles')
            ->where('users.active', 1)
            ->where('users.department', $department)
            ->findAll();

        return $this->buildOrganizationTree($users);
    }
}
