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
    public function getFinishedClasses(string $type = '', string $course = ''): array
{
    $sql = "
        SELECT 
            c.id,
            c.course,
            c.category,
            c.time,
            c.type,
            COALESCE(u.name, t.teacher_name, 'គ្មានគ្រូ') AS teacher_name
        FROM end_class ec
        INNER JOIN classes c ON c.id = ec.class_id
        LEFT JOIN users u ON u.id = c.user_id
        LEFT JOIN teachers t ON t.id = c.teacher_id
        WHERE 1 = 1
    ";

    $params = [];

    if ($type !== '') {
        $sql .= " AND c.type = :type";
        $params['type'] = $type;
    }

    if ($course !== '') {
        $sql .= " AND c.course = :course";
        $params['course'] = $course;
    }

    $sql .= " ORDER BY c.category, c.course, c.id DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
