<?php

namespace App\Models;

use CodeIgniter\Model;

class FeedCommentModel extends Model{

    protected $table              = 'feed_comments';
    protected $primaryKey         = 'id';
    protected $useAutoIncrement   = true;
    protected $returnType         = "object";
    protected $useSoftDeletes     = true;
    protected $allowedFields      = ['author', 'content', 'feed'];
    protected $useTimestamps      = true;
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
    protected $deletedField       = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    public function getFeedComments($id = null)
    {
        if($id !== null){
            return $this->find($id);
        }

        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function createFeedComment($author, $feed, $content)
    {
        $data = [
            'author'     => $author,
            'feed'       => $feed,
            'content'    => $content
        ];

        return $this->insert($data);
    }

    public function updateFeedComment($id, $content)
    {
        return $this->update($id, [
            'content' => $content,
        ]);
    }
    
    public function deleteFeedComment($id)
    {
        return $this->delete(['id' => $id]);
    }
}
