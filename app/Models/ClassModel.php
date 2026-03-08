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
                classes.id,
                classes.course,
                classes.category,
                classes.time,
                users.name AS teacher_name
            FROM classes
            LEFT JOIN users 
                ON users.id = classes.user_id
            WHERE classes.type = :type
        ";

        $params = ['type' => $type];

        if ($course !== '') {
            $sql .= " AND classes.course = :course";
            $params['course'] = $course;
        }

        $sql .= " ORDER BY classes.category, classes.course, classes.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
