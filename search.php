<?php
session_start();
require 'db.inc.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$username = $user['username'];
$role = $user['role'];

$sortable_columns = ['task_id', 'task_name', 'project_name', 'status', 'priority', 'start_date', 'end_date', 'progress'];
$sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $sortable_columns) ? $_GET['sort'] : 'task_id';
$sort_direction = isset($_GET['direction']) && strtolower($_GET['direction']) === 'desc' ? 'DESC' : 'ASC';

$tasks = [];

$priority = $_GET['priority'] ?? '';
$status = $_GET['status'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$project_id = $_GET['project_id'] ?? '';

$params = [];

if ($role === 'Manager') {
    $query = "SELECT t.task_id, t.task_name, p.title AS project_name, t.status, t.priority, t.start_date, t.end_date, t.progress
              FROM tasks t
              JOIN projects p ON t.project_id = p.project_id
              WHERE 1=1";

    if (!empty($priority)) {
        $query .= " AND t.priority = :priority";
        $params['priority'] = $priority;
    }

    if (!empty($status)) {
        $query .= " AND t.status = :status";
        $params['status'] = $status;
    }

    if (!empty($start_date)) {
        $query .= " AND t.start_date >= :start_date";
        $params['start_date'] = $start_date;
    }

    if (!empty($end_date)) {
        $query .= " AND t.end_date <= :end_date";
        $params['end_date'] = $end_date;
    }

    if (!empty($project_id)) {
        $query .= " AND t.project_id = :project_id";
        $params['project_id'] = $project_id;
    }

    $query .= " ORDER BY $sort_column $sort_direction";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $tasks = $stmt->fetchAll();
} elseif ($role === 'Project Leader') {
    $query = "SELECT t.task_id, t.task_name, p.title AS project_name, t.status, t.priority, t.start_date, t.end_date, t.progress
              FROM tasks t
              JOIN projects p ON t.project_id = p.project_id
              WHERE p.project_leader = :user_id";

    if (!empty($priority)) {
        $query .= " AND t.priority = :priority";
        $params['priority'] = $priority;
    }

    if (!empty($status)) {
        $query .= " AND t.status = :status";
        $params['status'] = $status;
    }

    if (!empty($start_date)) {
        $query .= " AND t.start_date >= :start_date";
        $params['start_date'] = $start_date;
    }

    if (!empty($end_date)) {
        $query .= " AND t.end_date <= :end_date";
        $params['end_date'] = $end_date;
    }

    if (!empty($project_id)) {
        $query .= " AND t.project_id = :project_id";
        $params['project_id'] = $project_id;
    }

    $query .= " ORDER BY $sort_column $sort_direction";
    $stmt = $pdo->prepare($query);
    $params['user_id'] = $user['user_id'];
    $stmt->execute($params);
    $tasks = $stmt->fetchAll();
} elseif ($role === 'Team Member') {
    $query = "SELECT t.task_id, t.task_name, p.title AS project_name, t.status, t.priority, t.start_date, t.end_date, t.progress
              FROM tasks t
              JOIN projects p ON t.project_id = p.project_id
              JOIN task_assignments ta ON t.task_id = ta.task_id
              WHERE ta.user_id = :user_id";

    if (!empty($priority)) {
        $query .= " AND t.priority = :priority";
        $params['priority'] = $priority;
    }

    if (!empty($status)) {
        $query .= " AND t.status = :status";
        $params['status'] = $status;
    }

    if (!empty($start_date)) {
        $query .= " AND t.start_date >= :start_date";
        $params['start_date'] = $start_date;
    }

    if (!empty($end_date)) {
        $query .= " AND t.end_date <= :end_date";
        $params['end_date'] = $end_date;
    }

    if (!empty($project_id)) {
        $query .= " AND t.project_id = :project_id";
        $params['project_id'] = $project_id;
    }

    $query .= " ORDER BY $sort_column $sort_direction";
    $stmt = $pdo->prepare($query);
    $params['user_id'] = $user['user_id'];
    $stmt->execute($params);
    $tasks = $stmt->fetchAll();
}

$toggle_order = $sort_direction === 'ASC' ? 'desc' : 'asc';

$projects_stmt = $pdo->query("SELECT project_id, title FROM projects");
$projects = $projects_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Search</title>
    <link rel="stylesheet" href="./taskCreation.css">
</head>

<body>
    <header>
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <?php if ($_SESSION['user']['role'] === 'Manager'): ?>
            <a href="./addProject.php">Add Project</a>
            <a href="./allocateLeader.php">Allocate Project Leader to Project</a>
            <a href="./search.php" id="selected">Search Tasks</a>
            <a href="./taskDetails.php">Task Details</a>
        <?php elseif ($_SESSION['user']['role'] === 'Project Leader'): ?>
            <a href="./taskCreation.php">Create New Task</a>
            <a href="./assignTasks.php">Assign Tasks</a>
            <a href="./search.php" id="selected">Search Tasks</a>
            <a href="./taskDetails.php">Task Details</a>
        <?php elseif ($_SESSION['user']['role'] === 'Team Member'): ?>
            <a href="./acceptTasks.php">Assigned Tasks</a>
            <a href="./updateProgress.php">Update Progress</a>
            <a href="./search.php" id="selected">Search Tasks</a>
            <a href="./taskDetails.php">Task Details</a>
        <?php endif; ?>
    </nav>

    <main class="main">
        <h1>Task Search</h1>

        <form method="GET" class="search-form">
            <label for="priority">Priority:</label>
            <select name="priority" id="priority">
                <option value="">-- All --</option>
                <option value="Low" <?= $priority === 'Low' ? 'selected' : '' ?>>Low</option>
                <option value="Medium" <?= $priority === 'Medium' ? 'selected' : '' ?>>Medium</option>
                <option value="High" <?= $priority === 'High' ? 'selected' : '' ?>>High</option>
            </select>

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="">-- All --</option>
                <option value="Pending" <?= $status === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= $status === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Completed" <?= $status === 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($start_date) ?>">

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($end_date) ?>">

            <label for="project_id">Project:</label>
            <select name="project_id" id="project_id">
                <option value="">-- All --</option>
                <?php foreach ($projects as $project): ?>
                    <option value="<?= htmlspecialchars($project['project_id']) ?>" <?= $project_id == $project['project_id'] ? 'selected' : '' ?>><?= htmlspecialchars($project['title']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="search">Search</button>
        </form>

        <h1>Task Search Results</h1>

        <table class="task-table">
            <thead>
                <tr>
                    <th><a class="head" href="?sort=task_id&direction=<?= $toggle_order ?>">Task ID <?= $sort_column === 'task_id' ? ($sort_direction === 'ASC' ? '↓' : '↑') : '' ?></a></th>
                    <th><a class="head" href="?sort=task_name&direction=<?= $toggle_order ?>">Title <?= $sort_column === 'task_name' ? ($sort_direction === 'ASC' ? '↓' : '↑') : '' ?></a></th>
                    <th><a class="head" href="?sort=project_name&direction=<?= $toggle_order ?>">Project <?= $sort_column === 'project_name' ? ($sort_direction === 'ASC' ? '↓' : '↑') : '' ?></a></th>
                    <th><a class="head" href="?sort=status&direction=<?= $toggle_order ?>">Status <?= $sort_column === 'status' ? ($sort_direction === 'ASC' ? '↓' : '↑') : '' ?></a></th>
                    <th><a class="head" href="?sort=priority&direction=<?= $toggle_order ?>">Priority <?= $sort_column === 'priority' ? ($sort_direction === 'ASC' ? '↓' : '↑') : '' ?></a></th>
                    <th><a class="head" href="?sort=start_date&direction=<?= $toggle_order ?>">Start Date <?= $sort_column === 'start_date' ? ($sort_direction === 'ASC' ? '↓' : '↑') : '' ?></a></th>
                    <th><a class="head" href="?sort=end_date&direction=<?= $toggle_order ?>">End Date <?= $sort_column === 'end_date' ? ($sort_direction === 'ASC' ? '↓' : '↑') : '' ?></a></th>
                    <th><a class="head" href="?sort=progress&direction=<?= $toggle_order ?>">Completion % <?= $sort_column === 'progress' ? ($sort_direction === 'ASC' ? '↓' : '↑') : '' ?></a></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><a href="./task_details.php?task_id=<?= htmlspecialchars($task['task_id']) ?>"><?= htmlspecialchars($task['task_id']) ?></a></td>
                        <td><?= htmlspecialchars($task['task_name']) ?></td>
                        <td><?= htmlspecialchars($task['project_name']) ?></td>
                        <td class="<?= strtolower(str_replace(' ', '-', $task['status'])) ?>"> <?= htmlspecialchars($task['status']) ?></td>
                        <td class="<?= strtolower($task['priority']) ?>-priority"> <?= htmlspecialchars($task['priority']) ?></td>
                        <td><?= htmlspecialchars($task['start_date']) ?></td>
                        <td><?= htmlspecialchars($task['end_date']) ?></td>
                        <td><?= htmlspecialchars($task['progress']) ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (empty($tasks)): ?>
            <p>No tasks found.</p>
        <?php endif; ?>
    </main>

    <footer>
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>
