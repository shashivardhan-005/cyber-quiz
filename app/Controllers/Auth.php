<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Auth extends Controller {

    protected $db;
    protected $session;
    protected $admins;
    protected $quiz_takers;

    public function __construct()
    {
        // Initialize Database and Session
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        
        // Define Table Builders
        $this->admins = $this->db->table('admins');
        $this->quiz_takers = $this->db->table('quiz_takers');
    }

    // 1. Show User Login Page
    public function index()
    {
        return view('login_view');
    }

    // 2. Process User Login
    public function login()
    {
        $request = \Config\Services::request();
        
        $full_name = trim($request->getPost('full_name'));
        $email = trim($request->getPost('email'));
        $screen_size = $request->getPost('screen_size');
        $device_type = ($screen_size > 700) ? 'desktop' : 'mobile';

        // Check for Admin redirection
        if (strtolower($full_name) === 'admin' || strtolower($email) === 'admin') {
            return redirect()->to('admin_login');
        }

        // Check if user already took the quiz
        $existing_user = $this->quiz_takers
                              ->where('email', $email)
                              ->where('score !=', null)
                              ->get()
                              ->getRowArray();

        if ($existing_user) {
            $this->session->setFlashdata('error', 'You have already completed this training.');
            return redirect()->to('/');
        }

        // Set User Session
        $session_data = [
            'user_id'     => $email,
            'full_name'   => $full_name,
            'role'        => 'user',
            'device_type' => $device_type,
            'screen_size' => $screen_size,
            'isLoggedIn'  => true
        ];
        $this->session->set($session_data);

        // Redirect to Instructions
        return redirect()->to('quiz/instructions');
    }

    public function check_user()
    {
        $request = \Config\Services::request();
        $full_name = trim($request->getPost('full_name'));

        if (strtolower($full_name) === 'admin') {
            return $this->response->setJSON(['status' => 'redirect', 'url' => base_url('admin_login')]);
        }

        return $this->response->setJSON(['status' => 'ok']);
    }

    // 3. Show Admin Login Page
    public function admin_login_view()
    {
        return view('admin_login_view');
    }

    // 4. Process Admin Login
    public function admin_attempt()
    {
        $request = \Config\Services::request();
        $username = $request->getPost('username');
        $password = $request->getPost('password');

        // Check Admin credentials
        $admin = $this->admins->where('username', $username)->get()->getRowArray();

        if ($admin && password_verify($password, $admin['password'])) {
            $this->session->set(['role' => 'admin', 'isLoggedIn' => true]);
            return redirect()->to('dashboard');
        } else {
            $this->session->setFlashdata('error', 'Invalid Admin Credentials');
            return redirect()->to('admin_login');
        }
    }

    // 5. Logout
    public function logout() {
        $this->session->destroy();
        return redirect()->to('/');
    }
}