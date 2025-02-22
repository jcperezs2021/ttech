<?php

namespace App\Models;

use CodeIgniter\Model;

class AlertModel extends Model{

    protected $table              = 'alerts';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['type', 'message', 'readed', 'user', 'data'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getAlerts($user, $offset = null, $limit = null)
    {
        if($offset == null && $limit == null)
            return $this->where('user', $user)->orderBy('created_at', 'DESC')->findAll();
        else
        return $this->where('user', $user)->orderBy('created_at', 'DESC')->findAll($limit, $offset);
    }

    public function getUnreadAlerts($user)
    {
        return $this->where('user', $user)->where('readed', 0)->orderBy('created_at', 'DESC')->findAll();
    }
   
    public function getAlertsUnreadCount($user)
    {
        return $this->where('user', $user)->where('readed', 0)->countAllResults();
    }

    public function createAlert($type, $message, $user, $data)
    {
        $data = [
            'type'      => $type,
            'message'   => $message,
            'readed'    => 0,
            'user'      => $user,
            'data'      => $data,
        ];

        return $this->insert($data);
    }

    public function updateAlertReaded($id, $value)
    {
        return $this->update($id, ['readed' => $value]);
    }
    
    public function deleteAlert($id)
    {
        return $this->delete(['id' => $id]);
    }
}
