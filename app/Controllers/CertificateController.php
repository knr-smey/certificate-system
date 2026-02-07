<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ClassModel;
use App\Models\StudentModel;

final class CertificateController extends Controller
{
    public function index(): void
    {
        // Just show page; data loads via AJAX from API routes
        $this->view('certificate/index', [
            'title' => 'Certificate',
        ]);
    }

    public function getClasses(): void
    {
        // example
        try {
            $type = (string)($_GET['type'] ?? 'normal');  // normal|free|scholarship
            $course = (string)($_GET['course'] ?? '');    // optional filter

            $model = new ClassModel();
            $classes = $model->getFinishedClasses($type, $course);

            $this->jsonResponse(true, $classes);
        } catch (\Throwable $e) {
            $this->jsonResponse(false, [], $e->getMessage(), 500);
        }
    }

    public function getStudents(): void
    {
        // example
        try {
            $classId = (int)($_GET['class_id'] ?? 0);
            if ($classId <= 0) {
                throw new \RuntimeException('Invalid class_id');
            }

            $model = new StudentModel();
            $students = $model->getStudentsByClassId($classId);

            $this->jsonResponse(true, $students);
        } catch (\Throwable $e) {
            $this->jsonResponse(false, [], $e->getMessage(), 500);
        }
    }
}
