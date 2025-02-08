<?php
session_start();
require 'db.inc.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$tasks;

if ($_SESSION['user']['role'] === 'Team Member') {
   $stmt = $pdo->prepare('SELECT * FROM tasks t, task_assignments ta WHERE t.task_id = ta.task_id AND ta.user_id = ?');
    $stmt->execute([$_SESSION['user']['user_id']]);
    $tasks = $stmt->fetchAll();
} else if ($_SESSION['user']['role'] === 'Project Leader') {
    $stmt = $pdo->prepare('SELECT * FROM tasks t WHERE t.project_id IN (SELECT project_id FROM projects WHERE project_leader = ?)');
    $stmt->execute([$_SESSION['user']['user_id']]);
    $tasks = $stmt->fetchAll();
} else if ($_SESSION['user']['role'] === 'Manager') {
    $stmt = $pdo->prepare('SELECT * FROM tasks');
    $stmt->execute();
    $tasks = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link rel="stylesheet" href="./taskCreation.css">
</head>

<body>
    <header>
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <?php if ($_SESSION['user']['role'] === 'Manager'): ?>
            <a href="./addProject.php">Add Project</a>
            <a href="./allocateLeader.php">Allocate Team Leader to Project</a>
            <a href="./search.php">Search Tasks</a>
            <a href="./taskDetails.php" id="selected">Task Details</a>
        <?php elseif ($_SESSION['user']['role'] === 'Project Leader'): ?>
            <a href="./taskCreation.php">Create New Task</a>
            <a href="./assignTicket.php">Assign Tasks</a>
            <a href="./search.php">Search Tasks</a>
            <a href="./taskDetails.php" id="selected">Task Details</a>
        <?php elseif ($_SESSION['user']['role'] === 'Team Member'): ?>
            <a href="./acceptTasks.php">Assigned Tasks</a>
            <a href="./updateProgress.php">Update Progress</a>
            <a href="./search.php">Search Tasks</a>
            <a href="./taskDetails.php" id="selected">Task Details</a>
        <?php endif; ?>
    </nav>

    <main class="main">
        <table>
            <th>Task ID</th>
            <th>Task Name</th>
            <th>Project Name</th>
            <th>Progress</th>
            <th>Status</th>
            <?php
            if (isset($tasks)) {
                foreach ($tasks as $task) {
                    echo '<tr>';
                    echo '<td><a href="./taskDetails2.php?taskId=' . $task["task_id"] . '">' . $task['task_id'] . '</a></td>';
                    echo '<td>' . $task['task_name'] . '</td>';
                    echo '<td>' . $task['project_id'] . '</td>';
                    echo '<td>' . $task['progress'] . '</td>';
                    echo '<td>' . $task['status'] . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </table>
    </main>

    <footer>
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>