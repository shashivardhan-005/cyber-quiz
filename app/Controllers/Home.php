<?php namespace App\Controllers;
use App\Models\QuizTakerModel;

class Home extends BaseController {
    
    public function index() {
        return view('home_login_view');
    }

    public function attemptLogin() {
        $session = session();
        $name = trim($this->request->getVar('full_name'));
        $email = trim($this->request->getVar('email'));

        // 1. ADMIN REDIRECT LOGIC
        if (strtolower($name) === 'admin' || strtolower($email) === 'admin') {
            return redirect()->to('/admin/login');
        }

        // 2. USER LOGIN LOGIC
        $model = new QuizTakerModel();

        // Check if this email has already completed the quiz
        $existingUser = $model->where('email', $email)->first();

        if ($existingUser && $existingUser['score'] !== null) {
            // User already finished the quiz
            $session->setFlashdata('error', 'Access Denied: You have already completed this training module.');
            return redirect()->to('/');
        }

        // Set Session Data for User
        $userData = [
            'full_name' => $name,
            'email'     => $email,
            'role'      => 'user',
            'isLoggedIn'=> true
        ];
        $session->set($userData);

        // Redirect to Instructions
        return redirect()->to('/quiz/instructions');
    }
}