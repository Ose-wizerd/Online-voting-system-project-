<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $candidate_id = $_POST['candidate_id'];

    $query = "DELETE FROM candidates WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $candidate_id);
    if (mysqli_stmt_execute($stmt)) {
        $message = "Candidate removed successfully!";
    } else {
        $message = "Error removing candidate.";
    }
}

$result = mysqli_query($conn, "SELECT * FROM candidates");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Candidate</title>
    <style>
        <?php include 'admin_style.css'; ?>
        form{
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            margin-top: 30px;
            color:  #464f58;
        }
    </style>
</head>
<body>

<header>
    <h1>Remove Candidate</h1>
    <div class="buttonContainer">
        <a class="link" href="admin_dashboard.php">Dashboard</a>
        <a class="link" href="add_candidate.php">Add Candidate</a>
        <a class="link" href="view_votes.php">View Votes</a>
        <a class="link" href="logout.php">Logout</a>
    </div>
</header>

<?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>

<form method="POST">
    <label for="candidate_id" class="both">Select Candidate:</label>
    <select name="candidate_id" required>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?> (<?= $row['profession'] ?>)</option>
        <?php } ?>
    </select><br><br>
    <button type="submit">Remove Candidate</button>
</form>

</body>
</html>
