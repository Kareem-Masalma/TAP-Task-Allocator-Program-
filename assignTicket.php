<?php
session_start();
require 'db.inc.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Leader') {
    header('Location: login.php');
    exit;
}

try {
    $user_id = $_SESSION['user']['user_id'];
    $stmt = $pdo->prepare("SELECT project_id, title FROM projects WHERE project_leader = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $projects = $stmt->fetchAll();

    $selected_project = isset($_GET['project_id']) ? $_GET['project_id'] : null;
    $tasks = [];
    if ($selected_project) {
        $stmt = $pdo->prepare("
        SELECT *
        FROM tasks t
        WHERE t.project_id = :project_id
        ORDER BY number_of_members
    ");
        $stmt->execute(['project_id' => $selected_project]);
        $tasks = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    $error = "An error occurred";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Team Members</title>
    <link rel="stylesheet" href="./taskCreation.css">
</head>

<body>
    <header class="header">
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <a href="./taskCreation.php">Create new Task</a>
        <a href="./assignTasks.php" id="selected">Assign tasks</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main class="main">
        <form action="" method="GET">
            <fieldset class="form-fieldset">
                <legend class="form-legend">Assign Team Members</legend>
                <label for="project_id">Select a Project:</label>
                <select name="project_id" id="project_id" onchange="this.form.submit()" required>
                    <option value="">-- Select Project --</option>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?php echo htmlspecialchars($project['project_id']); ?>"
                            <?php echo $selected_project === $project['project_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($project['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </fieldset>
        </form>

        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($tasks)): ?>
            <table class="task-table">
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Task Name</th>
                        <th>Start Date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th># Members</th>
                        <th>Team Allocation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?php echo $task['task_id']; ?></td>
                            <td><?php echo $task['task_name']; ?></td>
                            <td><?php echo $task['start_date']; ?></td>
                            <td><?php echo $task['status']; ?></td>
                            <td><?php echo $task['priority']; ?></td>
                            <td><?php echo $task['number_of_members']; ?></td>
                            <td>
                                <a href="./assignTicket2.php?task_id=<?php echo $task['task_id']; ?>">
                                    Assign Team Members
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($selected_project): ?>
            <p>No tasks available for this project.</p>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>