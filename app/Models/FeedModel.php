<?php

namespace App\Models;

use CodeIgniter\Model;

class FeedModel extends Model{

    protected $table              = 'feed';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['author', 'body_content', 'file_path', 'image_path', 'likes_count', 'likes_detail'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getFeeds($id = null)
    {
        $this->select('feed.*, CONCAT(users.name, " ", users.lastname) as author_name, users.photo as author_photo, ocupations.name as author_ocupation');
        $this->join('users', 'users.id = feed.author');
        $this->join('ocupations', 'ocupations.id = users.ocupation');

        if ($id !== null) {
            return $this->where('feed.id', $id)->first();
        }

        return $this->orderBy('feed.created_at', 'DESC')->findAll();
    }

    public function createFeed($author, $body_content, $file_path = null, $image_path = null)
    {
        $data = [
            'author'        => $author,
            'body_content'  => $body_content,
            'file_path'     => $file_path,
            'image_path'    => $image_path
        ];

        return $this->insert($data);
    }
    
    public function deleteFeed($id)
    {
        $sql = "DELETE FROM feed WHERE id = :id:";
        $this->db->query($sql, ['id' => $id]);
        return $this->db->affectedRows();
    }
}
