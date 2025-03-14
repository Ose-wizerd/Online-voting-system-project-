<?php
session_start();
include("dbconnect.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['profession']) && !empty($_POST['image_path'])) {
        $name = trim($_POST['name']);
        $profession = trim($_POST['profession']);
        $image_path = trim($_POST['image_path']);  // Get image path from form

        // Prepare SQL statement
        $query = "INSERT INTO candidates (name, profession, vote_count, image_path) VALUES (?, ?, 0, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $name, $profession, $image_path);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "<p style='color: green;'>Candidate added successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error adding candidate: " . mysqli_error($conn) . "</p>";
        }
    } else {
        $message = "<p style='color: red;'>Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Candidate</title>
    <style>
        <?php include 'admin_style.css'; ?>
        form{
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            margin-top: 30px;
        }
        header{
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            color:  #464f58;
        }
    </style>
</head>
<body>

<header>
    <h1>Add Candidate</h1>
    <div class="buttonContainer">
        <a class="link" href="admin_dashboard.php">Dashboard</a>
        <a class="link" href="remove_candidate.php">Remove Candidate</a>
        <a class="link" href="view_votes.php">View Votes</a>
        <a class="link" href="logout.php">Logout</a>
    </div>
</header>

<?= $message ?>

<form method="POST">
    <label for="name" class="both" style="color:#111; font-weight:550;">Candidate Name:</label>
    <input type="text" name="name" required><br><br>

    <label for="profession" class="both" style="color:#111; font-weight:550;">Profession:</label>
    <input type="text" name="profession" required><br><br>

    <label for="image_path" class="both" style="color:#111; font-weight:550;">Image Path:</label>
    <input type="text" name="image_path" required><br><br>

    <button type="submit">Add Candidate</button>
</form>

</body>
</html>
