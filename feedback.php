<?php
session_start();
include 'db.php';

$message = "";
$car_id = $_GET['car_id'] ?? 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST['car_id'];
    $name = $_POST['fb-name'];
    $email = $_POST['fb-email'];
    $rating = $_POST['rating'];
    $comments = $_POST['fb-comments'];

    if (empty($car_id) || empty($name) || empty($email) || empty($rating) || empty($comments)) {
        $message = "Please fill in all required fields.";
    } else {
        $sql = "INSERT INTO feedback (car_id, name, email, message, rating)
                VALUES ('$car_id', '$name', '$email', '$comments', '$rating')";

        if (mysqli_query($conn, $sql)) {
            $message = "Feedback submitted successfully.";
        } else {
            $message = "Database Error: " . mysqli_error($conn);
        }
    }
}

$selected_car_sql = "SELECT * FROM cars WHERE car_id='$car_id'";
$selected_car_result = mysqli_query($conn, $selected_car_sql);
$selected_car = mysqli_fetch_assoc($selected_car_result);

$avg_sql = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM feedback WHERE car_id='$car_id'";
$avg_result = mysqli_query($conn, $avg_sql);
$avg_data = mysqli_fetch_assoc($avg_result);

$avg_rating = $avg_data['avg_rating'] ? round($avg_data['avg_rating'], 1) : 0;
$total_reviews = $avg_data['total_reviews'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Feedback page -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Midnight Motors — Feedback</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- main css file -->
  <link rel="stylesheet" href="css/style.css" />

  <!-- small css just for this page -->
  <style>
    /* stars get bigger on hover */
    .stars__btn:hover {
      background: rgba(59,130,246,0.15);
      border-color: rgba(59,130,246,0.5);
      color: var(--accent-light);
      transform: scale(1.1);
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
      <li><a href="register.php" class="nav__link ">Register</a></li>
      <?php if (isset($_SESSION['seller_id'])) { ?>
      <li><a href="logout.php" class="nav__link">Logout</a></li>
      <?php } else { ?>
      <li><a href="login.php" class="nav__link">Login</a></li>
      <?php } ?>
      <li><a href="cars.php" class="nav__link">Cars for Sale</a></li>
      <li><a href="search.php" class="nav__link">Search</a></li>
      <li><a href="feedback.php" class="nav__link nav__link--active">Feedback</a></li>
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
      <li><a href="login.php" class="nav__link">Login</a></li>
      <?php } ?>
    <li><a href="cars.php" class="nav__link">Cars for Sale</a></li>
    <li><a href="search.php" class="nav__link">Search</a></li>
    <li><a href="feedback.php" class="nav__link nav__link--active">Feedback</a></li>
  </ul>
</nav>

  <main>
    <!-- page banner -->
    <div class="banner" style="height:140px; background: linear-gradient(135deg, #0A1628 0%, #0A0A0F 100%);">
      <div class="banner__overlay">
        <h2 class="banner__title">Feedback</h2>
      </div>
    </div>

    <div class="container">
      <div class="page-layout">

        <!-- feedback form side -->
        <div style="margin-top: 32px;">
          <div class="page-header" style="margin-bottom: 24px;">
            <div class="page-header__badge">Share your experience</div>
            <h1 class="page-header__title">Leave feedback</h1>
            <p class="page-header__sub">Share your experience with a car or seller on Midnight Motors.</p>
          </div>

          <!-- car name field -->
          <div class="car-ref">
            <div class="car-ref__img"></div>
            <div>
              <div class="car-ref__make">
                <?php echo $selected_car ? $selected_car['model'] . " " . $selected_car['year'] : "Select a car"; ?>
              </div>
              <div class="car-ref__price">
                <?php echo $selected_car ? "$" . number_format($selected_car['price']) : ""; ?>
              </div>
              <div class="car-ref__detail">
                <?php echo $selected_car ? $selected_car['description'] . " · " . $selected_car['colour'] : ""; ?>
              </div>
            </div>
          </div>

          <!-- message area -->
          <?php if (!empty($message)) { ?>
            <p style="color: <?php echo ($message == 'Feedback submitted successfully.') ? 'green' : 'red'; ?>; font-weight:bold;">
              <?php echo $message; ?>
            </p>
          <?php } ?>

          <form class="form" method="POST" action="feedback.php" novalidate>
            <div class="form__section">Car details</div>

            <div class="form__group">
              <select class="form__select" id="fb-car" name="car_id" onchange="window.location.href='feedback.php?car_id=' + this.value;">
                <?php
                $car_query = "SELECT car_id, model, year, price FROM cars";
                $car_result = mysqli_query($conn, $car_query);

                while ($car = mysqli_fetch_assoc($car_result)) {
                    $selected = ($car_id == $car['car_id']) ? "selected" : "";
                    echo "<option value='" . $car['car_id'] . "' $selected>" .
                        $car['model'] . " " . $car['year'] . " - $" . number_format($car['price']) .
                        "</option>";
                }
                ?>
              </select>
            </div>

            <div class="form__section">Your details</div>

            <div class="form__row">
              <div class="form__group">
                <label class="form__label" for="fb-name">Full name</label>
                <input class="form__input" type="text" id="fb-name" name="fb-name" placeholder="e.g. Sarah Mitchell" />
                <span class="form__hint" id="fbname-hint" data-original="Letters and spaces only">Letters and spaces only</span>
              </div>
              <div class="form__group">
                <label class="form__label" for="fb-email">Email address</label>
                <input class="form__input" type="email" id="fb-email" name="fb-email" placeholder="e.g. you@email.com" />
                <span class="form__hint" id="fbemail-hint" data-original="Must end in .com, .net or .my">Must end in .com, .net or .my</span>
              </div>
            </div>

            <div class="form__group">
              <label class="form__label" for="fb-date">Date</label>
              <input class="form__input" type="text" id="fb-date" name="fb-date" readonly style="color: var(--text-muted); cursor: default;" />
              <span class="form__hint">Auto-filled with today&rsquo;s date</span>
            </div>

            <div class="form__section">Your feedback</div>

            <div class="form__group">
              <label class="form__label">Rating</label>
              <input type="hidden" name="rating" id="rating" value="">
              <div class="stars">
                <button type="button" class="stars__btn" data-value="1">&#9733;</button>
                <button type="button" class="stars__btn" data-value="2">&#9733;</button>
                <button type="button" class="stars__btn" data-value="3">&#9733;</button>
                <button type="button" class="stars__btn" data-value="4">&#9733;</button>
                <button type="button" class="stars__btn" data-value="5">&#9733;</button>
              </div>
            </div>

            <div class="form__group">
              <label class="form__label" for="fb-comments">Comments</label>
              <textarea class="form__textarea" id="fb-comments" name="fb-comments" placeholder="Write your feedback about this car or seller..."></textarea>
              <span class="form__hint" id="comments-hint" data-original="Min. 10 characters">Min. 10 characters</span>
            </div>

            <div class="form__actions">
              <button type="submit" class="btn btn--primary">Submit feedback</button>
              <button type="button" class="btn btn--secondary" id="feedback-clear">Clear</button>
            </div>

          </form>
        </div>

        <!-- reviews side -->
        <div style="margin-top: 32px;">
          <div style="margin-bottom: 20px;">
            <span class="section__title">Recent feedback</span>
          </div>

          <!-- average rating -->
          <div class="avg-rating">
            <div class="avg-rating__num"><?php echo $avg_rating; ?></div>
            <div>
              <div class="avg-rating__stars">
              <?php if ($total_reviews > 0) { ?>
                <?php for ($i = 1; $i <= round($avg_rating); $i++) { ?>
                  <span style="color:var(--accent);font-size:1.1rem;">&#9733;</span>
                <?php } ?>
              <?php } else { ?>
                <span style="color:var(--muted);font-size:0.9rem;">No ratings yet</span>
              <?php } ?>
            </div>
              <div class="avg-rating__label">Based on <?php echo $total_reviews; ?> reviews</div>
            </div>
          </div>

          <?php
            $review_sql = "SELECT * FROM feedback WHERE car_id='$car_id' ORDER BY feedback_id DESC";
            $review_result = mysqli_query($conn, $review_sql);

            while ($review = mysqli_fetch_assoc($review_result)) {
            ?>
              <div class="review">
                <div class="review__top">
                  <span class="review__name"><?php echo $review['name']; ?></span>
                  <span class="review__date"><?php echo date("j M Y", strtotime($review['created_at'])); ?></span>
                </div>

                <div class="review__text"><?php echo $review['message']; ?></div>

                <div class="review__car">
                  Re: <?php echo $selected_car['model'] . " " . $selected_car['year']; ?>
                </div>
              </div>
            <?php } ?>
        </div>
      </div>
    </div>
  </main>

  <!-- footer -->
  <footer class="footer">
    <div class="footer__wave-container">
      <div class="footer__road"></div>
      <div class="footer__car">
        <svg class="footer__car-svg" viewBox="0 0 100 44" fill="none">
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
<script>
document.querySelectorAll('.stars__btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    document.getElementById('rating').value = this.dataset.value;
  });
});
</script>

</body>
</html>
