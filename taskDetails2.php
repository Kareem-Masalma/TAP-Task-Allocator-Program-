<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require 'db.inc.php';

$task_id = $_GET['taskId'];
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE task_id = ?');
$stmt->execute([$task_id]);
$task = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM task_assignments ta, tasks t WHERE ta.task_id = ? and ta.task_id = t.task_id');
$stmt->execute([$task_id]);
$assignments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link rel="stylesheet" href="./task_details.css">
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
            <a href="./assignTasks.php">Assign Tasks</a>
            <a href="./search.php">Search Tasks</a>
            <a href="./taskDetails.php" id="selected">Task Details</a>
        <?php elseif ($_SESSION['user']['role'] === 'Team Member'): ?>
            <a href="./acceptTasks.php">Assigned Tasks</a>
            <a href="./updateProgress.php">Update Progress</a>
            <a href="./search.php">Search Tasks</a>
            <a href="./taskDetails.php" id="selected">Task Details</a>
        <?php endif; ?>
    </nav>

    <main class="container">
        <section class="task-details">
            <h2>Task Details</h2>
            <p><strong>Task ID:</strong> <?php echo $task['task_id']; ?></p>
            <p><strong>Task Name:</strong> <?php echo $task['task_name']; ?></p>
            <p><strong>Description:</strong> <?php echo $task['description']; ?></p>
            <p><strong>Start Date:</strong> <?php echo $task['start_date']; ?></p>
            <p><strong>End Date:</strong> <?php echo $task['end_date']; ?></p>
            <p><strong>Completion Percentage:</strong> <?php echo $task['progress']; ?>%</p>
            <p><strong>Status:</strong> <?php echo $task['status']; ?></p>
            <p><strong>Priority:</strong> <?php echo $task['priority']; ?></p>
        </section>

        <section class="team-members">
            <h2>Team Members</h2>
            <table>
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Effort (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assignments as $assignment): ?>
                        <?php
                        $stmt = $pdo->prepare('SELECT name FROM users WHERE user_id = ?');
                        $stmt->execute([$assignment['user_id']]);
                        $member = $stmt->fetch();
                        ?>
                        <tr>
                            <td><?php echo $assignment['user_id']; ?></td>
                            <td><?php echo $member['name']; ?></td>
                            <td><?php echo $assignment['role']; ?></td>
                            <td><?php echo $assignment['start_date']; ?></td>
                            <td><?php echo $assignment['end_date'] ?? 'In Progress'; ?></td>
                            <td><?php echo $assignment['contribution_percentage']; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>