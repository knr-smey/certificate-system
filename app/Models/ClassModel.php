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
                ec.class_network_for_basic_it,
                
                co.course,
                cat.category,
                tm.time,
                u.name AS teacher_name,
                c.class_type_id,
                ct.name AS class_type_name,
                COUNT(DISTINCT rcs.student_id) AS total_students,
                COUNT(DISTINCT scn.student_id) AS printed_students
            FROM req_certificate ec
            INNER JOIN classes c
                ON c.id = ec.class_id
            LEFT JOIN req_class_student rcs
                ON rcs.req_certificate_id = ec.id
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
            LEFT JOIN student_certificate_normal scn
                ON scn.class_id = c.id
            WHERE 1 = 1
        ";

        $params = [];

        // ❗ remove type filter for now (your type is wrong)
        // if ($type !== '') {
        //     $sql .= " AND c.class_type_id = :type";
        //     $params['type'] = $type;
        // }

        if ($course !== '') {
            $sql .= " AND c.course_id = :course";
            $params['course'] = $course;
        }

        // ✅ IMPORTANT (for COUNT)
        $sql .= "
            GROUP BY 
                c.id,
                ec.class_network_for_basic_it,
                co.course,
                cat.category,
                tm.time,
                u.name,
                c.class_type_id,
                ct.name
            HAVING COUNT(DISTINCT rcs.student_id) > 0
                OR COUNT(DISTINCT scn.student_id) > 0
            ORDER BY c.id DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
