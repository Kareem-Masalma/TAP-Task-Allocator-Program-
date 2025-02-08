<?php
session_start();
require 'db.inc.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Team Member') {
    header('Location: login.php');
    exit;
}

$tasks = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $task_id = $_GET['task_id'];
    $task_name = $_GET['task_name'];
    $project_name = $_GET['project_name'];

    $query = "
        SELECT t.task_id, t.task_name, p.title AS project_name, t.progress, t.status
        FROM tasks t
        JOIN projects p ON t.project_id = p.project_id
        WHERE (t.task_id LIKE :task_id OR :task_id = '')
        AND (t.task_name LIKE :task_name OR :task_name = '')
        AND (p.title LIKE :project_name OR :project_name = '')
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'task_id' => "%$task_id%",
        'task_name' => "%$task_name%",
        'project_name' => "%$project_name%",
    ]);
    $tasks = $stmt->fetchAll();
}

$stmt = $pdo->prepare('SELECT * FROM task_assignments ta WHERE  ta.user_id = ? and accepted = 0');
$stmt->execute([$_SESSION['user']['user_id']]);

$yellow = false;
if ($stmt->rowCount() > 0) {
    $yellow = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Tasks</title>
    <link rel="stylesheet" href="./taskCreation.css">
</head>

<body>
    <header>
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <?php if ($yellow) : ?>
            <a href="./acceptTasks.php" id="newTasks">Assigned Tasks</a>
        <?php else : ?>
            <a href="./acceptTasks.php">Assigned Tasks</a>
        <?php endif; ?>
        <a href="" id="selected">Update Progress</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main>
        <h1>Search and Update Tasks</h1>

        <form method="GET" class="search-form">
            <input type="text" name="task_id" placeholder="Task ID" value="<?php echo $_GET['task_id'] ?? ''; ?>">
            <input type="text" name="task_name" placeholder="Task Name" value="<?php echo $_GET['task_name'] ?? ''; ?>">
            <input type="text" name="project_name" placeholder="Project Name" value="<?php echo $_GET['project_name'] ?? ''; ?>">
            <button type="submit" name="search">Search</button>
        </form>

        <?php if (!empty($tasks)): ?>
            <table class="task-table">
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Task Name</th>
                        <th>Project Name</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?php echo $task['task_id']; ?></td>
                            <td><?php echo $task['task_name']; ?></td>
                            <td><?php echo $task['project_name']; ?></td>
                            <td><?php echo $task['progress']; ?>%</td>
                            <td><?php echo $task['status']; ?></td>
                            <td><a href="./updateProgress2.php?task_id=<?php echo $task['task_id']; ?>#update-form">Update</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </main>
    <footer>
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>