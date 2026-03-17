<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Controller;
use App\Models\CertificateClassFreeModel;
use App\Models\CertificateModel;

final class CourseApiController extends Controller
{
    private CertificateClassFreeModel $model;
    private CertificateModel $cert;
    public function __construct() {
        $this->model = new CertificateClassFreeModel();
        $this->cert = new CertificateModel();
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

    public function list(): void {
        header('Content-Type: application/json');
        $courses = $this->model->getAllCourses();
        echo json_encode(['courses' => $courses]);
    }

    // POST 
    public function savenormal(): void {
        header('Content-Type: application/json');
        $body = json_decode(file_get_contents('php://input'), true);
        $courseName = trim($body['course_name'] ?? '');
        if (empty($courseName) || strlen($courseName) < 2) {
            echo json_encode(['success' => false, 'message' => 'Invalid course name']);
            return;
        }
        $result = $this->cert->saveCustomNormalCourse($courseName);
        echo json_encode(['success' => $result !== false]);
    }

    // GET 
    public function listcousrnormal(): void {
        header('Content-Type: application/json');
        $courses = $this->cert->getAllNormalCourse();
        echo json_encode(['courses' => $courses]);
    }
    // DELETE
    public function delete(): void {
        header('Content-Type: application/json');

        $body = json_decode(file_get_contents('php://input'), true);
        $courseName = trim($body['course_name'] ?? '');

        if (empty($courseName)) {
            echo json_encode([
                'success' => false,
                'message' => 'Course name required'
            ]);
            return;
        }

        $result = $this->cert->deleteNormalCourse($courseName);

        echo json_encode([
            'success' => $result !== false
        ]);
    }
}
