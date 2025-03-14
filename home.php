<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            height: 100vh;
            background: linear-gradient(rgb(233, 158, 83), rgba(14, 70, 126, 0.333));
            color: #fff;
            font-family: sans-serif;
            font-size: 1em;
            text-align: center;
        }
        .container { width: 80vw; height: 100vh; margin: 0 auto; }
        header {
            background: linear-gradient(to left, #bac8ff, #ffa8a8);
            padding: 20px;
            border-radius: 15px;
            width: 70%;
            margin: auto;
            margin-top:10px;
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
        h1 {
            margin-top: 20px;
            font-size: 1.5em;
        }
        .link:hover {
            background-color: #464f58;
            font-weight: bold;
        }
        .buttonContainer { margin-top: 15px; }
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
            gap: 20px;
        }
        .card {
            /* background-color: #fff; */
            background: linear-gradient(to right, #bac8ff, #ffa8a8);
            color: #333;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 250px;
            text-align: center;
        }
        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }
        .card p { margin-top: 10px; font-weight: bold; }
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
    <div class="container">
        <header>
            <h1>WELCOME TO ONLINE VOTING</h1>
            <div class="buttonContainer">
                <a class="link" href="home.php">Home</a>
                <a class="link" href="view_candidates.php">Candidate</a>
                <a class="link" href="login.php">Login</a>
                <a class="link" href="register.php">Register</a>
                <a class="link" href="results.php">Results</a>
                <a class="link" href="admin_login.php">Admin</a>
            </div>
        </header>

        <main>
            <div class="card">
                <img src="images2.jpeg" alt="Voting Image 1">
                <p>Secure & Transparent Voting System</p>
            </div>
            <div class="card">
                <img src="images1.jpeg" alt="Voting Image 2">
                <p>Vote Anytime, Anywhere</p>
            </div>
        </main>

        <footer>
            <p>&copy; 2025 Online Voting System. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>
