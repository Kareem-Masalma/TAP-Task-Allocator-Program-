<?php
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header</title>
  <link rel="stylesheet" href="./header.css">
  <style>
    header {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 15px 30px;
      background-color: #2C3E50;
      color: white;
      font-size: 1.2rem;
      border-bottom: 1px solid #BDC3C7;
      width: 100%;
    }

    .header-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      max-width: 1200px;
    }

    .nav-links {
      display: flex;
      align-items: center;
    }

    .nav-links a {
      margin-right: 20px;
      font-weight: 600;
      font-size: 1rem;
      transition: color 0.3s ease;
    }

    .nav-links a:hover {
      color: #3498DB;
    }

    .nav-links h1 {
      font-size: 1.6rem;
      font-weight: bold;
    }

    .user-auth {
      display: flex;
      align-items: center;
    }

    .user-profile {
      display: flex;
      align-items: center;
      margin-right: 15px;
    }

    .user-photo {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      margin-right: 10px;
      border: 2px solid #ddd;
    }

    .user-name {
      font-size: 1rem;
      font-weight: 600;
      color: #fff;
    }

    .auth-links {
      display: flex;
      align-items: center;
    }

    .auth-links a {
      margin-left: 15px;
      font-size: 1rem;
      font-weight: 600;
      color: #fff;
      transition: color 0.3s ease;
    }

    .auth-links a:hover {
      color: #3498DB;
    }
  </style>
</head>

<body>
  <header>
    <section class="header-content">
      <section class="nav-links">
        <a href="https://web1220535.studentprojects.ritaj.ps/" target="_blank">Go Home Page</a>
        <h1>Task Allocator Pro</h1>
      </section>

      <section class="user-auth">
        <section class="user-profile">
          <?php if ($user): ?>
            <a href="./profile.php" class="profile-link" target="_blank">
              <img src="./user.jpg" alt="User Photo" class="user-photo">
              <p class="user-name"><?php echo $user['username']; ?></p>
            </a>
          <?php else: ?>
            <a href="./login.php" class="profile-link">
              <img src="./user.jpg" alt="Default User Photo" class="user-photo">
              <p class="user-name">Guest</p>
            </a>
          <?php endif; ?>
        </section>

        <section class="auth-links">
          <?php if ($user): ?>
            <a href="./logout.php" class="auth-link">Logout</a>
          <?php else: ?>
            <p>
              <a href="./login.php" class="auth-link">Login</a>
              |
              <a href="./registration.php" class="auth-link">Sign-up</a>
            </p>
          <?php endif; ?>
        </section>
      </section>
    </section>
  </header>
</body>

</html>