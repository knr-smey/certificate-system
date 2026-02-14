<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use PDO;

final class FormController extends Controller
{
    public function index(): void
    {
        $courses = $this->getCourses();

        // Generate CSRF token
        $csrfToken = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        $this->view('Form/class-free-form', [
            'courses' => $courses,
            'csrfToken' => $csrfToken,
            'message' => '', // optional message placeholder
        ]);
    }

    public function submit(): void
    {
        $studentName = trim($_POST['student_name'] ?? '');
        $course      = trim($_POST['course'] ?? '');
        $token       = $_POST['csrf_token'] ?? '';

        // CSRF validation
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->redirectWithMessage('form', 'Invalid CSRF token!');
            return;
        }

        // Input validation
        if ($studentName === '' || $course === '') {
            $this->redirectWithMessage('form', 'All fields are required!');
            return;
        }

        try {
            $pdo = Database::pdo();
            $pdo->beginTransaction();

            // Get class info
            $stmt = $pdo->prepare(
                "SELECT id, user_id 
                 FROM classes 
                 WHERE course = :course 
                 LIMIT 1"
            );
            $stmt->execute(['course' => $course]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$class) {
                $pdo->rollBack();
                $this->redirectWithMessage('form', 'Selected course not found!');
                return;
            }

            $classId = (int) $class['id'];
            $userId  = (int) $class['user_id'];

            // Insert student
            $stmt = $pdo->prepare(
                "INSERT INTO students (name, user_id, class_id)
                 VALUES (:name, :user_id, :class_id)"
            );
            $stmt->execute([
                'name'     => $studentName,
                'user_id'  => $userId,
                'class_id' => $classId
            ]);

            $pdo->commit();

            $this->redirectWithMessage('form', 'Student registered successfully!');

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $this->redirectWithMessage('form', 'Error occurred while inserting student.');
        }
    }

    private function getCourses(): array
    {
        $pdo = Database::pdo();
        $stmt = $pdo->query("SELECT DISTINCT course FROM classes ORDER BY course");
        $courses = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $courses ?: [];
    }

    private function redirectWithMessage(string $route, string $message): void
    {
        // Simple approach: store message in session and redirect
        $_SESSION['form_message'] = $message;
        header("Location: /$route");
        exit;
    }
}
