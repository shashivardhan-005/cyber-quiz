<?php namespace App\Models;
use CodeIgniter\Model;

class QuizTakerModel extends Model {
    protected $table = 'quiz_takers';
    protected $allowedFields = ['full_name', 'email', 'score', 'status', 'completed_at', 'responses'];
}