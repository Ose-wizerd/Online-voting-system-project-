<?php
session_start();
ob_start(); // To ensure session is started correctly

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
include("dbconnect.php");

// Check if the user has already voted
$check_vote = "SELECT * FROM votes WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $check_vote);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["user_id"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // User has already voted
    $voted = true;
} else {
    $voted = false;
}

// Query to get the candidates and their vote counts
$query = "
    SELECT c.id, c.name, c.image_path, c.profession, COUNT(v.id) AS vote_count
    FROM candidates c
    LEFT JOIN votes v ON c.id = v.candidate_id
    GROUP BY c.id
    ORDER BY vote_count DESC
";
$candidates = mysqli_query($conn, $query);

// Handle the form submission when the user votes
// Handle the form submission when the user votes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['candidate_id'])) {
    if (!$voted) {
        // Get the candidate_id from the form submission
        $candidate_id = $_POST['candidate_id'];

        // Insert the vote into the votes table
        $insert_vote = "INSERT INTO votes (user_id, candidate_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_vote);
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION['user_id'], $candidate_id);
        mysqli_stmt_execute($stmt);

        // Redirect to the results page after voting
        header("Location: results.php");
        exit();
    }
}

?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
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
    padding: 15px; 
    border-radius: 12px; 
    width: 80%; 
    margin: auto; 
    color: #464f58; 
}

.buttonContainer { 
    margin-top: 10px; 
}

.link { 
    font-size: 0.9em; 
    padding: 8px 12px; 
    background-color: #343a40; 
    border-radius: 8px; 
    color: white; 
    text-decoration: none; 
    display: inline-block; 
    margin: 5px; 
}

.container { 
    max-width: 1000px; 
    margin: auto; 
    display: flex; 
    flex-wrap: wrap; 
    justify-content: center; 
    gap: 15px; 
    padding: 20px; 
}

.card {
    background: linear-gradient(to right, #bac8ff, #ffa8a8);
    color: black;
    width: 250px;  
    border-radius: 8px;
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
    padding: 12px;
    text-align: center;
    transition: transform 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.card img {
    width: 100px;  
    height: 100px;
    border-radius: 50%;
    margin-bottom: 5px;
}

.card h3 {
    font-size: 1.1em;  
}

.card p {
    font-size: 0.9em;  
}

.vote-btn {
    background: blue;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 8px;
    transition: 0.3s;
    font-size: 0.9em;
}

.vote-btn:hover {
    background: darkblue;
}

.link:hover {
    background-color: #464f58;
    font-weight: bold;
}

main p {
    margin-top: 30px;
    color: #343a40;
    font-size: 1.5em;  
}
    footer {
            width: 80vw;
            height: 5vh;
            color: #111;
            text-align: center;
            margin: 0 auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h2>Vote for Your Candidate</h2>
    <div class="buttonContainer">
        <a class="link" href="home.php">Home</a>
        <a class="link" href="login.php">Login</a>
        <a class="link" href="register.php">Register</a>
        <a class="link" href="results.php">Result</a>
        <a href="logout.php" class="link">Logout</a>
    </div>
</header>

<main>
    <?php if ($voted): ?>
        <p>You have already voted!</p>
    <?php else: ?>
        <form method="POST">
    <div class="container">
        <?php while ($candidate = mysqli_fetch_assoc($candidates)): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($candidate['image_path']); ?>" alt="Candidate Image">
                <h3><?php echo htmlspecialchars($candidate['name']); ?></h3>
                <p>Votes: <?php echo $candidate['vote_count']; ?></p>
                <p>profession: <?php echo htmlspecialchars($candidate['profession']); ?></p>
                <!-- Changed the button to carry the candidate_id -->
                <button type="submit" name="candidate_id" value="<?php echo $candidate['id']; ?>" class="vote-btn">
                    Vote
                </button>
            </div>
        <?php endwhile; ?>
    </div>
</form>

    <?php endif; ?>
</main>
<footer>
            <p>&copy; 2025 Online Voting System. All Rights Reserved.</p>
        </footer>
</body>
</html>







