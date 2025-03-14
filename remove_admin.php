<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_POST['admin_id'];

    // Prevent the currently logged-in admin from deleting themselves
    if ($_SESSION['admin'] == $admin_id) {
        $message = "<p style='color: red;'>You cannot remove yourself.</p>";
    } else {
        $query = "DELETE FROM admin WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $admin_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "<p style='color: green;'>Admin removed successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error removing admin.</p>";
        }
    }
}

$result = mysqli_query($conn, "SELECT * FROM admin");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Admin</title>
    <style>
        <?php include 'admin_style.css'; ?>
        form {
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            margin-top: 30px;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        header {
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            color: #464f58;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    <h1>Remove Admin</h1>
    <div class="buttonContainer">
        <a class="link" href="admin_dashboard.php">Dashboard</a>
        <a class="link" href="add_admin.php">Add Admin</a>
        <a class="link" href="logout.php">Logout</a>
    </div>
</header>

<?= $message ?>

<form method="POST">
    <label for="admin_id" class="both">Select Admin:</label>
    <select name="admin_id" required>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?= $row['id'] ?>"><?= $row['email'] ?></option>
        <?php } ?>
    </select><br><br>
    <button type="submit">Remove Admin</button>
</form>

</body>
</html>
