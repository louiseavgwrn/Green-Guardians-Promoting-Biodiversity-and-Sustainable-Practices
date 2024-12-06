<?php
session_start();
require 'dbuser.php';

$database = new Database();
$connect = $database->getConnect(); 

$redirectUrl = isset($_GET['redirect']) ? $_GET['redirect'] : 'useracc.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    try {
        // Fetch user from the database based on username
        $stmt = $connect->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Store user session data
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['account_id'] = $user['id'];  // Store the account_id in session
        
            // Redirect to the desired page
            header("Location: $redirectUrl");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
        
    } catch (PDOException $e) {
        // Handle any database errors
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Green Guardians</title>
    <link rel="stylesheet" href="Style/login.css">
</head>
<body>
    <form method="post" action="login.php">
        <h1>Login to Green Guardians</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

x           <button type="submit">Login</button>
        <p>Don't have an account? <a href="signup.php" style="color: #2c5f2d;">Sign up here</a>.</p>
    </form>

    <footer>
        <p>&copy; 2024 Green Guardians | Promoting Biodiversity and Sustainable Practices</p>
    </footer>
</body>
</html>
