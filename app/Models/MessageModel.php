<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    /**
     * Get the conversation between two users, sorted by time ascending.
     * @param int $userId
     * @param int $otherUserId
     * @param int $limit
     * @return array
     */
    public function getConversation($userId, $otherUserId, $limit = 100)
    {
        return $this->where("(sender_id = $userId AND receiver_id = $otherUserId) OR (sender_id = $otherUserId AND receiver_id = $userId)")
            ->orderBy('created_at', 'ASC')
            ->limit($limit)
            ->findAll();
    }

    /**
     * Get new messages in the conversation since a given ISO8601 timestamp.
     * @param int $userId
     * @param int $otherUserId
     * @param string $since ISO8601 timestamp
     * @return array
     */
    public function getNewMessagesSince($userId, $otherUserId, $since)
    {
        return $this->where("(sender_id = $userId AND receiver_id = $otherUserId) OR (sender_id = $otherUserId AND receiver_id = $userId)")
            ->where('created_at >', $since)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }
    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sender_id', 'receiver_id', 'message', 'created_at'];
    protected $useTimestamps = false;
}
