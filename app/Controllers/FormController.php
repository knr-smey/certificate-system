<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class FormController extends Controller
{
    // Show the class-free form
    public function index(): void
    {
        $csrfToken = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        $this->view('Form/class-free-form', [
            'csrfToken' => $csrfToken,
            'errors' => [],
            'old' => []
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
                ]
            ]);
            return;
        }

        // Validation passed - redirect to thank you page
        header("Location: /form/thankyou", true, 302);
        exit;
    }

    // Show thank you page
    public function thankyou(): void
    {
        $this->view('Form/thankyou');
    }

    // Redirect with message
    private function redirectWithMessage(string $route, string $message): void
    {
        $_SESSION['form_message'] = $message;
        header("Location: /{$route}", true, 302);
        exit;
    }
}
