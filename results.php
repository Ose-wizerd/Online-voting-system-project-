<?php
// Start session
session_start();

// Include database connection
include("dbconnect.php");

// Query to get the candidates, their vote counts, and their image paths
$query = "
    SELECT c.name, c.profession, c.image_path, COUNT(v.id) AS vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    GROUP BY c.id
    ORDER BY vote_count DESC
";
$result = mysqli_query($conn, $query);

// Check if there are results
if (mysqli_num_rows($result) > 0) {
    $candidates = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $candidates = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
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
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            padding: 20px;
            border-radius: 15px;
            width: 70%;
            margin: auto;
            color:#464f58;
        }
        header h1 {
            font-size: 1.8em;
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
        .link:hover {
            background-color: #464f58;
            font-weight: bold;
        }
        .container {
            max-width: 800px;
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
        .vote-count {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 10px;
            color: darkblue;
        }
    </style>
</head>
<body>
    <header>
        <h1>WELCOME TO ONLINE VOTING</h1>
        <div class="buttonContainer">
            <a class="link" href="home.php">Home</a>
            <a class="link" href="login.php">Login</a>
            <a class="link" href="register.php">Register</a>
            <a class="link" href="#">Result</a>
            <a href="logout.php" class="link">Logout</a>
            <a class="link" href="admin_login.php">Admin</a>
        </div>
    </header>

    <h2>Live Vote Count</h2>

    <div class="container">
        <?php foreach ($candidates as $candidate): ?>
            <div class="card">
                <!-- Display the candidate's image -->
                <img src="<?php echo htmlspecialchars($candidate['image_path']); ?>" alt="<?php echo $candidate['name']; ?>">
                <h3><?php echo $candidate['name']; ?></h3>
                <p>Profession: <?php echo $candidate['profession']; ?></p>
                <p class="vote-count">Votes: <?php echo $candidate['vote_count']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="vote.php" style="color: white; text-decoration: underline;">Back to Voting</a>
</body>
</html>

