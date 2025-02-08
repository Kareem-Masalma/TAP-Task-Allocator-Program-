<?php
session_start();
require 'db.inc.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Leader') {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['task_id']) || !isset($_GET['role'])) {
    die('Invalid access. Task ID and Role are required.');
}

$task_id = htmlspecialchars($_GET['task_id']);
$role = htmlspecialchars($_GET['role']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Successful</title>
    <link rel="stylesheet" href="./taskCreation.css">
</head>

<body>
    <header class="header">
        <?php include './header.php'; ?>
    </header>

    <nav class="nav">
        <a href="./createTicket.php">Create Ticket</a>
        <a href="./assignTicket.php" id="selected">Assign Ticket</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main class="main">
        <section class="success-message">
            <h1>Team Member Assigned Successfully!</h1>
            <p>Team member has been successfully assigned to Task <strong><?php echo $task_id; ?></strong> as <strong><?php echo $role; ?></strong>.</p>
        </section>

        <section class="form-actions">
            <form action="assignTicket2.php" method="GET">
                <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                <button type="submit" class="btn btn-primary">Add Another Team Member</button>
            </form>
            <a href="./assignTicket.php" class="btn btn-secondary">Finish Allocation</a>
        </section>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>
