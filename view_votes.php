<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$query = "SELECT user_info.name AS user_name, candidates.name AS candidate_name 
    FROM user_info 
    JOIN votes ON user_info.id = votes.user_id 
    JOIN candidates ON votes.candidate_id = candidates.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Votes</title>
    <style>
        <?php include 'admin_style.css'; ?>
        header{
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            color:  #464f58;
        }
    </style>
</head>
<body>

<header>
    <h1>View Votes</h1>
    <div class="buttonContainer">
        <a class="link" href="admin_dashboard.php">Dashboard</a>
        <a class="link" href="add_candidate.php">Add Candidate</a>
        <a class="link" href="remove_candidate.php">Remove Candidate</a>
        <a class="link" href="logout.php">Logout</a>
    </div>
</header>

<table border="1" width="60%" align="center" style="margin: 20px auto; border-color:black;">
    <tr>
        <th style="color:#111" >User Name</th>
        <th style="color:#111">Voted For</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['user_name'] ?></td>
            <td><?= $row['candidate_name'] ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
