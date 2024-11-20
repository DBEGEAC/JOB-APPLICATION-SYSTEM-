<?php
// Include necessary files
include('../config/db.php');
include('../controllers/ApplicantController.php');

// Check if a search term is passed
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Call the function to search applicants
$response = searchApplicant($searchTerm);
$applicants = isset($response['querySet']) ? $response['querySet'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant List</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Applicant List</h1>

    <form method="GET" action="applicantList.php">
        <input type="text" name="search" placeholder="Search applicants" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Search</button>
    </form>

    <h2>Applicants</h2>
    <ul>
        <?php if (count($applicants) > 0): ?>
            <?php foreach ($applicants as $applicant): ?>
                <li>
                    <strong><?php echo $applicant['name']; ?></strong> - <?php echo $applicant['position']; ?>
                    <a href="edit.php?id=<?php echo $applicant['id']; ?>">Edit</a> | 
                    <a href="delete.php?id=<?php echo $applicant['id']; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No applicants found.</li>
        <?php endif; ?>
    </ul>

    <p><a href="create.php">Create New Applicant</a></p>
    <p><a href="home.php">Back to Home</a></p>
</body>
</html>
