<?php
class giaovienModel
{
    private $table = 'giaovien';
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB::Connect();
    }

    public function isConnected()
    {
        return $this->conn !== null;
    }

    public function paging($limit = 5, $offset = 0, $filters = [])
    {
        if (!$this->conn) {
            return [];
        }

        $whereData = $this->buildSearchWhere($filters);
        $sql = "SELECT mgv, hoten, ngaysinh FROM " . $this->table . $whereData['where'] . " ORDER BY mgv LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);

        foreach ($whereData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count($filters = [])
    {
        if (!$this->conn) {
            return 0;
        }

        $whereData = $this->buildSearchWhere($filters);
        $sql = "SELECT COUNT(*) FROM " . $this->table . $whereData['where'];
        $stmt = $this->conn->prepare($sql);

        foreach ($whereData['params'] as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function create($data)
    {
        if (!$this->conn) {
            return false;
        }

        $giaoVienData = [
            'mgv' => trim($data['mgv'] ?? ''),
            'hoten' => trim($data['hoten'] ?? ''),
            'ngaysinh' => trim($data['ngaysinh'] ?? ''),
        ];

        if ($giaoVienData['mgv'] === '' || $giaoVienData['hoten'] === '') {
            return false;
        }

        $sql = "INSERT INTO " . $this->table . " (mgv, hoten, ngaysinh)
                VALUES (:mgv, :hoten, :ngaysinh)";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute($giaoVienData);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data)
    {
        if (!$this->conn || $id === '') {
            return false;
        }

        $giaoVienData = [
            'hoten' => trim($data['hoten'] ?? ''),
            'ngaysinh' => trim($data['ngaysinh'] ?? ''),
            'id' => $id,
        ];

        if ($giaoVienData['hoten'] === '') {
            return false;
        }

        $sql = "UPDATE " . $this->table . "
                SET hoten = :hoten, ngaysinh = :ngaysinh
                WHERE mgv = :id";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute($giaoVienData);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        if (!$this->conn || $id === '') {
            return false;
        }

        $sql = "DELETE FROM " . $this->table . " WHERE mgv = :id";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    private function buildSearchWhere($filters)
    {
        $mgv = trim($filters['mgv'] ?? '');
        $hoten = trim($filters['hoten'] ?? '');

        $conditions = [];
        $params = [];

        if ($mgv !== '') {
            $conditions[] = 'mgv LIKE :mgv';
            $params[':mgv'] = '%' . $mgv . '%';
        }

        if ($hoten !== '') {
            $conditions[] = 'hoten LIKE :hoten';
            $params[':hoten'] = '%' . $hoten . '%';
        }

        return [
            'where' => empty($conditions) ? '' : ' WHERE ' . implode(' AND ', $conditions),
            'params' => $params,
        ];
    }
}
