<?php

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'Team Member') {
    header('Location: login.php');
    exit();
}

require_once 'db.inc.php';
$task_id = $_GET['task_id'];
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE task_id = ?');
$stmt->execute([$task_id]);
$task = $stmt->fetch();

if (isset($_POST['accept'])) {
    $stmt = $pdo->prepare('UPDATE tasks SET status = "In Progress" WHERE task_id = ?');
    $stmt->execute([$task_id]);
    $stmt = $pdo->prepare('UPDATE task_assignments SET accepted = true WHERE task_id = ?');
    $stmt->execute([$task_id]);
    header('Location: acceptedTask.php?task_id=' . $task_id);
    exit();
}

if (isset($_POST['reject'])) {
    $stmt = $pdo->prepare('SELECT * FROM task_assignments WHERE task_id = ? and user_id = ?');
    $stmt->execute([$task_id, $_SESSION['user']['user_id']]);
    $assignment = $stmt->fetch();
    $stmt = $pdo->prepare('UPDATE tasks SET contribution = contribution - ? WHERE task_id = ?');
    $stmt->execute([$assignment['contribution_percentage'], $task_id]);
    $stmt = $pdo->prepare('UPDATE tasks SET number_of_members = number_of_members - 1 WHERE task_id = ?');
    $stmt->execute([$task_id]);
    $stmt = $pdo->prepare('DELETE FROM task_assignments WHERE task_id = ?');
    $stmt->execute([$task_id]);
    header('Location: rejectedTask.php?task_id=' . $task_id);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Task</title>
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
        <form action="" method="POST">
            <fieldset>
                <legend>Task Details</legend>
                <section class="form-group">
                    <label for="task_id">Task ID:</label>
                    <input type="text" id="task_id" name="task_id" value="<?php echo $task['task_id']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="task_name">Task Name:</label>
                    <input type="text" id="task_name" name="task_name" value="<?php echo $task['task_name']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" readonly><?php echo $task['description']; ?></textarea>
                </section>
                <section class="form-group">
                    <label for="priority">Priority:</label>
                    <input type="text" id="priority" name="priority" value="<?php echo $task['priority']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="status">Status:</label>
                    <input type="text" id="status" name="status" value="<?php echo $task['status']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="effort">Total Effort:</label>
                    <input type="text" id="effort" name="effort" value="<?php echo $task['effort']; ?>" readonly>
                </section>
                </section>
                <section class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="text" id="start_date" name="start_date" value="<?php echo $task['start_date']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="text" id="end_date" name="end_date" value="<?php echo $task['end_date']; ?>" readonly>
                </section>
                <section class="form-group">
                    <button type="submit" name="accept" id="btn-accept">Accept</button>
                    <button type="submit" name="reject" id="btn-reject">Reject</button>
                </section>
            </fieldset>
        </form>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>