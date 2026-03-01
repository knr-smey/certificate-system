<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class CertificateClassFreeModel
{
    private ?PDO $db = null;

    public function __construct()
    {
        $this->db = Database::pdo();
    }

    /**
     * Create a new certificate class-free request
     */
    public function create(string $studentName, string $course, string $endDate): int|false
    {
        $stmt = $this->db->prepare(
            "INSERT INTO certificate_class_free (student_name, course, end_date, status) 
             VALUES (:student_name, :course, :end_date, 'pending')"
        );

        $stmt->bindValue(':student_name', strtoupper($studentName), PDO::PARAM_STR);
        $stmt->bindValue(':course', $course, PDO::PARAM_STR);
        $stmt->bindValue(':end_date', $endDate, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return (int) $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Get all certificate class-free requests
     */
    public function getAll(): array
    {
        try {
            $sql = "SELECT * FROM certificate_class_free ORDER BY created_at DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (\PDOException $e) {
            error_log("Error fetching certificates: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get paginated certificate class-free requests
     */
    public function getAllPaginated(int $page = 1, int $limit = 5): array
    {
        try {
            $offset = ($page - 1) * $limit;
            $sql = "SELECT * FROM certificate_class_free ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (\PDOException $e) {
            error_log("Error fetching paginated certificates: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get total count of certificate class-free requests
     */
    public function getCount(): int
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM certificate_class_free";
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) ($result['total'] ?? 0);
        } catch (\PDOException $e) {
            error_log("Error counting certificates: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get certificate class-free request by ID
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM certificate_class_free WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
    }

    /**
     * Update certificate class-free status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE certificate_class_free SET status = :status WHERE id = :id"
        );

        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Delete certificate class-free request
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM certificate_class_free WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Get the latest certificate class-free request
     */
    public function getLatest(): array|false
    {
        try {
            $sql = "SELECT * FROM certificate_class_free ORDER BY created_at DESC LIMIT 1";
            $stmt = $this->db->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
        } catch (\PDOException $e) {
            error_log("Error fetching latest certificate: " . $e->getMessage());
            return false;
        }
    }
}
