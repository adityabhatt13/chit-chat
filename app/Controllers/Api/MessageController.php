<?php namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\MessageModel;
use CodeIgniter\API\ResponseTrait;

class MessageController extends BaseController {
    use ResponseTrait;

    public function send() {
        $session = session();
        if (!$session->get('isLoggedIn')) return $this->failUnauthorized('Login required');

        $data = $this->request->getJSON(true); // expects JSON
        $receiver_id = (int) ($data['receiver_id'] ?? 0);
        $text = trim($data['message_text'] ?? '');

        if (!$receiver_id || $text === '') return $this->failValidationError('Invalid payload');

        // Basic sanitation:
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        $msgModel = new MessageModel();
        $id = $msgModel->insertMessage($session->get('id'), $receiver_id, $text);

        if ($id) return $this->respondCreated(['message_id' => $id]);
        return $this->failServerError('Could not save message');
    }

    public function conversation($otherUserId = null) {
        $session = session();
        if (!$session->get('isLoggedIn')) return $this->failUnauthorized('Login required');

        $otherUserId = (int)$otherUserId;
        if (!$otherUserId) return $this->failNotFound('User not found');

        $msgModel = new \App\Models\MessageModel();
        $conv = $msgModel->getConversation($session->get('id'), $otherUserId, 500);

        return $this->respond($conv);
    }

    // polling endpoint: optionally accept ?since=ISO_DATE
    public function poll($otherUserId = null) {
        $session = session();
        if (!$session->get('isLoggedIn')) return $this->failUnauthorized('Login required');
        $userId = $session->get('id');
        if (!$userId) return $this->failUnauthorized('User ID missing in session');
        $session = session();
        if (!$session->get('isLoggedIn')) return $this->failUnauthorized('Login required');

        $otherUserId = (int)$otherUserId;
        $since = $this->request->getGet('since');
        if (!$otherUserId) return $this->failNotFound('User not found');

        $msgModel = new \App\Models\MessageModel();
        if ($since) {
            $new = $msgModel->getNewMessagesSince($userId, $otherUserId, $since);
        } else {
            $new = $msgModel->getConversation($userId, $otherUserId, 100);
        }
        return $this->respond($new);
    }
}
