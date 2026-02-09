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

        $this->view('Form/class-free-form', [
            'courses' => $courses,
        ]);
    }

    public function submit(): void
    {
        $studentName = trim($_POST['student_name'] ?? '');
        $course = trim($_POST['course'] ?? '');

        if ($studentName === '' || $course === '') {
            echo "All fields are required";
            return;
        }

        try {
            $pdo = Database::pdo();
            $pdo->beginTransaction();

            
            $stmt = $pdo->prepare(
                "SELECT id, category, time, user_id 
                 FROM classes 
                 WHERE course = :course 
                 LIMIT 1"
            );
            $stmt->execute(['course' => $course]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$class) {
                $pdo->rollBack();
                echo "Selected course not found in database!";
                return;
            }

            $classId = (int) $class['id'];
            $userId = (int) $class['user_id'];

      
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

            echo "Student inserted successfully ";

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            echo "Error occurred while inserting student";
            // Optional: log $e->getMessage() in production instead of showing
        }
    }

    private function getCourses(): array
    {
        $pdo = Database::pdo();

        $stmt = $pdo->query("SELECT DISTINCT course FROM classes ORDER BY course");
        $courses = $stmt->fetchAll(PDO::FETCH_COLUMN);

       

        return $courses ?: [];
    }
}
