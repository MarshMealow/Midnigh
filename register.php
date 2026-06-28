<?php
session_start();
?>
<?php
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $full_name = $fname . " " . $lname;
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (empty($username) || empty($password) || empty($fname) || empty($lname) || empty($email) || empty($phone)) {
        $message = "Please fill in all fields.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO sellers (username, password, full_name, email, phone)
                VALUES ('$username', '$hashed_password', '$full_name', '$email', '$phone')";

        if (mysqli_query($conn, $sql)) {
            $message = "Seller registered successfully.";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Register page -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Midnight Motors — Register</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- main css file -->
  <link rel="stylesheet" href="css/style.css" />

  <!-- small css just for this page -->
  <style>
    /* Registration page: subtle side accent on the info card */
    .info-card {
      border-left: 3px solid rgba(59,130,246,0.4);
    }
    /* Already have account box */
    .already-box {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--radius-lg);
      padding: 18px 22px;
      text-align: center;
    }
    .already-box p {
      font-size: 0.85rem;
      color: var(--text-muted);
      margin-bottom: 12px;
    }
  </style>
</head>
<body>

  <!-- nav bar -->
  <!-- nav bar -->
<nav class="nav">
  <div class="nav__inner">
    <a href="index.php" class="nav__logo">MIDNIGHT <span>MOTORS</span></a>
    <ul class="nav__links">
      <li><a href="index.php" class="nav__link">Home</a></li>
      <li><a href="register.php" class="nav__link nav__link--active">Register</a></li>
      <?php if (isset($_SESSION['seller_id'])) { ?>
      <li><a href="logout.php" class="nav__link">Logout</a></li>
      <?php } else { ?>
      <li><a href="login.php" class="nav__link">Login</a></li>
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
    <li><a href="register.php" class="nav__link nav__link--active">Register</a></li>
    <?php if (isset($_SESSION['seller_id'])) { ?>
      <li><a href="logout.php" class="nav__link">Logout</a></li>
      <?php } else { ?>
      <li><a href="login.php" class="nav__link">Login</a></li>
      <?php } ?>
    <li><a href="cars.php" class="nav__link">Cars for Sale</a></li>
    <li><a href="search.php" class="nav__link">Search</a></li>
    <li><a href="feedback.php" class="nav__link">Feedback</a></li>
  </ul>
</nav>

  <main>

    <!-- page banner -->
    <div class="banner" style="height:140px; background: linear-gradient(135deg, #0D1A2D 0%, #0A0A0F 100%);">
      <div class="banner__overlay">
        <h2 class="banner__title">Seller Registration</h2>
      </div>
    </div>

    <div class="container">
      <div class="page-layout">

        <!-- feedback form side -->
        <div>
          <div class="page-header" style="margin-top: 32px; margin-bottom: 24px;">
            <div class="page-header__badge">Create your seller account</div>
            <h1 class="page-header__title">Join Midnight Motors</h1>
            <p class="page-header__sub">Fill in your details below to register as a seller and start listing cars.</p>
          </div>

          <!-- message area -->
          

          <!-- Registration form -->
           <?php if (!empty($message)) { ?>
            <p style="color: red; font-weight: bold;">
          <?php echo $message; ?>
            </p>
          <?php } ?>
          <form class="form" method="POST" action="register.php" novalidate>

            <div class="form__section">Personal details</div>

            <div class="form__row">
              <div class="form__group">
                <label class="form__label" for="fname">First name</label>
                <input class="form__input" type="text" id="fname" name="fname" placeholder="e.g. James" autocomplete="given-name" />
                <span class="form__hint" id="fname-hint" data-original="Letters and spaces only">Letters and spaces only</span>
              </div>
              <div class="form__group">
                <label class="form__label" for="lname">Last name</label>
                <input class="form__input" type="text" id="lname" name="lname" placeholder="e.g. Turner" autocomplete="family-name" />
                <span class="form__hint" id="lname-hint" data-original="Letters and spaces only">Letters and spaces only</span>
              </div>
            </div>

            <div class="form__group">
              <label class="form__label" for="address">Address</label>
              <input class="form__input" type="text" id="address" name="address" placeholder="e.g. 12 Queen St, Auckland" autocomplete="street-address" />
              <span class="form__hint" id="address-hint" data-original="Your NZ street address">Your NZ street address</span>
            </div>

            <div class="form__row">
              <div class="form__group">
                <label class="form__label" for="phone">Phone number</label>
                <input class="form__input" type="tel" id="phone" name="phone" placeholder="e.g. 021 345 6789" autocomplete="tel" />
                <span class="form__hint" id="phone-hint" data-original="NZ phone number">NZ phone number</span>
              </div>
              <div class="form__group">
                <label class="form__label" for="email">Email address</label>
                <input class="form__input" type="email" id="email" name="email" placeholder="e.g. you@email.com" autocomplete="email" />
                <span class="form__hint" id="email-hint" data-original="Must end in .com, .net or .my">Must end in .com, .net or .my</span>
              </div>
            </div>

            <div class="form__section">Account credentials</div>

            <div class="form__row">
              <div class="form__group">
                <label class="form__label" for="username">Username</label>
                <input class="form__input" type="text" id="username" name="username" placeholder="e.g. jturner99" autocomplete="username" />
                <span class="form__hint" id="uname-hint" data-original="Min 6 alphanumeric characters">Min 6 alphanumeric characters</span>
              </div>
              <div class="form__group">
                <label class="form__label" for="password">Password</label>
                <input class="form__input" type="password" id="password" name="password" placeholder="Min 6 characters" autocomplete="new-password" />
                <span class="form__hint" id="pass-hint" data-original="Min 6 alphanumeric characters">Min 6 alphanumeric characters</span>
              </div>
            </div>

            <div class="form__actions">
              <button type="submit" class="btn btn--primary">Create account</button>
              <button type="button" class="btn btn--secondary" id="register-clear">Clear form</button>
            </div>

          </form>
        </div>

        <!-- ── Right: Info ──────────────────────────────────── -->
        <div style="margin-top: 32px;">
          <div class="info-card">
            <div class="info-card__title">Why register with us?</div>
            <div class="info-card__item">
              <div class="info-card__num">1</div>
              <div class="info-card__text">List unlimited cars for free on the Midnight Motors platform</div>
            </div>
            <div class="info-card__item">
              <div class="info-card__num">2</div>
              <div class="info-card__text">Reach thousands of buyers across New Zealand</div>
            </div>
            <div class="info-card__item">
              <div class="info-card__num">3</div>
              <div class="info-card__text">Manage all your listings from one easy dashboard</div>
            </div>
            <div class="info-card__item">
              <div class="info-card__num">4</div>
              <div class="info-card__text">Collect buyer feedback to build your seller reputation</div>
            </div>
          </div>

          <div class="already-box">
            <p>Already have an account?</p>
            <a href="login.php" class="btn btn--outline btn--full">Sign in to your account</a>
          </div>
        </div>

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
