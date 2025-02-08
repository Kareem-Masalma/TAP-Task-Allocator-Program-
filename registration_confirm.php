<?php
session_start();

require_once 'db.inc.php';

if (!isset($_SESSION['registration'])) {
    header("Location: registration.php");
    exit;
}

$userData = $_SESSION['registration'];
$userId = mt_rand(1000000000, 9999999999);
$_SESSION['user_id'] = $userId;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $address = $userData['house'] . ', ' . $userData['street'] . ', ' . $userData['city'] . ', ' . $userData['country'];

        $stmt = $pdo->prepare("INSERT INTO users 
            (name, address, birth_date, id_number, email, role, phone, qualification, skills, username, password, user_id) 
            VALUES 
            (:name, :address, :birth_date, :id_number, :email, :role, :phone, :qualification, :skills, :username, :password, :user_id)");

        $stmt->execute([
            ':name' => $userData['name'],
            ':address' => $address,
            ':birth_date' => $userData['birth-date'],
            ':id_number' => $userData['id'],
            ':email' => $userData['email'],
            ':role' => $userData['role'],
            ':phone' => $userData['telephone'],
            ':qualification' => $userData['qualification'],
            ':skills' => $userData['skills'],
            ':username' => $userData['username'],
            ':user_id' => $userId,
            ':password' => $userData['password']
        ]);

        header("Location: ./registration_success.php");
        exit;
    } catch (PDOException $e) {
        $error = 'Error: Registration failed.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Step 1</title>
    <link rel="stylesheet" href="./registration.css">
</head>

<body>
    <header>
        <?php
        include './header.html';
        ?>
    </header>
    <nav>
        <a href="./registration.php" id="selected">User Registration</a>
        <a href="./login.php">User Login</a>
    </nav>
    <main>
        <h1>Registration - Step 3: Confirmation</h1>
        <form method="post" action="./registration_confirm.php" class="form">
            <fieldset>
                <legend>Confirm Your Information</legend>

                <section class="form-group">
                    <label>Name:</label>
                    <input type="text" value="<?= $userData['name']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label>Address:</label>
                    <input type="text" value="<?= $userData['house'] . ', ' . $userData['street'] . ', ' . $userData['city'] . ', ' . $userData['country']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label>Date of Birth:</label>
                    <input type="text" value="<?= $userData['birth-date']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label>ID Number:</label>
                    <input type="text" value="<?= $userData['id']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label>Email Address:</label>
                    <input type="email" value="<?= $userData['email']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label>Role:</label>
                    <input type="text" value="<?= $userData['role']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label>Telephone:</label>
                    <input type="text" value="<?= $userData['telephone']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label>Qualification:</label>
                    <input type="text" value="<?= $userData['qualification']; ?>" readonly>
                </section>
                <section class="form-group">
                    <label>Skills:</label>
                    <input type="text" value="<?= $userData['skills']; ?>" readonly>
                </section>

                <section class="form-group">
                    <label>Username:</label>
                    <input type="text" value="<?= $userData['username']; ?>" readonly>
                </section>

                <?php if (isset($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>

                <button type="submit" id="confirm-button">Confirm</button>
            </fieldset>
        </form>
    </main>
    <footer>
        <?php include './footer.html'; ?>
    </footer>
</body>

</html>