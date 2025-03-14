<?php
// Database connection details
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "votingDB";

// Create connection
$conn = mysqli_connect($db_server, $db_user, $db_pass);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create Database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully!<br>";
} else {
    die("Error creating database: " . mysqli_error($conn));
}

// Select the database
mysqli_select_db($conn, $db_name);



// Create admin table
$sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
if (mysqli_query($conn, $sql)) {
    echo "Admin table created successfully!<br>";
    // Check if an admin already exists
    $check_query = "SELECT * FROM admin WHERE email = 'abcd12@gmail.com'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        // Hash the default password
        $default_password = password_hash("abcd12345", PASSWORD_DEFAULT);
        
        // Insert initial admin
        $insert_admin = "INSERT INTO admin (email, password) VALUES ('abcd12@gmail.com', '$default_password')";
        
        if (mysqli_query($conn, $insert_admin)) {
            echo "Initial admin account created!<br>";
        } else {
            echo "Error inserting initial admin: " . mysqli_error($conn);
        }
    } else {
        echo "Admin account already exists.<br>";
    }
} else {
    die("Error creating admin table: " . mysqli_error($conn));
}



// Create candidates table
$sql = "CREATE TABLE IF NOT EXISTS candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    profession VARCHAR(100) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    vote_count INT DEFAULT 0
)";
if (mysqli_query($conn, $sql)) {
    echo "Candidates table created successfully!<br>";
} else {
    die("Error creating candidates table: " . mysqli_error($conn));
}

// Create user_info table
$sql = "CREATE TABLE IF NOT EXISTS user_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
if (mysqli_query($conn, $sql)) {
    echo "User Info table created successfully!<br>";
} else {
    die("Error creating user_info table: " . mysqli_error($conn));
}

// Create votes table
$sql = "CREATE TABLE IF NOT EXISTS votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    candidate_id INT NOT NULL,
    vote_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user_info(id) ON DELETE CASCADE,
    FOREIGN KEY (candidate_id) REFERENCES candidates(id) ON DELETE CASCADE
)";
if (mysqli_query($conn, $sql)) {
    echo "Votes table created successfully!<br>";
} else {
    die("Error creating votes table: " . mysqli_error($conn));
}

// Close connection
mysqli_close($conn);

echo "<br>✅ Setup completed! Now you can use your database.";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Base setup</title>
    <style>
        body{
            background: linear-gradient(rgb(233, 158, 83), rgba(14, 70, 126, 0.333));
        }
        .link {
            font-size: 1em;
            padding: 10px 15px;
            background-color: #343a40;
            border-radius: 12px;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
    </style>
</head>
<body>
    
    <p>Use the system <a class="link" href="home.php">Home</a></p>
</body>
</html>
