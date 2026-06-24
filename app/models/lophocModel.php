<?php
class lophocModel
{
    private $table = 'lophoc';
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
        $sql = "SELECT malop, tenlop, namhoc FROM " . $this->table . $whereData['where'] . " ORDER BY malop LIMIT :limit OFFSET :offset";
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

        $lopHocData = [
            'malop' => trim($data['malop'] ?? ''),
            'tenlop' => trim($data['tenlop'] ?? ''),
            'namhoc' => trim($data['namhoc'] ?? ''),
        ];

        if ($lopHocData['malop'] === '' || $lopHocData['tenlop'] === '') {
            return false;
        }

        $sql = "INSERT INTO " . $this->table . " (malop, tenlop, namhoc)
                VALUES (:malop, :tenlop, :namhoc)";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute($lopHocData);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data)
    {
        if (!$this->conn || $id === '') {
            return false;
        }

        $lopHocData = [
            'tenlop' => trim($data['tenlop'] ?? ''),
            'namhoc' => trim($data['namhoc'] ?? ''),
            'id' => $id,
        ];

        if ($lopHocData['tenlop'] === '') {
            return false;
        }

        $sql = "UPDATE " . $this->table . "
                SET tenlop = :tenlop, namhoc = :namhoc
                WHERE malop = :id";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute($lopHocData);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        if (!$this->conn || $id === '') {
            return false;
        }

        $sql = "DELETE FROM " . $this->table . " WHERE malop = :id";
        $stmt = $this->conn->prepare($sql);

        try {
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    private function buildSearchWhere($filters)
    {
        $malop = trim($filters['malop'] ?? '');

        if ($malop === '') {
            return [
                'where' => '',
                'params' => [],
            ];
        }

        return [
            'where' => ' WHERE malop LIKE :malop',
            'params' => [
                ':malop' => '%' . $malop . '%',
            ],
        ];
    }
}
