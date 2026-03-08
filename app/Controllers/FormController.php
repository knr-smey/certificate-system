<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CertificateClassFreeModel;

final class FormController extends Controller
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

        // Get paginated certificates from database
        $certificates = $this->certificateClassFreeModel->getAllPaginated($page, $limit);
        $totalCount = $this->certificateClassFreeModel->getCount();
        $totalPages = ceil($totalCount / $limit);

        $this->view('Form/class-free-form', [
            'errors' => [],
            'old' => [],
            'message' => '',
            'certificates' => $certificates,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalCount,
            'showCertificate' => false,
            'certificateData' => null,
            'generatedId' => $generatedId
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

        $certificates = $this->certificateClassFreeModel->getAllPaginated(1, 5);
        $totalCount = $this->certificateClassFreeModel->getCount();
        $totalPages = ceil($totalCount / 5);

        if (!empty($errors)) {
            $this->view('Form/class-free-form', [
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
                'generatedId' => $generatedId
            ]);
            return;
        }

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
                'generatedId' => $generatedId
            ]);
            return;
        }

        // Get updated certificates from database
        $certificates = $this->certificateClassFreeModel->getAllPaginated(1, 5);
        $totalCount = $this->certificateClassFreeModel->getCount();
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
            'generatedId' => $generatedId
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
