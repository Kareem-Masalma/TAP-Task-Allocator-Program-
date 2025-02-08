<?php

session_start();
try {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['registration'] = $_POST;

    if (!isValidAge($_POST['birth-date'])) {
      $error = 'You must be at least 18 years old to register';
    }

    header('Location: registration_account.php');
    exit;
  }
} catch (Exception $e) {
  $error = $e->getMessage();
}

function isValidAge($birthDate)
{
  $today = new DateTime();
  $birthDate = new DateTime($birthDate);
  $diff = $today->diff($birthDate);

  return $diff->y >= 18;
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
  <header class="header">
    <?php include './header.html'; ?>
  </header>

  <nav class="nav">
    <a href="./registration.php" id="selected">User Registration</a>
    <a href="./login.php">User Login</a>
  </nav>

  <main class="main">
    <h2 class="main-title">Registration - Step 1: Personal Information</h2>
    <form method="post" action="" class="form">
      <fieldset class="form-fieldset">
        <legend class="form-legend">Personal Information</legend>

        <section class="form-group">
          <label for="name" class="form-label">Full Name:</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required>
        </section>

        <section class="form-group">
          <label for="address" class="form-label">Address:</label>
          <section class="form-address">
            <input type="text" name="house" class="form-control" placeholder="Flat/House No" required>
            <input type="text" name="street" class="form-control" placeholder="Street" required>
            <input type="text" name="city" class="form-control" placeholder="City" required>
            <input type="text" name="country" class="form-control" placeholder="Country" required>
          </section>
        </section>

        <section class="form-group">
          <label for="birth-date" class="form-label">Date of Birth:</label>
          <input type="date" id="birth-date" name="birth-date" class="form-control" required>
        </section>

        <section class="form-group">
          <label for="id" class="form-label">ID Number:</label>
          <input type="number" id="id" name="id" class="form-control" placeholder="Enter your ID number" min="0" required>
        </section>

        <section class="form-group">
          <label for="email" class="form-label">Email:</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
        </section>

        <section class="form-group">
          <label for="telephone" class="form-label">Telephone:</label>
          <input type="tel" id="telephone" name="telephone" class="form-control" placeholder="Enter a 10-digit number" pattern="^\d{10}$" title="Please enter a 10-digit telephone number" required>
        </section>

        <section class="form-group">
          <label for="role" class="form-label">Role:</label>
          <select id="role" name="role" class="form-control" required>
            <option value="">Select Role</option>
            <option value="Manager">Manager</option>
            <option value="Project Leader">Project Leader</option>
            <option value="Team Member">Team Member</option>
          </select>
        </section>

        <section class="form-group">
          <label for="qualification" class="form-label">Qualification:</label>
          <select id="qualification" name="qualification" class="form-control" required>
            <option value="">Select Qualification</option>
            <option value="High School">High School</option>
            <option value="Associate Degree">Associate Degree</option>
            <option value="Bachelor's Degree">Bachelor's Degree</option>
            <option value="Master's Degree">Master's Degree</option>
            <option value="PhD">PhD</option>
          </select>
        </section>

        <section class="form-group">
          <label for="skills" class="form-label">Skills (comma-separated):</label>
          <input type="text" id="skills" name="skills" class="form-control" placeholder="E.g., Programming, Leadership" required>
        </section>

        <?php if (isset($error)): ?>
          <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <button type="submit" id="next-button" class="form-button">Next</button>
      </fieldset>
    </form>
  </main>

  <footer class="footer">
    <?php include './footer.html'; ?>
  </footer>
</body>

</html>