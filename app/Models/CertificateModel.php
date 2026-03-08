<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class CertificateModel
{
    private ?\PDO $db = null;

    public function __construct()
    {
        $this->db = Database::pdo();
    }

    /**
     * Create a new certificate request
     */
    public function create(string $studentName, string $course, string $endDate): int|false
    {
        $stmt = $this->db->prepare(
            "INSERT INTO certificate_requests (student_name, course, end_date, status) 
             VALUES (:student_name, :course, :end_date, 'pending')"
        );

        $stmt->bindValue(':student_name', strtoupper($studentName), \PDO::PARAM_STR);
        $stmt->bindValue(':course', $course, \PDO::PARAM_STR);
        $stmt->bindValue(':end_date', $endDate, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            return (int) $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Get all certificate requests
     */
    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM certificate_requests ORDER BY created_at DESC"
        );

        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Get certificate request by ID
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM certificate_requests WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: false;
    }

    /**
     * Update certificate status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE certificate_requests SET status = :status WHERE id = :id"
        );

        $stmt->bindValue(':status', $status, \PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Delete certificate request
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM certificate_requests WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }
}
