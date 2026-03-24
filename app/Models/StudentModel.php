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
            s.name,
            s.phone AS tel,
            c.course,
            'Male' AS gender
        FROM students s
        INNER JOIN classes c ON c.id = s.class_id
        WHERE s.class_id = ?
        ORDER BY s.id ASC
    ");
    $st->execute([$classId]);
    return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
}
}
