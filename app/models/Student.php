<?php
require_once __DIR__ . '/../../core/Database.php';

class Student {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conn;
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM students ORDER BY id DESC");
    }

    public function create($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO students (name, email, phone, marks) VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssi",
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['marks']
        );

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getPaginated($limit, $offset) {
        return $this->conn->query("
            SELECT * FROM students 
            ORDER BY id DESC 
            LIMIT $limit OFFSET $offset
        ");
    }
    
    public function getCount() {
        $result = $this->conn->query("SELECT COUNT(*) as total FROM students");
        return $result->fetch_assoc()['total'];
    }

    public function getStats() {

        $result = $this->conn->query("
            SELECT 
                COUNT(*) as total_students,
                SUM(marks) as total_scored_marks,
                MAX(marks) as highest_marks,
                AVG(marks) as avg_marks
            FROM students
        ");
    
        return $result->fetch_assoc();
    }
    public function update($id, $data) {

        $stmt = $this->conn->prepare("
            UPDATE students 
            SET name=?, email=?, phone=?, marks=? 
            WHERE id=?
        ");
    
        $stmt->bind_param(
            "sssii",
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['marks'],
            $id
        );
    
        return $stmt->execute();
    }
    public function getFiltered($sort, $min, $max, $from, $to) {

        $sql = "SELECT * FROM students WHERE 1=1";
    
        if (!empty($min)) {
            $sql .= " AND marks > $min";
        }
    
        if (!empty($max)) {
            $sql .= " AND marks < $max";
        }
    
        if (!empty($from) && !empty($to)) {
            $sql .= " AND marks BETWEEN $from AND $to";
        }
    
        if ($sort == 'asc') {
            $sql .= " ORDER BY marks ASC";
        }
    
        if ($sort == 'desc') {
            $sql .= " ORDER BY marks DESC";
        }
    
        return $this->conn->query($sql);
    }
    public function getExamTotalMarks() {
        return $this->conn->query("SELECT exam_total_marks FROM settings LIMIT 1")
            ->fetch_assoc()['exam_total_marks'];
    }

    public function updateExamTotalMarks($marks) {
        $stmt = $this->conn->prepare("
            UPDATE settings SET exam_total_marks = ? WHERE id = 1
        ");
        $stmt->bind_param("i", $marks);
        return $stmt->execute();
    }
}