<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Team Member') {
    header('Location: login.php');
    exit();
}
require_once 'db.inc.php';

$stmt = $pdo->prepare('SELECT * FROM task_assignments ta WHERE  ta.user_id = ? and accepted = 0');
$stmt->execute([$_SESSION['user']['user_id']]);

$yellow = false;
if ($stmt->rowCount() > 0) {
    $yellow = true;
}

$tasks = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Tasks</title>
    <link rel="stylesheet" href="./taskCreation.css">
</head>

<body>
    <header class="header">
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <?php if ($yellow) : ?>
            <a href="./acceptTasks.php" id="newTask">Assigned Tasks</a>
        <?php else : ?>
            <a href="./acceptTasks.php">Assigned Tasks</a>
        <?php endif; ?>
        <a href="./updateProgress.php">Update Progress</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main class="main">
        <h2>Welcome <?php echo $_SESSION['user']['name'] ?></h2>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>