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

    public function getStudentsByClassId(int $classId): array
    {
        $st = $this->pdo->prepare("
            SELECT 
                s.id,
                s.full_name as name,
                s.tel,
                'Male' AS gender,
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM student_certificate_normal scn
                        WHERE scn.student_id = s.id
                          AND scn.class_id = s.class_id
                    ) THEN 1
                    ELSE 0
                END AS is_printed
            FROM students s
            INNER JOIN classes c ON c.id = s.class_id
            WHERE s.class_id = ?
            ORDER BY s.id ASC
        ");
        $st->execute([$classId]);
        return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
