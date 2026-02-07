<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class ClassModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    /**
     * Example query. Adjust to your real schema:
     * - finished classes
     * - optionally filter by certificate type & course
     */
    public function getFinishedClasses(string $type, string $course = ''): array
    {
        // NOTE: Replace these fields/tables with your real ones.
        $sql = "SELECT id, class_name, course, teacher_name, end_date
                FROM classes
                WHERE status = 'finished'";

        $params = [];

        if ($course !== '') {
            $sql .= " AND course = ?";
            $params[] = $course;
        }

        $sql .= " ORDER BY id DESC";

        $st = $this->pdo->prepare($sql);
        $st->execute($params);

        return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
