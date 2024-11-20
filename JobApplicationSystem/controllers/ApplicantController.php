<?php
include('../config/db.php');

function createApplicant($name, $position, $status) {
    global $conn;
    $sql = "INSERT INTO applicants (name, position, status) VALUES ('$name', '$position', '$status')";
    if ($conn->query($sql) === TRUE) {
        return ['message' => 'Applicant added successfully', 'statusCode' => 200];
    } else {
        return ['message' => 'Error: ' . $conn->error, 'statusCode' => 400];
    }
}

function searchApplicant($searchTerm) {
    global $conn;
    $sql = "SELECT * FROM applicants WHERE name LIKE '%$searchTerm%' OR position LIKE '%$searchTerm%'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $applicants = [];
        while($row = $result->fetch_assoc()) {
            $applicants[] = $row;
        }
        return ['message' => 'Applicants found', 'statusCode' => 200, 'querySet' => $applicants];
    } else {
        return ['message' => 'No applicants found', 'statusCode' => 404];
    }
}
?>
