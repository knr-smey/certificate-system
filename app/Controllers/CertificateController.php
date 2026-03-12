<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ClassModel;
use App\Models\StudentModel;
use App\Models\CertificateClassFreeModel;

final class CertificateController extends Controller
{
    /**
     * Main certificate page
     */
    public function index(): void
    {
        $type = $_GET['type'] ?? 'free';

        // If type is 'free', show the free form
        if ($type === 'free') {
            // $csrfToken = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
            // $_SESSION['csrf_token'] = $csrfToken;

            // Pagination settings
            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
            $limit = 5; // 5 students per page

            // Get certificates from database
            $certificateModel = new CertificateClassFreeModel();
            $certificates = $certificateModel->getAllPaginated($page, $limit);
            $totalCount = $certificateModel->getCount();
            $totalPages = ceil($totalCount / $limit);

            // Generate certificate ID for display
            $generatedId = generateId();

            $this->view('Pages/class-free-form', [
                'csrfToken' => $csrfToken,
                'errors' => [],
                'old' => [],
                'certificates' => $certificates,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalCount' => $totalCount,
                'generatedId' => $generatedId
            ]);
            return;
        }

        // If type is 'normal' or 'scholarship', show the teachers table
        if ($type === 'normal' || $type === 'scholarship') {
            $this->view('components/tables/table_teacher', [
                'title' => 'Certificate',
                'type' => $type
            ]);
        } elseif ($type === 'scholarship') { 
            $this->view('certificate/scholarship', [
                'title' => 'Certificate',
                'type' => $type
            ]);
        } else {
            $this->view('certificate/error', [
                'message' => 'Invalid certificate type.'
            ]);
        }
    }

    /**
     * Free certificate page
     */
    private function showFreeCertificate(): void
    {
        $page  = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $limit = 5;

        $certificateModel = new CertificateClassFreeModel();

        $certificates = $certificateModel->getAllPaginated($page, $limit);
        $totalCount   = $certificateModel->getCount();
        $totalPages   = ceil($totalCount / $limit);

        $generatedId = generateId();

        $this->view('Pages/class-free-form', [
            'errors'       => [],
            'old'          => [],
            'certificates' => $certificates,
            'currentPage'  => $page,
            'totalPages'   => $totalPages,
            'totalCount'   => $totalCount,
            'generatedId'  => $generatedId
        ]);
    }

    /**
     * Get classes API
     */
    public function getClasses(): void
    {
        try {

            $type   = (string) ($_GET['type'] ?? 'free');
            $course = (string) ($_GET['course'] ?? '');

            $model = new ClassModel();
            $classes = $model->getFinishedClasses($type, $course);

            $this->jsonResponse(true, $classes);

        } catch (\Throwable $e) {

            $this->jsonResponse(false, [], $e->getMessage(), 500);
        }
    }

    /**
     * Get students API
     */
    public function getStudents(): void
    {
        try {

            $classId = (int) ($_GET['class_id'] ?? 0);

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

    /**
     * Get certificate date API
     */
    public function getCertificateDate(): void
    {
        try {

            $endDate = $_GET['end_date'] ?? null;

            if (!$endDate) {
                throw new \RuntimeException('end_date is required');
            }

            $certDateObj = getCertificateDate(
                10,
                15,
                'Asia/Phnom_Penh',
                true,
                $endDate
            );

            $formattedDate = $certDateObj->format('F j, Y');

            $this->jsonResponse(true, [
                'date' => $formattedDate
            ]);

        } catch (\Throwable $e) {

            $this->jsonResponse(false, [], $e->getMessage(), 500);
        }
    }

    /**
     * Students table page
     */
    public function students(): void
    {
        $this->view('certificate/index', [
            'title' => 'liststudents',
            'type'  => $_GET['type'] ?? 'free'
        ]);
    }
}