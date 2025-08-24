<?php

namespace App\Models;

use CodeIgniter\Model;

class AreaModel extends Model{

    protected $table              = 'areas';
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
    
    public function getAreas($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getAreaByName($name)
    {
        return $this->where('name', $name)->first();
    }

    public function createArea($name)
    {
        $data = [
            'name'     => $name
        ];

        return $this->insert($data);
    }

    public function updateArea($id, $name)
    {
        return $this->update($id, [
            'name' => $name,
        ]);
    }
    
    public function deleteArea($id)
    {
        return $this->delete(['id' => $id]);
    }
}
