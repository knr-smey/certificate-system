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
}
