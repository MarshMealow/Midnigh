<?php
session_start();
include 'db.php';

$latest_sql = "SELECT * FROM cars ORDER BY car_id DESC LIMIT 5";
$latest_result = mysqli_query($conn, $latest_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Index page -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Midnight Motors — Home</title>

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- main css file -->
  <link rel="stylesheet" href="css/style.css" />

  <!-- small css just for this page -->
  <style>
    /* small glow on first banner */
    .hero__slide--1::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: radial-gradient(ellipse at 30% 50%, rgba(59,130,246,0.08) 0%, transparent 70%);
      pointer-events: none;
    }
    /* glow for second banner */
    .hero__slide--2::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: radial-gradient(ellipse at 70% 50%, rgba(99,102,241,0.08) 0%, transparent 70%);
      pointer-events: none;
    }
    /* light dot pattern on banner */
    .hero::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 28px 28px;
      pointer-events: none;
      z-index: 1;
    }
    .hero__content { position: relative; z-index: 2; }
  </style>
</head>
<body>

  <!-- nav bar -->
  <!-- nav bar -->
<nav class="nav">
  <div class="nav__inner">
    <a href="index.php" class="nav__logo">MIDNIGHT <span>MOTORS</span></a>
    <ul class="nav__links">
      <li><a href="index.php" class="nav__link nav__link--active">Home</a></li>
      <li><a href="register.php" class="nav__link ">Register</a></li>
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
    <li><a href="index.php" class="nav__link nav__link--active">Home</a></li>
    <li><a href="register.php" class="nav__link ">Register</a></li>
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

    <!-- home banner slider -->
    <section class="hero">

      <!-- first banner -->
      <div class="hero__slide hero__slide--1" id="slide-1">
        <div class="hero__content">
          <div class="hero__badge">New Zealand&rsquo;s midnight car marketplace</div>
          <h1 class="hero__title">Find your next <span>ride.</span></h1>
          <p class="hero__sub">Browse hundreds of listings from trusted sellers across New Zealand.</p>
          <div class="hero__actions">
            <a href="search.php" class="btn btn--primary">Browse cars</a>
            <a href="register.php" class="btn btn--outline">Sell your car</a>
          </div>
        </div>
      </div>

      <!-- second banner, also has a small inline css example -->
      <div class="hero__slide hero__slide--2" id="slide-2" style="background-color:#060D1A;">
        <div class="hero__content">
          <div class="hero__badge">Trusted sellers across NZ</div>
          <h1 class="hero__title">Premium cars. <span>Real deals.</span></h1>
          <p class="hero__sub">Verified sellers, honest listings, and a community built on trust.</p>
          <div class="hero__actions">
            <a href="cars.php" class="btn btn--primary">View listings</a>
            <a href="feedback.php" class="btn btn--outline">Read reviews</a>
          </div>
        </div>
      </div>

      <!-- banner arrows -->
      <button class="hero__arrow hero__arrow--left"  id="arrow-left">&#8249;</button>
      <button class="hero__arrow hero__arrow--right" id="arrow-right">&#8250;</button>

      <!-- banner dots -->
      <div class="hero__dots">
        <button class="hero__dot" data-index="0" aria-label="Slide 1"></button>
        <button class="hero__dot" data-index="1" aria-label="Slide 2"></button>
      </div>

    </section>

    <!-- home search and filter buttons -->
    <section class="section" style="padding-bottom: 0;">
      <div class="container">
        <form class="search-bar" method="GET" action="search.php">
          <span class="search-bar__icon">&#128269;</span>
          <input class="search-bar__input" id="home-search-input" name="s-make" type="text" placeholder="Search by make or model..." />
          <button class="search-bar__btn" type="submit" name="search">Search</button>
        </form>
        <div class="filters">
          <a class="filters__chip filters__chip--active" href="search.php">All</a>
          <a class="filters__chip" href="search.php?search=1&s-type=Sedan">Sedan</a>
          <a class="filters__chip" href="search.php?search=1&s-type=SUV">SUV</a>
          <a class="filters__chip" href="search.php?search=1&s-type=Ute">Ute</a>
          <a class="filters__chip" href="search.php?search=1&s-type=Hatchback">Hatchback</a>
          <a class="filters__chip" href="search.php?search=1&s-max=15000">Under $15k</a>
          <a class="filters__chip" href="search.php?search=1&s-max=25000">Under $25k</a>
        </div>
      </div>
    </section>

    <!-- car cards -->
    <section class="section">
      <div class="container">
        <div class="section__header">
          <span class="section__title">Latest listings</span>
          <a href="cars.php" class="section__link">View all &rarr;</a>
        </div>
        <div class="cards-grid">

              <?php while ($car = mysqli_fetch_assoc($latest_result)) { ?>
                <div class="card">
                  <div class="card__image">
                    <span class="card__badge card__badge--new">New</span>
                  </div>

                  <div class="card__body">
                    <div class="card__make">
                      <?php echo $car['model']; ?>
                    </div>

                    <div class="card__price">
                      $<?php echo number_format($car['price']); ?>
                    </div>

                    <div class="card__detail">
                      <?php echo $car['year']; ?> &middot;
                      <?php echo $car['description']; ?> &middot;
                      <?php echo $car['colour']; ?>
                    </div>

                    <div class="card__footer">
                      <span class="card__seller">Seller listing</span>
                      <a class="card__btn" href="feedback.php?car_id=<?php echo $car['car_id']; ?>">View</a>
                    </div>
                  </div>
                </div>
              <?php } ?>

            </div>

        <!-- quick stats -->
        <div class="section__header" style="margin-top: 16px;">
          <span class="section__title">By the numbers</span>
        </div>
        <div class="stats">
          <div class="stats__item">
            <div class="stats__number">124</div>
            <div class="stats__label">Active listings</div>
          </div>
          <div class="stats__item">
            <div class="stats__number">58</div>
            <div class="stats__label">Registered sellers</div>
          </div>
          <div class="stats__item">
            <div class="stats__number">4.8&#9733;</div>
            <div class="stats__label">Average seller rating</div>
          </div>
        </div>

      </div>
    </section>

  </main>

  <!-- footer with little road animation -->
  <footer class="footer">
    <!-- moving car part -->
    <div class="footer__wave-container">
      <div class="footer__road"></div>
      <!-- svg car shape -->
      <div class="footer__car">
        <svg class="footer__car-svg" viewBox="0 0 100 44" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- body -->
          <rect x="8" y="20" width="84" height="16" rx="3" fill="#3B82F6" opacity="0.9"/>
          <!-- roof -->
          <path d="M28 20 L36 8 L64 8 L72 20 Z" fill="#3B82F6" opacity="0.9"/>
          <!-- windows -->
          <path d="M30 20 L36 10 L52 10 L52 20 Z" fill="#0A0A0F" opacity="0.6"/>
          <path d="M54 20 L54 10 L64 10 L70 20 Z" fill="#0A0A0F" opacity="0.6"/>
          <!-- wheels -->
          <circle cx="26" cy="36" r="7" fill="#1E293B" stroke="#3B82F6" stroke-width="1.5"/>
          <circle cx="26" cy="36" r="3" fill="#3B82F6" opacity="0.5"/>
          <circle cx="74" cy="36" r="7" fill="#1E293B" stroke="#3B82F6" stroke-width="1.5"/>
          <circle cx="74" cy="36" r="3" fill="#3B82F6" opacity="0.5"/>
          <!-- lights -->
          <rect x="88" y="22" width="6" height="5" rx="1" fill="#EAB308" opacity="0.9"/>
          <!-- back lights -->
          <rect x="6"  y="22" width="4" height="5" rx="1" fill="#EF4444" opacity="0.9"/>
        </svg>
      </div>
    </div>

    <!-- footer text -->
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

  <!-- javascript file -->
  <script src="js/script.js"></script>

</body>
</html>
