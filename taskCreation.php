<?php

session_start();
require 'db.inc.php';
try {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Leader') {
        header('Location: ./login.php');
        exit;
    }

    $user_id = $_SESSION['user']['user_id'];
    $stmt = $pdo->prepare("SELECT project_id, title FROM projects WHERE project_leader = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $projects = $stmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $task_id = $_POST['task_id'];
        $task_name = $_POST['task_name'];
        $description = $_POST['description'];
        $project_id = $_POST['project_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $effort = $_POST['effort'];
        $status = $_POST['status'];
        $priority = $_POST['priority'];

        if (!isDateAfterToday($start_date) || !isDateAfterToday($end_date)) {
            $error = "Start and end dates must be later than today.";
        }

        if ($end_date <= $start_date) {
            $error =  "End date must be later than the start date.";
        }

        $stmt = $pdo->prepare(
            "INSERT INTO tasks (task_id, task_name, description, project_id, start_date, end_date, effort, status, priority) " .
                "VALUES (:task_id, :task_name, :description, :project_id, :start_date, :end_date, :effort, :status, :priority)"
        );
        $stmt->execute([
            'task_id' => $task_id,
            'task_name' => $task_name,
            'description' => $description,
            'project_id' => $project_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'effort' => $effort,
            'status' => $status,
            'priority' => $priority
        ]);

        $msg = "Task created successfully!";
    }
} catch (PDOException $e) {
    $error = 'Error: Failed to create task.';
}
function isDateAfterToday($date)
{
    $today = new DateTime();
    $inputDate = new DateTime($date);

    return $inputDate > $today;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="./taskCreation.css">
</head>

<body>
    <header class="header">
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <a href="" id="selected">Create new Task</a>
        <a href="./assignTicket.php">Assign tasks</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main class="main">
        <form action="" method="POST" class="task-form">
            <?php if (isset($error)): ?>
                <p id="wrong-credentials"><?= $error ?></p>
            <?php endif; ?>

            <?php if (isset($msg)): ?>
                <p id="success-message"><?= $msg ?></p>
            <?php endif; ?>
            <label for="task_id">Task ID:</label>
            <input type="text" id="task_id" name="task_id" required>

            <label for="task_name">Task Name:</label>
            <input type="text" id="task_name" name="task_name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="project_id">Project:</label>
            <select id="project_id" name="project_id" required>
                <option value="">-- Select a Project --</option>
                <?php foreach ($projects as $project): ?>
                    <option value="<?php echo $project['project_id']; ?>">
                        <?php echo $project['title']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="effort">Effort (man-months):</label>
            <input type="number" id="effort" name="effort" min="0" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>

            <label for="priority">Priority:</label>
            <select id="priority" name="priority" required>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>

            <button type="submit">Create Task</button>
        </form>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>