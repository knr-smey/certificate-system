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
        $csrfToken = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        // Pagination settings
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 5; // 5 students per page

        // Get paginated certificates from database
        $certificates = $this->certificateClassFreeModel->getAllPaginated($page, $limit);
        $totalCount = $this->certificateClassFreeModel->getCount();
        $totalPages = ceil($totalCount / $limit);

        $this->view('Form/class-free-form', [
            'csrfToken' => $csrfToken,
            'errors' => [],
            'old' => [],
            'certificates' => $certificates,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalCount
        ]);
    }

    // Handle form submission
    public function submit(): void
    {
        $studentName = trim($_POST['student_name'] ?? '');
        $course      = trim($_POST['course'] ?? '');
        $endDate     = trim($_POST['end_date'] ?? '');
        $token       = $_POST['csrf_token'] ?? '';

        // CSRF validation
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->redirectWithMessage('form', 'Invalid CSRF token!');
            return;
        }

        $errors = [];
        if ($studentName === '') $errors['student_name'] = 'Full Name is required!';
        if ($course === '') $errors['course'] = 'Course is required!';
        if ($endDate === '') $errors['end_date'] = 'End Date is required!';

        $certificates = $this->certificateClassFreeModel->getAllPaginated(1, 5);
        $totalCount = $this->certificateClassFreeModel->getCount();
        $totalPages = ceil($totalCount / 5);

        if (!empty($errors)) {
            $csrfToken = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $csrfToken;

            $this->view('Form/class-free-form', [
                'csrfToken' => $csrfToken,
                'errors' => $errors,
                'old' => [
                    'student_name' => $studentName,
                    'course' => $course,
                    'end_date' => $endDate
                ],
                'certificates' => $certificates,
                'currentPage' => 1,
                'totalPages' => $totalPages,
                'totalCount' => $totalCount
            ]);
            return;
        }

        // Validation passed - save to database
        $csrfToken = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

      
        $result = $this->certificateClassFreeModel->create(
            strtoupper($studentName),
            $course,
            $endDate
        );

        if ($result === false) {
            $this->view('Form/class-free-form', [
                'csrfToken' => $csrfToken,
                'errors' => ['general' => 'Failed to save certificate request!'],
                'old' => [
                    'student_name' => $studentName,
                    'course' => $course,
                    'end_date' => $endDate
                ],
                'certificates' => $certificates,
                'currentPage' => 1,
                'totalPages' => $totalPages,
                'totalCount' => $totalCount
            ]);
            return;
        }

        // Get updated certificates from database
        $certificates = $this->certificateClassFreeModel->getAllPaginated(1, 5);
        $totalCount = $this->certificateClassFreeModel->getCount();
        $totalPages = ceil($totalCount / 5);

        // Redirect to certificate page with type=free
        header("Location: /certificate?type=free", true, 302);
        exit;
    }

    // Redirect
    private function redirectWithMessage(string $route, string $message): void
    {
        $_SESSION['form_message'] = $message;
        header("Location: /{$route}", true, 302);
        exit;
    }

}
