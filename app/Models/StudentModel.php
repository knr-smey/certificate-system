<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class StudentModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    /**
     * Example: students for a class_id
     * Adjust to your real schema (session_id/team_id, etc).
     */
    public function getStudentsByClassId(int $classId): array
    {
        $st = $this->pdo->prepare("SELECT id, student_name, role FROM students WHERE class_id = ? ORDER BY id DESC");
        $st->execute([$classId]);
        return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
