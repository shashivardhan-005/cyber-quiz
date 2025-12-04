<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Quiz extends Controller {

    protected $db;
    protected $session;
    protected $quiz_takers;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->quiz_takers = $this->db->table('quiz_takers');
    }

    // 1. Show Instructions Page
    public function instructions()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'user') {
            return redirect()->to('/');
        }
        return view('quiz_instructions');
    }

    // 2. Start Quiz
    public function start()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') != 'user') {
            return redirect()->to('/');
        }
        return view('quiz_view');
    }

    // 3. Submit Results via AJAX/Fetch
    public function submit()
    {
        $request = \Config\Services::request();
        $json = $request->getJSON();
        
        $score = $json->score;
        $responses = isset($json->responses) ? json_encode($json->responses) : null;
        
        $email = $this->session->get('user_id'); 
        $full_name = $this->session->get('full_name');
        $device = $this->session->get('device_type');
        $screen = $this->session->get('screen_size');

        $data = [
            'full_name'   => $full_name,
            'email'       => $email,
            'score'       => $score,
            'status'      => ($score >= 70) ? 'Pass' : 'Fail',
            'device_type' => $device,
            'screen_size' => $screen,
            'responses'   => $responses
        ];

        // Check if partial record exists, update or insert
        $exists = $this->quiz_takers->where('email', $email)->countAllResults();

        if ($exists > 0) {
            $this->quiz_takers->where('email', $email)->update($data);
        } else {
            $this->quiz_takers->insert($data);
        }

        // Kill session after submission so they can't go back
        $this->session->destroy();

        return $this->response->setJSON(['status' => 'success', 'score' => $score]);
    }
}