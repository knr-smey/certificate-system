<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ClassModel;
use App\Models\StudentModel;

final class CertificateController extends Controller
{
    // Show the main certificate page
    public function index(): void
    {
        $type = $_GET['type'] ?? 'normal';

        // If type is 'free', redirect to the form
        if ($type === 'free') {
            header('Location: /form');
            exit;
        }

        // Decide which view to load based on type
        if ($type === 'normal') {
            // Default is showing teachers table
            $this->view('components/tables/table_teacher', [
                'title' => 'Certificate',
                'type' => $type
            ]);
        } else {
            $this->view('certificate/error', [
                'message' => 'Invalid certificate type.'
            ]);
        }
    }

    // Return JSON of finished classes
    public function getClasses(): void
    {
        try {
            $type = (string)($_GET['type'] ?? 'normal');
            $course = (string)($_GET['course'] ?? '');

            $model = new ClassModel();
            $classes = $model->getFinishedClasses($type, $course);

            $this->jsonResponse(true, $classes);

        } catch (\Throwable $e) {
            $this->jsonResponse(false, [], $e->getMessage(), 500);
        }
    }

    // Return JSON of students by class
    public function getStudents(): void
    {
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

    // Show the students table page
    public function students(): void
{
    $this->view('certificate/index', [
        'title' => 'liststudents',
        'type'  => $_GET['type'] ?? 'normal'
    ]);
}
}
