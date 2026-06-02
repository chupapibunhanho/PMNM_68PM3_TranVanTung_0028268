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
