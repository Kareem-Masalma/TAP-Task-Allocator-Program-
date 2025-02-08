<?php

try {
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Manager') {
        header('Location: login.php');
        exit;
    }

    require 'db.inc.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
        $projectID = $_POST['project_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $customerName = $_POST['customer_name'];
        $budget = $_POST['budget'];
        $startDate = $_POST['start_date'];
        $endDate = $_POST['end_date'];

        if (empty($projectID) || empty($title) || empty($description) || empty($customerName) || empty($budget) || empty($startDate) || empty($endDate)) {
            $error = 'All fields are required.';
        }
        if (!preg_match('/^[A-Z]{4}-\d{5}$/', $projectID)) {
            $error = 'Invalid project ID format. Must be in the format ABCD-12345';
        }
        if ($endDate <= $startDate) {
            $error = 'End date must be after start date';
        }

        if (!isDateAfterToday($startDate) || !isDateAfterToday($endDate)) {
            $error = 'Start and end dates must be after today';
        }

        if (!isset($error)) {
            $query = "INSERT INTO projects (project_id, title, description, customer_name, budget, start_date, end_date) VALUES (:project_id, :title, :description, :customer_name, :budget, :start_date, :end_date)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':project_id' => $projectID,
                ':title' => $title,
                ':description' => $description,
                ':customer_name' => $customerName,
                ':budget' => $budget,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
            ]);

            $projectId = $projectID;

            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $files = ['document1_file', 'document2_file', 'document3_file'];
            $titles = ['document1_title', 'document2_title', 'document3_title'];

            foreach ($files as $index => $fileKey) {
                if (!empty($_FILES[$fileKey]['tmp_name'])) {
                    $fileName = basename($projectId . '-' . $_FILES[$fileKey]['name']);
                    $filePath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $filePath)) {
                        $fileTitle = $_POST[$titles[$index]] ?? "Untitled";

                        $stmt = $pdo->prepare("INSERT INTO project_files (project_id, file_name, file_path, title) VALUES (:project_id, :file_name, :file_path, :title)");
                        $stmt->execute([
                            ':project_id' => $projectId,
                            ':file_name' => $fileName,
                            ':file_path' => 'uploads/' . $fileName,
                            ':title' => $fileTitle,
                        ]);
                    } else {
                        $error = 'Failed to upload file: ' . htmlspecialchars($fileName);
                    }
                }
            }


            if (!isset($error)) {
                $msg = 'Project added successfully';
            }
        }
    }
} catch (PDOException $e) {
    $error = 'Error: Failed to add project';
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
    <title>Add Project</title>
    <link rel="stylesheet" href="./registration.css">
</head>

<body>
    <header class="header">
        <?php
        include './header.php';
        ?>
    </header>
    <nav class="nav">
        <a href="./addProject.php" id="selected">Add Project</a>
        <a href="./allocateLeader.php">Allocate Team Leader to Project</a>
        <a href="./search.php">Search Tasks</a>
        <a href="./taskDetails.php">Task Details</a>
    </nav>
    <main class="main">
        <form method="POST" enctype="multipart/form-data" class="form">
            <fieldset class="form-fieldset">
                <legend class="form-legend">Add New Project</legend>

                <section class="form-group">
                    <label for="project_id">Project ID:</label>
                    <input type="text" id="project_id" name="project_id" required pattern="[A-Z]{4}-\d{5}" placeholder="e.g., ABCD-12345">
                </section>

                <section class="form-group">
                    <label for="title">Project Title:</label>
                    <input type="text" id="title" name="title" required>
                </section>

                <section class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                </section>

                <section class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" id="customer_name" name="customer_name" required>
                </section>

                <section class="form-group">
                    <label for="budget">Total Budget:</label>
                    <input type="number" id="budget" name="budget" required min="0">
                </section>

                <section class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required>
                </section>

                <section class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required>
                </section>

                <section class="form-group">
                    <label for="document1_title">Document 1 Title:</label>
                    <input type="text" id="document1_title" name="document1_title">
                </section>

                <section class="form-group">
                    <label for="document1_file">Document 1 Upload:</label>
                    <input type="file" id="document1_file" name="document1_file" accept=".pdf,.docx,.png,.jpg">
                </section>

                <section class="form-group">
                    <label for="document2_title">Document 2 Title:</label>
                    <input type="text" id="document2_title" name="document2_title">
                </section>

                <section class="form-group">
                    <label for="document2_file">Document 2 Upload:</label>
                    <input type="file" id="document2_file" name="document2_file" accept=".pdf,.docx,.png,.jpg">
                </section>

                <section class="form-group">
                    <label for="document3_title">Document 3 Title:</label>
                    <input type="text" id="document3_title" name="document3_title">
                </section>

                <section class="form-group">
                    <label for="document3_file">Document 3 Upload:</label>
                    <input type="file" id="document3_file" name="document3_file" accept=".pdf,.docx,.png,.jpg">
                </section>

                <?php if (isset($error)): ?>
                    <p id="wrong-credentials"><?= $error ?></p>
                <?php endif; ?>

                <?php if (isset($msg)): ?>
                    <p id="success-message"><?= $msg ?></p>
                <?php endif; ?>

                <button type="submit" name="add_project">Add Project</button>
            </fieldset>
        </form>
    </main>

    <footer class="footer">
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>