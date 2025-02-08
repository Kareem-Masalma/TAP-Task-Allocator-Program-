<?php
session_start();

$error = '';
try {

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if (strlen($username) < 6 || strlen($username) > 13) {
      $error = 'Username must be between 6 and 13 characters.';
    } elseif (strlen($password) < 8 || strlen($password) > 12) {
      $error = 'Password must be between 8 and 12 characters.';
    } elseif ($password !== $confirm_password) {
      $error = 'Password and confirmation do not match.';
    }

    if (!$error) {
      $_SESSION['registration']['username'] = $username;
      $_SESSION['registration']['password'] = $password;

      header('Location: registration_confirm.php');
      exit;
    }
  }
} catch (PDOException $e) {
  $error = 'Error: Registration failed.';
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
    <h1>Registration - Step 2: E-Account Creation</h1>
    <form method="post" action="" class="form">
      <fieldset>
        <legend>E-Account Creation</legend>

        <?php if ($error): ?>
          <p style="color: red;"><?= $error; ?></p>
        <?php endif; ?>

        <section class="form-group">
          <label for="username">Username:</label>
          <input type="text" name="username" class="form-control" placeholder="Username" value="<?= isset($username) ? $username : ''; ?>" required>
        </section>

        <section class="form-group">
          <label for="password">Password:</label>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </section>

        <section class="form-group">
          <label for="confirm-password">Confirm Password:</label>
          <input type="password" name="confirm-password" class="form-control" placeholder="Confirm Password" required>
        </section>

        <?php if (isset($error)): ?>
          <p id="wrong-credentials"><?= $error ?></p>
        <?php endif; ?>

        <button type="submit" id="next-button">Next</button>
      </fieldset>
    </form>
  </main>
  <footer>
    <?php include './footer.html'; ?>
  </footer>
</body>

</html>