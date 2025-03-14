<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include("dbconnect.php");

// Query to get all candidates
$query = "SELECT * FROM candidates ORDER BY vote_count DESC";
$candidates = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Candidates</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: linear-gradient(to right, #e99e53, rgba(14, 70, 126, 0.7));
            color: white;
            text-align: center;
            padding: 20px;
        }
        header {
            background: linear-gradient(to left, #bac8ff, #ffa8a8);
            padding: 20px;
            border-radius: 15px;
            width: 70%;
            margin: auto;
            color: #464f58;
        }
        .buttonContainer {
            margin-top: 15px;
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
        h2 {
            margin-top: 20px;
            font-size: 1.5em;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .card {
            /* background: white; */
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            color: black;
            width: 300px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .vote-btn {
            background: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
            font-size: 1em;
        }
        .vote-btn:hover {
            background: darkblue;
        }
        .link:hover {
            background-color: #464f58;
            font-weight: bold;
        }
        footer {
            width: 90vw;
            height: 5vh;
            color: #111;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h2>View Candidates</h2>
    <div class="buttonContainer">
    <a class="link" href="home.php">Home</a>
                <a class="link" href="login.php">Login</a>
                <a class="link" href="register.php">Register</a>
                <a class="link" href="results.php">Results</a>
                <a class="link" href="admin_login.php">Admin</a>
    </div>
</header>

<main>
    <div class="container">
        <?php while ($candidate = mysqli_fetch_assoc($candidates)): ?>
            <div class="card">
                <!-- Show Candidate Image -->
                <img src="<?php echo htmlspecialchars($candidate['image_path']); ?>" alt="Candidate Image">
                <h3><?php echo htmlspecialchars($candidate['name']); ?></h3>
                <p>profession: <?php echo htmlspecialchars($candidate['profession']); ?></p>
                <p>Votes: <?php echo $candidate['vote_count']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</main>
<footer>
            <p>&copy; 2025 Online Voting System. All Rights Reserved.</p>
        </footer>
</body>
</html>
