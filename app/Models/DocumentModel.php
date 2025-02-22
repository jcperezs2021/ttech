<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model{

    protected $table              = 'documents';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['name', 'type', 'icon', 'parent', 'path'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getDocumentFolders($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getDocumentFolderByName($name)
    {
        return $this->where('name', $name)->first();
    }

    public function createDocumentFolder($name)
    {
        $data = [
            'name'     => $name
        ];

        return $this->insert($data);
    }

    public function updateDocumentFolder($id, $name)
    {
        return $this->update($id, [
            'name' => $name,
        ]);
    }
    
    public function deleteDocumentFolder($id)
    {
        return $this->delete(['id' => $id]);
    }
}
