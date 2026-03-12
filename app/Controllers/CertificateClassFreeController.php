<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CertificateClassFreeModel;

final class CertificateClassFreeController extends Controller
{
    private CertificateClassFreeModel $certificateClassFreeModel;

    public function __construct()
    {
        $this->certificateClassFreeModel = new CertificateClassFreeModel();
    }

    // Show the class-free form
    public function index(): void
    {
        // Generate certificate ID for display
        $generatedId = generateId();

        // Pagination settings
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 5; // 5 students per page

        // Get course filter from GET parameter
        $courseFilter = isset($_GET['course_filter']) ? trim($_GET['course_filter']) : null;

        // Load courses for dropdown filter
        $courses = $this->certificateClassFreeModel->getAllCourses();

        // Get paginated certificates from database (with optional filter)
        if ($courseFilter !== null && $courseFilter !== '') {
            $certificates = $this->certificateClassFreeModel->getAllPaginatedWithFilter($page, $limit, $courseFilter);
            $totalCount = $this->certificateClassFreeModel->getCountWithFilter($courseFilter);
        } else {
            $certificates = $this->certificateClassFreeModel->getAllPaginated($page, $limit);
            $totalCount = $this->certificateClassFreeModel->getCount();
        }
        
        $totalPages = ceil($totalCount / $limit);

        $this->view('Pages/class-free-form', [
            'errors' => [],
            'old' => [],
            'message' => '',
            'certificates' => $certificates,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalCount,
            'showCertificate' => false,
            'certificateData' => null,
            'generatedId' => $generatedId,
            'courses' => $courses,
            'courseFilter' => $courseFilter
        ]);
    }

    // Handle form submission
    public function submit(): void
    {
        // Generate certificate ID for display
        $generatedId = generateId();
        
        $studentName = trim($_POST['student_name'] ?? '');
        $course      = trim($_POST['course'] ?? '');
        $endDate     = trim($_POST['end_date'] ?? '');

        $errors = [];
        if ($studentName === '') $errors['student_name'] = 'Full Name is required!';
        if ($course === '') $errors['course'] = 'Course is required!';
        if ($endDate === '') $errors['end_date'] = 'End Date is required!';

        // Load courses for dropdown filter
        $courses = $this->certificateClassFreeModel->getAllCourses();

        // Get course filter from GET parameter
        $courseFilter = isset($_GET['course_filter']) ? trim($_GET['course_filter']) : null;

        // Get paginated certificates (with optional filter)
        if ($courseFilter !== null && $courseFilter !== '') {
            $certificates = $this->certificateClassFreeModel->getAllPaginatedWithFilter(1, 5, $courseFilter);
            $totalCount = $this->certificateClassFreeModel->getCountWithFilter($courseFilter);
        } else {
            $certificates = $this->certificateClassFreeModel->getAllPaginated(1, 5);
            $totalCount = $this->certificateClassFreeModel->getCount();
        }
        $totalPages = ceil($totalCount / 5);

        if (!empty($errors)) {
            $this->view('Pages/class-free-form', [
                'errors' => $errors,
                'old' => [
                    'student_name' => $studentName,
                    'course' => $course,
                    'end_date' => $endDate
                ],
                'message' => '',
                'certificates' => $certificates,
                'currentPage' => 1,
                'totalPages' => $totalPages,
                'totalCount' => $totalCount,
                'showCertificate' => false,
                'certificateData' => null,
                'generatedId' => $generatedId,
                'courses' => $courses,
                'courseFilter' => $courseFilter
            ]);
            return;
        }

        // Save custom course to course_custom table before creating certificate
        $this->certificateClassFreeModel->saveCustomCourse($course);

        // Validation passed - save to database
        $result = $this->certificateClassFreeModel->create(
            strtoupper($studentName),
            $course,
            $endDate
        );

        if ($result === false) {
            $this->view('Form/class-free-form', [
                'errors' => ['general' => 'Failed to save certificate request!'],
                'old' => [
                    'student_name' => $studentName,
                    'course' => $course,
                    'end_date' => $endDate
                ],
                'message' => '',
                'certificates' => $certificates,
                'currentPage' => 1,
                'totalPages' => $totalPages,
                'totalCount' => $totalCount,
                'showCertificate' => false,
                'certificateData' => null,
                'generatedId' => $generatedId,
                'courses' => $courses,
                'courseFilter' => $courseFilter
            ]);
            return;
        }

        // Reload courses after submission (in case new course was added)
        $courses = $this->certificateClassFreeModel->getAllCourses();

        // Get updated certificates from database
        if ($courseFilter !== null && $courseFilter !== '') {
            $certificates = $this->certificateClassFreeModel->getAllPaginatedWithFilter(1, 5, $courseFilter);
            $totalCount = $this->certificateClassFreeModel->getCountWithFilter($courseFilter);
        } else {
            $certificates = $this->certificateClassFreeModel->getAllPaginated(1, 5);
            $totalCount = $this->certificateClassFreeModel->getCount();
        }
        $totalPages = ceil($totalCount / 5);

        // Get the latest certificate for display
        $latestCertificate = $this->certificateClassFreeModel->getLatest();

        // Show form with success message and certificate displayed below
        $this->view('Form/class-free-form', [
            'message' => 'Certificate request submitted successfully!',
            'errors' => [],
            'old' => [],
            'certificates' => $certificates,
            'currentPage' => 1,
            'totalPages' => $totalPages,
            'totalCount' => $totalCount,
            'showCertificate' => true,
            'certificateData' => $latestCertificate,
            'generatedId' => $generatedId,
            'courses' => $courses,
            'courseFilter' => $courseFilter
        ]);
    }

    // Redirect
    private function redirectWithMessage(string $route, string $message): void
    {
        header("Location: /{$route}", true, 302);
        exit;
    }

    public function showCertificate(){
        return $this->view("components.certificate.class-free-certificate");
    }

}
