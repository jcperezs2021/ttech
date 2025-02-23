<?php

namespace App\Controllers;

use App\Models\FileModel;

class Files extends BaseController
{

    protected $fileModel;

    public function __construct()
    {
        $this->fileModel = new FileModel();
    }

    public function handleUpload()
    {

        $files = $this->request->getFiles();

        foreach ($files['images'] as $file) {

            if ($file && $file->isValid() && !$file->hasMoved()) {
    
                $allowedMimeTypes = [
                    'image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp',
                    'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                ];
    
                if (in_array($file->getClientMimeType(), $allowedMimeTypes)) {
    
                    $folder = '/uploads/files';
                    $uploadPath = ROOTPATH . 'public' . $folder;
    
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
    
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);
    
                    $this->fileModel->createFile(
                        $file->getName(),
                        $folder . '/' . $newName,
                        $file->getClientMimeType(),
                        $file->getSize(),
                    );
    
                    return $folder . '/' . $newName;
    
                } else {
                    return $this->response->setJSON([
                        'status'    => 'error',
                        'message'   => 'Tipo de archivo no permitido',
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'status'    => 'error',
                    'message'   => 'Archivo no válido o ya movido',
                ]);
            }
        }

    }


    public function handleDelete()
    {
        $fileName = $this->request->getBody(); // FilePond sends the file name in the request body
    
        // Busca el archivo en la base de datos
        $file = $this->fileModel->where('path', $fileName)->first();
    
        if ($file) {
            $filePath = ROOTPATH . 'public/uploads/files/' . $fileName;
    
            if (file_exists($filePath)) {
                unlink($filePath); // Elimina el archivo del sistema de archivos
    
                // Elimina el registro de la base de datos
                $this->fileModel->delete($file['id']);
    
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Archivo eliminado correctamente',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Archivo no encontrado',
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Archivo no encontrado en la base de datos',
            ]);
        }
    }

}
