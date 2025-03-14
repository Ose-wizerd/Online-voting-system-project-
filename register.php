<?php
include("dbconnect.php");

$errors = ["name" => "", "email" => "", "password" => ""];
$name = $email = $password = '';
$success = '';

if (isset($_POST['submit'])) {
    if (empty($_POST["name"])) {
        $errors["name"] = "Full Name is required!";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
        
        // Check if name contains only letters and spaces
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors["name"] = "Full Name can only contain alphabets and spaces!";
        }
    }
    

    // Validate Email
    if (empty($_POST["email"])) {
        $errors["email"] = "Email is required!";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format!";
    } else {
        $email =htmlspecialchars(trim($_POST["email"])) ;
    }

    // Validate Password
    if (empty($_POST["password"])) {
        $errors["password"] = "Password is required!";
    } elseif (strlen($_POST["password"]) < 8) {
        $errors["password"] = "Password must be at least 8 characters long!";
    } else {
        $password =htmlspecialchars(trim($_POST["password"])) ;
    }

    // If no validation errors, check if the name or email already exists
    if (empty($errors["name"]) && empty($errors["email"]) && empty($errors["password"])) {
        // Check if name exists
        $stmt = $conn->prepare("SELECT * FROM user_info WHERE Name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errors["name"] = "This name is already taken!";
        }

        // Check if email exists
        $stmt = $conn->prepare("SELECT * FROM user_info WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errors["email"] = "This email is already registered!";
        }

        // If no duplicate name or email, proceed with registration
        if (empty($errors["name"]) && empty($errors["email"])) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO user_info (Name, Email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "Registration Successful!";
                $name = $email = $password = ''; // Clear form fields after successful registration
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

            .success { 
                color: green; 
                font-weight: bold; 
                text-align: center; 
                margin-top: 10px; 
            }

            .error { 
                color: red; 
                font-size: 0.9em; 
                margin-bottom: 5px; 
            }

        header {
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            height: 90px;
            font-size: 120%;
            border-radius: 15px;
            color: #495057;
            text-align: center;
            max-width: 650px;
            margin: 0 auto;
            margin-bottom: 20px;
            margin-top: 20px;
            padding: 5px;
        }
        .link {
            margin-top: 10px;
            margin-right: 20px;
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
            margin-top: 10px;
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
    <h2>REGISTER TO VOTE</h2>
    <div class="buttonContainer">
        <a class="link" href="home.php">Home</a>
        <a class="link" href="login.php">Login</a>
        <a class="link" href="register.php">Register</a>
        <a class="link" href="results.php">Results</a>
    </div>
</header>

<main>
    <form action="register.php" method="post">
        <label for="name" style="color:black;font-weight:550">Full Name</label>
        <input type="text" name="name" id="name" placeholder="Enter Your Full Name" value="<?= htmlspecialchars($name) ?>">
        <div class="error"><?= $errors["name"] ?></div>
        <br>

        <label for="email" style="color:black;font-weight:550">Email</label>
        <input type="text" name="email" id="email" placeholder="Enter Your Email" value="<?= htmlspecialchars($email) ?>">
        <div class="error"><?= $errors["email"] ?></div>
        <br>

        <label for="password" style="color:black;font-weight:550">Password</label>
        <input type="password" name="password" id="password" placeholder="Enter Your Password">
        <div class="error"><?= $errors["password"] ?></div>

        <button type="submit" name="submit">Register</button>

        <!-- Success Message -->
        <?php if (!empty($success)) : ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
    </form>
</main>
<footer>
            <p>&copy; 2025 Online Voting System. All Rights Reserved.</p>
        </footer>
</body>
</html>
