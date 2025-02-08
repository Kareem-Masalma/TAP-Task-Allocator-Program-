<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Team Member') {
    header('Location: login.php');
    exit();
}
require_once 'db.inc.php';

$stmt = $pdo->prepare('SELECT * FROM tasks t, task_assignments ta WHERE ta.task_id = t.task_id and ta.user_id = ?');
$stmt->execute([$_SESSION['user']['user_id']]);
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
        <a href="" id="selected">Assigned Tasks</a>
        <a href="./updateProgress.php">Update Progress</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main class="main">
        <table>
            <th>Task ID</th>
            <th>Task Name</th>
            <th>Project Name</th>
            <th>Start Date</th>
            <th>Confirm</th>
            <?php
            foreach ($tasks as $task) {
                echo '<tr>';
                echo '<td>' . $task['task_id'] . '</td>';
                echo '<td>' . $task['task_name'] . '</td>';
                echo '<td>' . $task['project_id'] . '</td>';
                echo '<td>' . $task['start_date'] . '</td>';
                echo '<td><a href="./confirmTask.php?task_id=' . $task['task_id'] . '">Confirm</a></td>';
                echo '</tr>';
            }
            ?>
        </table>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>