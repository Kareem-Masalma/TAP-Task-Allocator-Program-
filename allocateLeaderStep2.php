<?php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Manager') {
    header('Location: login.php');
    exit;
}


include 'db.inc.php';

$project = [];
$documents = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];

    $stmt = $pdo->prepare("SELECT * FROM projects WHERE project_id = :project_id");
    $stmt->execute([':project_id' => $project_id]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($project) {
        $stmt = $pdo->prepare("SELECT * FROM project_files WHERE project_id = :project_id");
        $stmt->execute([':project_id' => $project_id]);
        $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $error = "Project not found.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['allocate_leader'])) {
    $project_id = $_POST['project_id'];
    $project_leader = $_POST['project_leader'];

    if (!empty($project_leader)) {
        $stmt = $pdo->prepare("UPDATE projects SET project_leader = :project_leader WHERE project_id = :project_id");
        $stmt->execute([':project_leader' => $project_leader, ':project_id' => $project_id]);

        $success_message = "Team Leader successfully allocated to Project ID: $project_id.";
    } else {
        $error = "Please select a team leader.";
    }
}
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
        <?php include 'header.php'; ?>
    </header>

    <nav class="nav">
        <a href="./addProject.php">Add Project</a>
        <a href="./allocateLeader.php" id="selected">Allocate Team Leader to Project</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>

    <main class="main">
        <form action="" method="post" class="form">
            <fieldset class="form-fieldset">
                <legend class="form-legend">Project Details</legend>
                <section class="form-group">
                    <label for="project_id">Project ID:</label>
                    <input type="text" name="project_id" id="project_id" value="<?= isset($project['project_id']) ? $project['project_id'] : '' ?>" readonly>
                </section>

                <section class="form-group">
                    <label for="title">Project Title:</label>
                    <input type="text" name="title" id="title" value="<?= isset($project['title']) ? $project['title'] : '' ?>" readonly>
                </section>

                <section class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" readonly><?= isset($project['description']) ? $project['description'] : '' ?></textarea>
                </section>

                <section class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" name="customer_name" id="customer_name" value="<?= isset($project['customer_name']) ? $project['customer_name'] : '' ?>" readonly>
                </section>

                <section class="form-group">
                    <label for="budget">Budget:</label>
                    <input type="text" name="budget" id="budget" value="<?= isset($project['budget']) ? $project['budget'] : '' ?>" readonly>
                </section>

                <section class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="text" name="start_date" id="start_date" value="<?= isset($project['start_date']) ? $project['start_date'] : '' ?>" readonly>
                </section>

                <section class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="text" name="end_date" id="end_date" value="<?= isset($project['end_date']) ? $project['end_date'] : '' ?>" readonly>
                </section>
            </fieldset>

            <?php if (!empty($documents)): ?>
                <fieldset class="form-fieldset">
                    <legend class="form-legend">Project Documents</legend>
                    <ul>
                        <?php foreach ($documents as $doc): ?>
                            <li>
                                <a href="<?= htmlspecialchars($doc['file_path']) ?>" target="_blank">
                                    <?= htmlspecialchars($doc['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </fieldset>
            <?php endif; ?>

            <fieldset class="form-fieldset">
                <legend class="form-legend">Select Team Leader</legend>
                <section class="form-group">
                    <label for="project_leader">Team Leader:</label>
                    <select name="project_leader" id="project_leader" required>
                        <option value="">Select Leader</option>
                        <?php
                        $projectLeaders = $pdo->query("SELECT * FROM users WHERE role = 'Project Leader'")->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($projectLeaders as $leader) {
                            echo "<option value='" . $leader['user_id'] . "'>" . $leader['name'] . "</option>";
                        }
                        ?>
                    </select>
                </section>
            </fieldset>

            <button type="submit" name="allocate_leader">Confirm Allocation</button>
        </form>

        <?php if (!empty($success_message)): ?>
            <p id="success-message"><?= $success_message ?></p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p class="wrong-credentials"><?= $error ?></p>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <?php include 'footer.html'; ?>
    </footer>
</body>

</html>
