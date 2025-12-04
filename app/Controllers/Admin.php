<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Admin extends Controller {

    protected $db;
    protected $session;
    protected $quiz_takers;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->quiz_takers = $this->db->table('quiz_takers');
    }

    // 1. Show Admin Dashboard
    public function dashboard()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return redirect()->to('admin_login');
        }

        // Get all results
        $data['results'] = $this->quiz_takers->orderBy('created_at', 'DESC')->get()->getResultArray();
        
        return view('admin_dashboard', $data);
    }

    // 2. Update Admin Profile
    public function update_profile()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return redirect()->to('admin_login');
        }

        $request = \Config\Services::request();
        $username = trim($request->getPost('username'));
        $password = trim($request->getPost('password'));

        $data = [];
        if (!empty($username)) {
            $data['username'] = $username;
        }
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        if (!empty($data)) {
            $this->db->table('admins')->where('id', 1)->update($data); // Assuming single admin with ID 1
            $this->session->setFlashdata('success', 'Profile updated successfully.');
        } else {
            $this->session->setFlashdata('error', 'No changes made.');
        }

        return redirect()->to('dashboard');
    }
    // 3. View Result Details
    public function result_details($id)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return redirect()->to('admin_login');
        }

        $result = $this->quiz_takers->where('id', $id)->get()->getRowArray();
        
        if (!$result) {
            return redirect()->to('dashboard');
        }

        return view('admin_result_details', ['result' => $result]);
    }

    // 4. View All Questions
    public function all_questions()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return redirect()->to('admin_login');
        }

        return view('admin_questions_view');
    }

    // 5. Delete Result
    public function delete_result($id)
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'admin') {
            return redirect()->to('admin_login');
        }

        $this->quiz_takers->where('id', $id)->delete();
        $this->session->setFlashdata('success', 'Record deleted successfully.');
        
        return redirect()->to('dashboard');
    }
}