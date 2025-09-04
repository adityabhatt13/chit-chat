<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MessageModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userModel = new UserModel();
        // Fixed: Use consistent session key 'id' instead of mixing 'id' and 'user_id'
        $users = $userModel->where('id !=', session()->get('id'))->findAll();

        return view('dashboard', [
            'users' => $users,
            'chatUser' => null,
            'messages' => [] // Add empty messages array for consistency
        ]);
    }

    public function chat($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userModel = new UserModel();
        $chatUser = $userModel->find($id);

        if (!$chatUser) {
            return redirect()->to('/dashboard')->with('error', 'User not found');
        }

        $messageModel = new MessageModel();
        // Fixed: Use consistent session key 'id'
        $messages = $messageModel
            ->where('(sender_id = ' . session('id') . ' AND receiver_id = ' . $id . ') OR (sender_id = ' . $id . ' AND receiver_id = ' . session('id') . ')')
            ->orderBy('created_at', 'ASC')
            ->findAll();

        $users = $userModel->where('id !=', session('id'))->findAll();

        return view('dashboard', [
            'users' => $users,
            'chatUser' => $chatUser,
            'messages' => $messages
        ]);
    }

    public function sendMessage($receiverId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $message = trim($this->request->getPost('message'));
        
        if (empty($message)) {
            return redirect()->to('/dashboard/chat/' . $receiverId)->with('error', 'Message cannot be empty');
        }

        $messageModel = new MessageModel();

        $data = [
            'sender_id' => session('id'), // Fixed: Use consistent session key
            'receiver_id' => $receiverId,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s') // Add timestamp
        ];

        if ($messageModel->insert($data)) {
            return redirect()->to('/dashboard/chat/' . $receiverId);
        } else {
            return redirect()->to('/dashboard/chat/' . $receiverId)->with('error', 'Failed to send message');
        }
    }
}