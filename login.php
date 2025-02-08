<?php

session_start();
require 'db.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute([':username' => $_POST['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $_POST['password'] == $user['password']) {
        $_SESSION['user'] = $user;
        if ($user['role'] == 'Manager') {
            header('Location: ./addProject.php');
        } else if ($user['role'] == 'Team Member') {
            header('Location: ./teamMember.php');
        } else {
            header('Location: ./taskCreation.php');
        }
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./login.css">
</head>

<body>

    <header>
        <?php include './header.html'; ?>
    </header>

    <nav>
        <a href="./registration.php">User Registration</a>
        <a href="./login.php" id="selected">User Login</a>
    </nav>

    <main>
        <form method="post" action="" class="registration-form">
            <fieldset>
                <legend>Log In</legend>

                <section class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </section>

                <section class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </section>

                <?php if (isset($error)): ?>
                    <p id="wrong-credentials"><?= $error ?></p>
                <?php endif; ?>

                <button type="submit">Login</button>
            </fieldset>
        </form>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>