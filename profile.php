<?php

session_start();
$user = $_SESSION['user'] ?? null;
if (!$user) {
    header('Location: ./login.php');
    exit;
}

// Simulate user data from session for demonstration purposes.
// In a real application, this data should come from a database query.
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="./profile.css">
</head>

<body>
    <header>
        <div class="nav-links">
            <a href="./index.php">Home</a>
            <a href="./logout.php">Logout</a>
        </div>
    </header>

    <main>
        <section class="profile-container">
            <div class="profile-header">
                <img src="./user.jpg" alt="User Photo" class="user-photo">
                <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                <p class="role"><?php echo htmlspecialchars($user['role']); ?></p>
            </div>

            <div class="profile-details">
                <h2>Profile Details</h2>
                <table>
                    <tr>
                        <th>Full Name:</th>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Role:</th>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo htmlspecialchars($user['address']); ?></td>
                    </tr>
                    <tr>
                        <th>Skills:</th>
                        <td><?php echo htmlspecialchars($user['skills']); ?></td>
                    </tr>
                </table>
            </div>
        </section>
    </main>
</body>

</html>