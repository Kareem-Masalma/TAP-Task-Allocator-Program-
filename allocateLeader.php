<?php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Manager') {
    header('Location: login.php');
    exit;
}


require 'db.inc.php';

$projects = $pdo->query("SELECT project_id, title, start_date, end_date FROM projects WHERE project_leader is null ORDER BY start_date")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate Project Leader</title>
    <link rel="stylesheet" href="./styles.css">

</head>

<body>
    <header class="header">
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <a href="./addProject.php">Add Project</a>
        <a href="./allocateLeader.php" id="selected">Allocate Project Leader to Project</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main class="main">
        <h2>Allocate Project Leader to a Project</h2>

        <?php if (!empty($success_message)): ?>
            <p style="color: green;"><?= $success_message ?></p>
        <?php endif; ?>

        <table>
            <tr>
                <th>Project ID</th>
                <th>Project Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>

            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= $project['project_id'] ?></td>
                    <td><?= $project['title'] ?></td>
                    <td><?= $project['start_date'] ?></td>
                    <td><?= $project['end_date'] ?></td>
                    <td><a href="./allocateLeaderStep2.php?project_id=<?= $project['project_id'] ?>" class="allocate_leader">
                            Allocate Project Leader
                        </a></td>
                </tr>
            <?php endforeach; ?>

        </table>

    </main>
    <footer class="footer">
        <?php include 'footer.html'; ?>
    </footer>
</body>

</html>