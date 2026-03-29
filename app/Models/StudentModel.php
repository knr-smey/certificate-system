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
                s.full_name AS name,
                s.tel,
                'Male' AS gender,

                CASE
                    WHEN scn.id IS NOT NULL THEN 1
                    ELSE 0
                END AS is_printed

            FROM req_certificate ec

            INNER JOIN req_class_student rcs
                ON rcs.req_certificate_id = ec.id

            INNER JOIN students s
                ON s.id = rcs.student_id

            LEFT JOIN student_certificate_normal scn
                ON scn.student_id = s.id
            AND scn.class_id = ec.class_id

            WHERE ec.class_id = :class_id

            GROUP BY s.id
            ORDER BY s.id ASC
        ");

        $st->execute(['class_id' => $classId]);

        return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
