<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        // Check if the email is already registered
        $check_query = "SELECT * FROM admin WHERE email = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $message = "<p style='color: red;'>Admin with this email already exists!</p>";
        } else {
            // Hash the password and insert new admin
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO admin (email, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                $message = "<p style='color: green;'>Admin added successfully!</p>";
            } else {
                $message = "<p style='color: red;'>Error adding admin: " . mysqli_error($conn) . "</p>";
            }
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
    <title>Add Admin</title>
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
        h1{
        color: #464f58;
        }
        .both{
        color: #111;
        font-weight: 500;
        }
    </style>
</head>
<body>

<header>
    <h1>Add Admin</h1>
    <div class="buttonContainer">
        <a class="link" href="admin_dashboard.php">Dashboard</a>
        <a class="link" href="remove_admin.php">Remove Admin</a>
        <a class="link" href="logout.php">Logout</a>
    </div>
</header>

<?= $message ?>

<form method="POST">
    <label for="email" class="both">Admin Email:</label>
    <input type="email" name="email" required><br><br>

    <label for="password" class="both">Password:</label>
    <input type="password" name="password" required><br><br>

    <button type="submit">Add Admin</button>
</form>

</body>
</html>
