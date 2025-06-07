<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentModel extends Model{

    protected $table              = 'departments';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['name'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getDepartments($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getDepartmentByName($name)
    {
        return $this->where('name', $name)->first();
    }

    public function createDepartment($name)
    {
        $data = [
            'name'     => $name
        ];

        return $this->insert($data);
    }

    public function updateDepartment($id, $name)
    {
        return $this->update($id, [
            'name' => $name,
        ]);
    }
    
    public function deleteDepartment($id)
    {
        return $this->delete(['id' => $id]);
    }
}
