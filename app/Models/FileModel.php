<?php

namespace App\Models;

use CodeIgniter\Model;

class FileModel extends Model{

    protected $table              = 'files';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['name', 'path', 'type', 'size'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getFiles($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function createFile($name, $path, $type, $size)
    {
        $data = [
            'name'     => $name,
            'path'     => $path,
            'type'     => $type,
            'size'     => $size,
        ];

        return $this->insert($data);
    }

    public function deleteFile($id)
    {
        return $this->delete(['id' => $id]);
    }
}
