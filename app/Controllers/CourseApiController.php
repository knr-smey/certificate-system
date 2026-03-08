<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller;
use App\Models\CertificateClassFreeModel;

final class CourseApiController extends Controller
{
    private CertificateClassFreeModel $model;
    public function __construct() {
        $this->model = new CertificateClassFreeModel();
    }

    // POST /api/course/save
    public function save(): void {
        header('Content-Type: application/json');
        $body = json_decode(file_get_contents('php://input'), true);
        $courseName = trim($body['course_name'] ?? '');
        if (empty($courseName) || strlen($courseName) < 2) {
            echo json_encode(['success' => false, 'message' => 'Invalid course name']);
            return;
        }
        $result = $this->model->saveCustomCourse(strtoupper($courseName));
        echo json_encode(['success' => $result !== false]);
    }

    // GET /api/course/list
    public function list(): void {
        header('Content-Type: application/json');
        $courses = $this->model->getAllCourses();
        echo json_encode(['courses' => $courses]);
    }
}
