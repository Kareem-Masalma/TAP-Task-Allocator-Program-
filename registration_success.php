<?php
session_start();

if (!isset($_SESSION['registration'])) {
    header("Location: registration.php");
    exit;
}

$userId = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <link rel="stylesheet" href="./registration_success.css">
</head>

<body>

    <nav class="nav">
        <a href="https://web1220535.studentprojects.ritaj.ps/">Home Page</a>
        <a href="./registration.php">Register</a>
        <a href="./login.php">Login</a>

    </nav>

    <main class="main">
        <h1>Registration Successful</h1>
        <p>Your user ID is: <?php echo $userId; ?></p>
        <p>You can now <a href="./login.php">login</a> to your account.</p>
    </main>


    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>

</body>

</html>