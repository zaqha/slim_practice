<?php

declare(strict_types=1);

namespace App\Repository;

use Psr\Log\LoggerInterface;
use PDO;

class DepartmentRepository
{
    private PDO $db;
    private LoggerInterface $logger;

    public function __construct(PDO $db, LoggerInterface $logger)
    {
        $this->db = $db;
        $this->logger = $logger;
    }

    public function getDepartment($title, $data): array
    {
        // 抓資料庫
        try {
            $i = 0;
            $sql = "SELECT {$title} FROM department WHERE 1=1 ";

            if (isset($data['id'])) {
                if (!empty($data['id'])) {
                    $sql .= " and department.id = ?";
                }
            }
            if (isset($data['name'])) {
                if (!empty($data['name'])) {
                    $sql .= " and department.name like ?";
                }
            }
            if (isset($data['is_deleted'])) {
                $sql .= " and department.is_deleted = ?";
            }

            $sql .= " order by department.id";
            
            $stmt = $this->db->prepare($sql);

            if (isset($data['id'])) {
                if (!empty($data['id'])) {
                    $stmt->bindValue(++$i, $data['id']);
                }
            }
            if (isset($data['name'])) {
                if (!empty($data['name'])) {
                    $stmt->bindValue(++$i, '%'.$data['name'].'%');
                }
            }
            if (isset($data['is_deleted'])) {
                    $stmt->bindValue(++$i, $data['is_deleted']);
            }
            $stmt->execute();
        } catch (\PDOException $e) {
            throw $e->getMessage();
        } catch (\Exception $e) {
            throw $e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function insertDepartment($data): array
    {
        // 抓資料庫
        try {
            $i = 0;
            $sql = 'INSERT INTO department (id, name, created_time, create_user_id) values (?,?,?,?)';

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(++$i, $data['id']);
            $stmt->bindValue(++$i, $data['name']);
            $stmt->bindValue(++$i, date("Y-m-d H:i:s"));
            $stmt->bindValue(++$i, $_SESSION['user_id']);

            $stmt->execute();
        } catch (\PDOException $e) {
            throw $e->getMessage();
        } catch (\Exception $e) {
            throw $e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function updateDepartment($data): array
    {
        // 抓資料庫
        try {
            $i = 0;
            $sql = 'UPDATE department set name = ?, updated_time = ?, update_user_id = ? WHERE id = ?';

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(++$i, $data['name']);
            $stmt->bindValue(++$i, date("Y-m-d H:i:s"));
            $stmt->bindValue(++$i, $_SESSION['user_id']);
            $stmt->bindValue(++$i, $data['id']);

            $stmt->execute();
        } catch (\PDOException $e) {
            throw $e->getMessage();
        } catch (\Exception $e) {
            throw $e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function deleteDepartment($data): array
    {
        // 抓資料庫
        try {
            $i = 0;
            $sql = 'UPDATE department set is_deleted = ?, updated_time = ?, update_user_id = ? WHERE id = ?';

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(++$i, 1);
            $stmt->bindValue(++$i, date("Y-m-d H:i:s"));
            $stmt->bindValue(++$i, $_SESSION['user_id']);
            $stmt->bindValue(++$i, $data['id']);

            $stmt->execute();
        } catch (\PDOException $e) {
            throw $e->getMessage();
        } catch (\Exception $e) {
            throw $e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }

    public function duplicateDepartment($data): array
    {
        // 抓資料庫
        try {
            $i = 0;
            $sql = 'INSERT INTO department (id, name, created_time, create_user_id) values (?,?,?,?) ON DUPLICATE KEY UPDATE name = ?, is_deleted = ?, updated_time = ?, update_user_id = ?';

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(++$i, $data['id']);
            $stmt->bindValue(++$i, $data['name']);
            $stmt->bindValue(++$i, date("Y-m-d H:i:s"));
            $stmt->bindValue(++$i, $_SESSION['user_id']);
            $stmt->bindValue(++$i, $data['name']);
            $stmt->bindValue(++$i, 1);
            $stmt->bindValue(++$i, date("Y-m-d H:i:s"));
            $stmt->bindValue(++$i, $_SESSION['user_id']);

            $stmt->execute();
        } catch (\PDOException $e) {
            throw $e->getMessage();
        } catch (\Exception $e) {
            throw $e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
}
