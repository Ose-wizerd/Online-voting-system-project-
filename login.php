<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// If the user is already logged in, redirect to the vote page
if (isset($_SESSION['user_id'])) {
    header('Location: vote.php');
    exit();
}

// Include database connection
include("dbconnect.php");

$errors = ["password" => "", "email" => ""];
$email = $password = '';
$success = '';

if (isset($_POST['submit'])) {
    // Get input values
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Validate email
    if (empty($email)) {
        $errors["email"] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format!";
    }

    // Validate password
    if (empty($password)) {
        $errors["password"] = "Password is required!";
    } elseif (strlen($password) < 8) {
        $errors["password"] = "Password must be at least 8 characters long!";
    }

    // If no errors, check user in database
    if (empty($errors["email"]) && empty($errors["password"])) {
        $query = "SELECT * FROM user_info WHERE Email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verify hashed password
            if (password_verify($password, $row["password"])) {
                // Set session and redirect
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["email"] = $row["Email"];
                $success = "Login Successful! Redirecting...";
                header("Location: vote.php"); // Redirect to voting page
                exit();
            } else {
                $errors["password"] = "Incorrect password!";
            }
        } else {
            $errors["email"] = "No account found with this email!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
 * { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
}

html { 
    background: linear-gradient(rgb(233, 158, 83), rgba(14, 70, 126, 0.333)); 
}

body { 
    height: 100vh; 
    width: 80vw; 
    margin: 0 auto; 
    color: #fff; 
    font-family: sans-serif; 
    font-size: 1em; 
}

form { 
    background: linear-gradient(to right, #bac8ff, #ffa8a8); 
    padding: 10px; 
    max-width: 600px; 
    border-radius: 8px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
    margin: 0 auto; 
}

input { 
    width: 100%; 
    border: 1px solid rgba(0, 0, 0, 0.2); 
    border-radius: 5px; 
    padding: 15px; 
    margin-top: 5px; 
    font-size: 1em; 
}

input:focus { 
    outline: none; 
    border-color: blue; 
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
}

button { 
    width: 101%; 
    font-size: 1.2rem; 
    background-color: blue; 
    border: none; 
    border-radius: 5px; 
    color: #fff; 
    font-weight: bold; 
    margin-bottom: 10px; 
    padding: 15px; 
    margin-top: 10px; 
}

button:hover { 
    background-color: rgb(4, 4, 136); 
    color: #fff; 
}

.error { 
    color: red; 
}

.success { 
    color: green; 
    font-weight: bold; 
    margin-bottom: 10px; 
}

header { 
    background: linear-gradient(to right, #bac8ff, #ffa8a8); 
    height: 90px; 
    font-size: 120%; 
    border-radius: 15px; 
    color: #495057; 
    max-width: 650px; 
    margin: 0 auto; 
    margin-bottom: 20px; 
    margin-top: 20px; 
    padding: 5px; 
    text-align: center; 
}

.link { 
    margin: 10px; 
    font-size: 80%; 
    padding: 8px; 
    background-color: #343a40; 
    border-radius: 12px; 
    color: #fff; 
    text-decoration: none; 
}

.link:hover { 
    background-color: #464f58; 
    font-weight: bold; 
}

.buttonContainer { 
    text-align: center; 
    margin-top: 10px; 
}

        .register{
          color:#111;
          max-width: 600px; 
          margin: 0 auto;
          margin-top: 30px;
          font-size: 120%;
        }
        .register_link{
          text-decoration: none;
        }
        .register_link:hover{
          color:#5f3dc4;
        }
        footer {
            width: 80vw;
            height: 5vh;
            color: #111;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h2>LOGIN TO VOTE</h2>
    <div class="buttonContainer">
        <a class="link" href="home.php">Home</a>
        <a class="link" href="login.php">Login</a>
        <a class="link" href="register.php">Register</a>
        <a class="link" href="results.php">Result</a>
        <a class="link" href="admin_login.php">Admin</a>
    </div>
</header>

<main>
<form action="login.php" method="post">
        <label for="email" style="color:#111; font-weight:550;">Email</label>
        <input type="text" name="email" id="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" />
        <div class="error"><?php echo $errors["email"]; ?></div>

        <label for="password" style="color:#111; font-weight:550;">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" />
        <div class="error"><?php echo $errors["password"]; ?></div>

        <div class="success"><?php echo $success; ?></div>
        <button name="submit" type="submit">Login</button>
    </form>
    <div class="register">
        <p>If you don't have an account, <a href="register.php" class="register_link">register here</a>.</p>
    </div>
</main>
<footer>
            <p>&copy; 2025 Online Voting System. All Rights Reserved.</p>
        </footer>
</body>
</html>

