<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentFileModel extends Model{

    protected $table              = 'documents_files';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['name', 'file', 'document', 'author'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getDocumentFiles($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getDocumentFileByDocument($document)
    {
        return $this->select('documents_files.id, documents_files.name, files.path, files.type, files.size')
            ->join('files', 'files.id = documents_files.file')
            ->where('documents_files.document', $document)
            ->orderBy('documents_files.created_at', 'DESC')
            ->findAll();
    }

    public function getDocumentFileByName($name)
    {
        return $this->where('name', $name)->first();
    }

    public function createDocumentFile( $name, $file, $document, $author)
    {
        $data = [
            'name'     => $name,
            'file'     => $file,
            'document' => $document,
            'author'   => $author
        ];

        return $this->insert($data);
    }

    public function updateDocumentFile($id, $name)
    {
        return $this->update($id, [
            'name' => $name,
        ]);
    }
    
    public function deleteDocumentFile($id)
    {
        return $this->delete(['id' => $id]);
    }
}
