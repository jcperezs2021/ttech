<?php

namespace App\Models;

use CodeIgniter\Model;

class DataExternModel extends Model{

    protected $table              = 'extern_data';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['data', 'description'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getDataExtern($id = null)
    {
        if ($id !== null) {
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function createDataExtern($data, $description)
    {
        $data = [
            'data'        => $data,
            'description' => $description
        ];

        return $this->insert($data);
    }
}
