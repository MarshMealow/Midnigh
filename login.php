<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $message = "Please enter username and password.";
    } else {
        $sql = "SELECT * FROM sellers WHERE username='$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $seller = mysqli_fetch_assoc($result);

            if (password_verify($password, $seller['password'])) {
                $_SESSION['seller_id'] = $seller['seller_id'];
                $_SESSION['username'] = $seller['username'];
                header("Location: cars.php");
                exit();
            } else {
                $message = "Invalid password.";
            }
        } else {
            $message = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Midnight Motors — Login</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="css/style.css" />

  <style>
    .login-wrapper {
      max-width: 520px;
      margin: 48px auto 120px;
    }
  </style>
</head>

<body>

<!-- nav bar -->
<nav class="nav">
  <div class="nav__inner">
    <a href="index.php" class="nav__logo">MIDNIGHT <span>MOTORS</span></a>
    <ul class="nav__links">
      <li><a href="index.php" class="nav__link">Home</a></li>
      <li><a href="register.php" class="nav__link ">Register</a></li>
      <?php if (isset($_SESSION['seller_id'])) { ?>
      <li><a href="logout.php" class="nav__link">Logout</a></li>
      <?php } else { ?>
      <li><a href="login.php" class="nav__link nav__link--active">Login</a></li>
      <?php } ?>
      <li><a href="cars.php" class="nav__link">Cars for Sale</a></li>
      <li><a href="search.php" class="nav__link">Search</a></li>
      <li><a href="feedback.php" class="nav__link">Feedback</a></li>
    </ul>

    <button class="nav__hamburger" id="hamburger" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>
  </div>

  <ul class="nav__mobile" id="mobile-menu">
    <li><a href="index.php" class="nav__link">Home</a></li>
    <li><a href="register.php" class="nav__link ">Register</a></li>
    <?php if (isset($_SESSION['seller_id'])) { ?>
      <li><a href="logout.php" class="nav__link">Logout</a></li>
      <?php } else { ?>
      <li><a href="login.php" class="nav__link nav__link--active">Login</a></li>
      <?php } ?>
    <li><a href="cars.php" class="nav__link">Cars for Sale</a></li>
    <li><a href="search.php" class="nav__link">Search</a></li>
    <li><a href="feedback.php" class="nav__link">Feedback</a></li>
  </ul>
</nav>

<main>
  <div class="banner" style="height:140px; background: linear-gradient(135deg, #0D1A2D 0%, #0A0A0F 100%);">
    <div class="banner__overlay">
      <h2 class="banner__title">Seller Login</h2>
    </div>
  </div>

  <div class="container">
    <div class="login-wrapper">
      <div class="page-header">
        <div class="page-header__badge">Seller access</div>
        <h1 class="page-header__title">Sign in to your account</h1>
        <p class="page-header__sub">Login to add, manage, or delete your car listings.</p>
      </div>

      <?php if (!empty($message)) { ?>
        <p style="color:#ef4444; font-weight:700;"><?php echo $message; ?></p>
      <?php } ?>

      <form method="POST" action="login.php" class="form">
        <div class="form__group">
          <label class="form__label">Username</label>
          <input class="form__input" type="text" name="username" placeholder="Enter username">
        </div>

        <div class="form__group">
          <label class="form__label">Password</label>
          <input class="form__input" type="password" name="password" placeholder="Enter password">
        </div>

        <div class="form__actions">
          <button type="submit" class="btn btn--primary">Login</button>
          <a href="register.php" class="btn btn--secondary">Create account</a>
        </div>
      </form>
    </div>
  </div>
</main>

<!-- footer -->
  <footer class="footer">
    <div class="footer__wave-container">
      <div class="footer__road"></div>
      <div class="footer__car">
        <svg class="footer__car-svg" viewBox="0 0 100 44" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="8" y="20" width="84" height="16" rx="3" fill="#3B82F6" opacity="0.9"/>
          <path d="M28 20 L36 8 L64 8 L72 20 Z" fill="#3B82F6" opacity="0.9"/>
          <path d="M30 20 L36 10 L52 10 L52 20 Z" fill="#0A0A0F" opacity="0.6"/>
          <path d="M54 20 L54 10 L64 10 L70 20 Z" fill="#0A0A0F" opacity="0.6"/>
          <circle cx="26" cy="36" r="7" fill="#1E293B" stroke="#3B82F6" stroke-width="1.5"/>
          <circle cx="26" cy="36" r="3" fill="#3B82F6" opacity="0.5"/>
          <circle cx="74" cy="36" r="7" fill="#1E293B" stroke="#3B82F6" stroke-width="1.5"/>
          <circle cx="74" cy="36" r="3" fill="#3B82F6" opacity="0.5"/>
          <rect x="88" y="22" width="6" height="5" rx="1" fill="#EAB308" opacity="0.9"/>
          <rect x="6"  y="22" width="4" height="5" rx="1" fill="#EF4444" opacity="0.9"/>
        </svg>
      </div>
    </div>
    <div class="footer__content">
      <div class="footer__logo">MIDNIGHT <span>MOTORS</span></div>
      <div class="footer__links">
        <a href="#" class="footer__link">About</a>
        <a href="#" class="footer__link">Contact</a>
        <a href="#" class="footer__link">Privacy</a>
      </div>
      <div class="footer__copy">&copy; 2025 Midnight Motors. All rights reserved.</div>
    </div>
  </footer>
  <script src="js/script.js"></script>

</body>
</html>