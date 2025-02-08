<?php

session_start();
require 'db.inc.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Team Member') {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_task'])) {
    $task_id = htmlspecialchars($_POST['task_id']);
    $progress = (int) $_POST['progress'];
    $status = htmlspecialchars($_POST['status']);

    if ($progress === 100) {
        $status = 'Completed';
    } elseif ($progress > 0 && $progress < 100) {
        $status = 'In Progress';
    } elseif ($progress === 0) {
        $status = 'Pending';
    }

    try {
        $stmt = $pdo->prepare("UPDATE tasks SET progress = :progress, status = :status WHERE task_id = :task_id");
        $stmt->execute([
            'progress' => $progress,
            'status' => $status,
            'task_id' => $task_id,
        ]);
        $success_message = "Task updated successfully.";
    } catch (PDOException $e) {
        $error_message = "Failed to update task.";
    }
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
    <title>Update Task</title>
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
        <h1>Update Task</h1>

        <form method="POST" id="update-form" class="task-update-form">
            <h2>Update Task</h2>
            <input type="hidden" name="task_id" value="<?php echo $_GET['task_id']; ?>">
            <label>Progress</label>
            <input type="range" name="progress" min="0" max="100" value="0" oninput="this.nextElementSibling.textContent = this.value + '%'">
            <span>0%</span>
            <label>Status</label>
            <select name="status" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
            <section class="form-actions">
                <button type="submit" name="update_task" class="btn-save">Save Changes</button>
                <a href="./teamMember.php" class="btn-cancel">Cancel</a>
            </section>
        </form>

        <?php if (isset($success_message)): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </main>

    <footer>
        <?php include './footer.html'; ?>
    </footer>

</body>

</html>