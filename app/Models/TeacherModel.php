<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class TeacherModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::pdo();
    }

    public function getAllTeachers(): array
    {
        $sql = "SELECT id, teacher_name, email, phone 
                FROM teachers 
                ORDER BY id DESC";

        $st = $this->pdo->prepare($sql);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getTotalStudentRequestCertificate(): int
    {
        $sql = "
            SELECT COUNT(DISTINCT rcs.student_id) AS total
            FROM req_class_student rcs
            INNER JOIN req_certificate rc
                ON rc.id = rcs.req_certificate_id
        ";

        $st = $this->pdo->prepare($sql);
        $st->execute();

        return (int) ($st->fetchColumn() ?: 0);
    }
}
