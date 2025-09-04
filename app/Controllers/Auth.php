<?php namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function signup()
    {
        helper(['form']);
        $data = [];

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
            ];

            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $userModel->save([
                    'username' => $this->request->getVar('username'),
                    'email'    => $this->request->getVar('email'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                ]);
                return redirect()->to('/auth/login')->with('success', 'Signup successful! Please login.');
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('auth/signup', $data);
    }

    public function login()
    {
        helper(['form']);
        $data = [];

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[6]',
            ];

            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $user = $userModel->where('email', $this->request->getVar('email'))->first();

                if ($user && password_verify($this->request->getVar('password'), $user['password'])) {
                    $this->setUserSession($user);
                    return redirect()->to('/dashboard');
                } else {
                    $data['error'] = 'Invalid email or password';
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }
        return view('auth/login', $data);
    }

    private function setUserSession($user)
    {
        $session = session();
        $sessionData = [
            'id'       => $user['id'],
            'username' => $user['username'],
            'email'    => $user['email'],
            'isLoggedIn' => true,
        ];
        $session->set($sessionData);
        return true;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
