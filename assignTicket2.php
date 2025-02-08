<?php
session_start();
require 'db.inc.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Project Leader') {
    header('Location: login.php');
    exit;
}

try {
    if (!isset($_GET['task_id']) || empty($_GET['task_id'])) {
        $error = 'Task ID is missing. Please select a valid task.';
    }

    $task_id = $_GET['task_id'];
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE task_id = :task_id");
    $stmt->execute(['task_id' => $task_id]);
    $task = $stmt->fetch();

    if (!$task) {
        $error = 'Task not found. Please check the task ID.';
    }

    if (isset($_POST['assign'])) {
        $member = $_POST['team-member'];
        $role = $_POST['role'];
        $contribution_percentage = $_POST['contribution-percentage'];

        if ($task['contribution'] + $contribution_percentage > 100) {
            $error_cont = 'Contribution percentage exceeds 100%. Please enter a valid percentage.';
            exit;
        }


        $stmt = $pdo->prepare("INSERT INTO task_assignments (task_id, user_id, role, contribution_percentage) 
                               VALUES (:task_id, :user_id, :role, :contribution_percentage)");
        $stmt->execute([
            'task_id' => $task_id,
            'user_id' => $member,
            'role' => $role,
            'contribution_percentage' => $contribution_percentage,
        ]);

        $stmt = $pdo->prepare("UPDATE tasks SET number_of_members = number_of_members + 1 WHERE task_id = :task_id");
        $stmt->execute(['task_id' => $task_id]);
        $stmt = $pdo->prepare("UPDATE tasks SET contribution = contribution + :contribution_percentage WHERE task_id = :task_id");
        $stmt->execute(['task_id' => $task_id, 'contribution_percentage' => $contribution_percentage]);

        header('Location: ./assignSuccessful.php?task_id=' . $task_id . '&role=' . $role);
        exit;
    }
} catch (PDOException $e) {
    $error = "An error occurred while processing your request.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Ticket</title>
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
        <form action="" class="form" method="POST">
            <fieldset>
                <legend>Assign Team Members</legend>

                <?php if (isset($error)) : ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>

                <label for="task-id" class="form-group">Task ID</label>
                <br>
                <input type="text" id="task-id" class="form-group" name="task-id" readonly value="<?php echo $task['task_id']; ?>">
                <br>
                <label for="task-title" class="form-group">Task Title</label>
                <br>
                <input type="text" id="task-title" class="form-group" name="task-title" readonly value="<?php echo $task['task_name']; ?>">
                <br>
                <label for="start-data" class="form-group">Start Date</label>
                <br>
                <input type="text" id="start-date" class="form-group" name="start-date" readonly value="<?php echo $task['start_date']; ?>">
                <br>
                <label for="team-member" class="form-group">Team Member</label>
                <br>
                <select name="team-member" id="team-member" class="form-group" required>
                    <option value="">-- Select Team Member --</option>
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'Team Member'");
                    $stmt->execute();
                    $team_members = $stmt->fetchAll();
                    foreach ($team_members as $team_member) {
                        echo '<option value="' . $team_member['user_id'] . '">' . $team_member['username'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <label for="role" class="form-group">Role</label>
                <br>
                <select name="role" id="role" class="form-group" required>
                    <option value="">-- Select Role --</option>
                    <option value="Developer">Developer</option>
                    <option value="Tester">Tester</option>
                    <option value="Designer">Designer</option>
                    <option value="Analyst">Analyst</option>
                    <option value="Support">Support</option>
                </select>
                <br>
                <label for="contribution-percentage" class="form-group">Contribution Percentage</label>
                <br>
                <input type="number" id="contribution-percentage" class="form-group" name="contribution-percentage" min="0" max="100" required>

                <?php if (isset($error_cont)) : ?>
                    <p class="wrong-credentials"><?php echo $error_cont; ?></p>
                <?php endif; ?>

                <br>
                <button type="submit" class="form-group" name="assign">Assign</button>
            </fieldset>
        </form>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>

</body>

</html>