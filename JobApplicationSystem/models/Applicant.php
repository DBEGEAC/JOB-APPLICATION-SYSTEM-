<?php
class Applicant {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($name, $position, $status) {
        $sql = "INSERT INTO applicants (name, position, status) VALUES ('$name', '$position', '$status')";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $name, $position, $status) {
        $sql = "UPDATE applicants SET name = '$name', position = '$position', status = '$status' WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM applicants WHERE id = $id";
        return $this->conn->query($sql);
    }

    public function getAll() {
        $sql = "SELECT * FROM applicants";
        $result = $this->conn->query($sql);
        return $result;
    }
}
?>
