<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Team Member') {
    header('Location: login.php');
    exit();
}

$task_id = $_GET['task_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Rejected</title>
    <link rel="stylesheet" href="./manageTask.css">
</head>

<body>
    <header>
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <a href="" id="selected">Assigned Tasks</a>
        <a href="./updateProgress.php">Update Progress</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main class="main">
        <h1>Task Rejected</h1>
        <p>You have rejected Task ID: <strong><?php echo $task_id; ?></strong>.</p>
        <p>If this was a mistake or you change your mind, please contact your project leader.</p>
        <a href="./acceptTasks.php" class="btn btn-secondary">Back to Tasks</a>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>

</body>

</html>