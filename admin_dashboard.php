<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
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
            color: #464f58;
        }
        header h1 { font-size: 1.8em; }
        .buttonContainer { margin-top: 15px; }
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
        .link:hover { background-color: #464f58; font-weight: bold; }
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
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            color: black; 
            width: 300px; 
            border-radius: 10px; 
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2); 
            padding: 20px; 
            text-align: center; 
            transition: transform 0.3s ease-in-out;
        }
        .card:hover { transform: translateY(-5px); }
        .card h3 { color: darkblue; }
    </style>
</head>
<body>

<header>
    <h1>Admin Dashboard</h1>
    <div class="buttonContainer">
        <a class="link" href="home.php">Home</a>
        <a class="link" href="view_candidates.php">Candidate</a>
        <a class="link" href="view_votes.php">View User Votes</a>
        <a class="link" href="logout.php">Logout</a>
    </div>
</header>

<h2>Welcome, Admin</h2>

<div class="container">
    <div class="card">
        <h3>Manage Candidates</h3>
        <p>Add or remove candidates for the election.</p>
        <a class="link" href="add_candidate.php">Add Candidate</a>
        <a class="link" href="remove_candidate.php">Remove Candidate</a>
    </div>

    <div class="card">
        <h3>View User Votes</h3>
        <p>Check which users voted and their choices.</p>
        <a class="link" href="view_votes.php">View Votes</a>
    </div>

    <div class="card">
        <h3>Manage Admins</h3>
        <p>Add or remove admin users.</p>
        <a class="link" href="add_admin.php">Add Admin</a>
        <a class="link" href="remove_admin.php">Remove Admin</a>
    </div>

    <div class="card">
        <h3>Logout</h3>
        <p>Exit the admin dashboard.</p>
        <a class="link" href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
