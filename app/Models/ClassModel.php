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
                co.course,
                cat.category,
                tm.time,
                u.name AS teacher_name,
                c.class_type_id,
                ct.name AS class_type_name
            FROM end_class ec
            INNER JOIN classes c
                ON c.id = ec.class_id
            LEFT JOIN users u
                ON u.id = c.instructor_id
            LEFT JOIN courses co
                ON co.id = c.course_id
            LEFT JOIN categories cat
                ON cat.id = co.category_id
            LEFT JOIN times tm
                ON tm.id = c.time_id
            LEFT JOIN class_types ct
                ON ct.id = c.class_type_id
            WHERE 1 = 1
        ";

        $params = [];

        if ($type === 'scholarship') {
            $sql .= " AND ct.name = :scholarship_class_type";
            $params['scholarship_class_type'] = 'Scholarship Class';
        } else {
            $sql .= " AND (ct.name IS NULL OR ct.name <> :excluded_class_type)";
            $params['excluded_class_type'] = 'Scholarship Class';
        }

        if ($course !== '') {
            $sql .= " AND co.course = :course";
            $params['course'] = $course;
        }

        $sql .= " ORDER BY cat.category, co.course, c.id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
