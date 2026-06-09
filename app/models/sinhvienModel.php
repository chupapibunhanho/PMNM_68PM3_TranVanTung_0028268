<?php
class sinhvienModel
{
    private $table = 'sinhvien';
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB::Connect();
    }

    public function isConnected()
    {
        return $this->conn !== null;
    }

    public function getAllSinhVien()
    {
        if (!$this->conn) {
            return [];
        }

        $sql = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paging($limit = 5, $offset = 0)
    {
        if (!$this->conn) {
            return [];
        }

        $sql = "SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSinhVien()
    {
        if (!$this->conn) {
            return 0;
        }

        $sql = "SELECT COUNT(*) FROM " . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function getColumns()
    {
        if (!$this->conn) {
            return [];
        }

        $stmt = $this->conn->query("DESCRIBE " . $this->table);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEditableColumns()
    {
        return array_values(array_filter($this->getColumns(), function ($column) {
            return stripos($column['Extra'] ?? '', 'auto_increment') === false;
        }));
    }

    public function createSinhVien($data)
    {
        if (!$this->conn) {
            return false;
        }

        $columns = array_column($this->getEditableColumns(), 'Field');
        $insertData = [];

        foreach ($columns as $column) {
            if (array_key_exists($column, $data)) {
                $insertData[$column] = trim($data[$column]);
            }
        }

        if (empty($insertData)) {
            return false;
        }

        $fieldNames = array_keys($insertData);
        $placeholders = array_map(function ($field) {
            return ':' . $field;
        }, $fieldNames);

        $quotedFields = array_map(function ($field) {
            return '`' . str_replace('`', '``', $field) . '`';
        }, $fieldNames);

        $sql = "INSERT INTO " . $this->table . " (" . implode(', ', $quotedFields) . ")
                VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute($insertData);
    }
}
