<?php
// Include the database connection
include('../config/db.php');

// Search logic (same as before)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $searchTerm = $_GET['search'] ?? '';  // Get the search term from the form
    $sql = "SELECT * FROM applicants WHERE name LIKE ? OR position LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$searchTerm%";  // Add wildcards for searching
    $stmt->bind_param("ss", $searchTerm, $searchTerm);  // Bind the parameters
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Fetch all applicants if no search term
    $sql = "SELECT * FROM applicants";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application System</title>
</head>
<body>
    <h1>Search Applicants</h1>
    <form method="GET" action="home.php">
        <input type="text" name="search" placeholder="Search applicants by name or position">
        <button type="submit">Search</button>
    </form>

    <!-- Button to Create New Applicant -->
    <a href="create.php"><button>Create New Applicant</button></a>

    <h2>Applicants List</h2>
    <ul>
        <?php while ($applicant = $result->fetch_assoc()): ?>
            <li>
                <strong><?php echo $applicant['name']; ?></strong> - <?php echo $applicant['position']; ?>
                <em> (Status: <?php echo $applicant['status']; ?>)</em>
                <a href="edit.php?id=<?php echo $applicant['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $applicant['id']; ?>">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
