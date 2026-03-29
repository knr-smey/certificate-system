<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ClassModel;
use App\Models\StudentModel;
use App\Models\CertificateClassFreeModel;
use App\Core\Database; 

final class CertificateController extends Controller
{
    /**
     * Main certificate page
     */
    public function index(): void
    {
        $type = $_GET['type'] ?? 'free';

        switch ($type) {

            case 'free':
                $this->showFreeCertificate();
                break;

            case 'normal':
                $this->view('components/tables/table_teacher', [
                    'title' => 'Certificate',
                    'type'  => 'normal'
                ]);
                break;

            case 'scholarship':
                $this->view('certificate/scholarship', [
                    'title' => 'Certificate',
                    'type'  => 'scholarship'
                ]);
                break;

            default:
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

            $type   = $_GET['type'] ?? '';
            $course = $_GET['course'] ?? '';

            // 🔥 map type
            $typeMap = [
                'normal' => 1,
                'free'   => 2
            ];

            $typeId = $typeMap[$type] ?? '';

            $model   = new ClassModel();
            $classes = $model->getFinishedClasses((string)$typeId, (string)$course);

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

            $model    = new StudentModel();
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
     * Get printed student ids for a class (normal certificates)
     */
    public function getPrintedNormalStudents(): void
    {
        try {
            $classId = (int) ($_GET['class_id'] ?? 0);
            if ($classId <= 0) {
                throw new \RuntimeException('Invalid class_id');
            }

            $stmt = Database::pdo()->prepare("
                SELECT DISTINCT student_id
                FROM student_certificate_normal
                WHERE class_id = :class_id
            ");
            $stmt->execute(['class_id' => $classId]);
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

            $studentIds = array_map(static fn(array $r): int => (int)$r['student_id'], $rows);
            $this->jsonResponse(true, ['student_ids' => $studentIds]);
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

    // ════════════════════════════════════════════════════
    // ✅ METHOD ថ្មី — បង្កើត Certificate ID តាម AJAX
    // URL: GET /api/generate-id
    // ════════════════════════════════════════════════════
    public function generateId(): void
    {
        try {

            $id = generateId(); // ហៅពី app/Helper/certificate-helper.php

            $this->jsonResponse(true, ['id' => $id]);

        } catch (\Throwable $e) {

            $this->jsonResponse(false, [], $e->getMessage(), 500);
        }
    }

public function saveCertificateNormal(): void
{
    try {
        $body = json_decode(file_get_contents('php://input'), true);
        $studentId   = (int)   ($body['student_id']     ?? 0);
        $classId     = (int)   ($body['class_id']       ?? 0);
        $studentName = (string)($body['student_name']   ?? '');
        $course      = (string)($body['course']         ?? '');
        $grantedDate = (string)($body['granted_date']   ?? '');
        $certId      = (string)($body['certificate_id'] ?? '');

        if ($studentId <= 0 || $classId <= 0 || !$studentName || !$course) {
            throw new \RuntimeException('Missing required fields');
        }
        $pdo = Database::pdo();
        
        $stmt = Database::pdo()->prepare("
            INSERT INTO student_certificate_normal
                (student_id, class_id, student_name, course, granted_date, certificate_id)
            VALUES
                (:student_id, :class_id, :student_name, :course, :granted_date, :certificate_id)
        ");
        $stmt->execute([
            'student_id'     => $studentId,
            'class_id'       => $classId,
            'student_name'   => $studentName,
            'course'         => $course,
            'granted_date'   => $grantedDate,
            'certificate_id' => $certId,
        ]);

        $insertedId = $pdo->lastInsertId();

        $this->jsonResponse(true, [
            'id' => $insertedId,
            'student_id' => $studentId
        ], 'Saved successfully');

    } catch (\Throwable $e) {
        $this->jsonResponse(false, [], $e->getMessage(), 500);
    }
}
}
