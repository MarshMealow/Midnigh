<?php
session_start();
include 'db.php';

if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $seller_id = $_SESSION['seller_id'];

    $make = $_POST['car-make'];
    $model = $_POST['car-model'];
    $year = $_POST['car-year'];
    $colour = $_POST['car-colour'];
    $location = $_POST['car-location'];
    $body = $_POST['car-body'];
    $mileage = $_POST['car-mileage'];
    $price = $_POST['car-price'];

    $full_model = $make . " " . $model;
    $description = "Location: " . $location . ", Body type: " . $body . ", Mileage: " . $mileage . " km";
    $image = "";

    if (
        empty($make) || empty($model) || empty($year) || empty($colour) ||
        empty($location) || empty($body) || empty($mileage) || empty($price)
    ) {
        $message = "Please fill in all required fields.";
    } else {
        $sql = "INSERT INTO cars
                (seller_id, model, year, price, colour, description, image)
                VALUES
                ('$seller_id', '$full_model', '$year', '$price', '$colour', '$description', '$image')";

        if (mysqli_query($conn, $sql)) {
            $message = "Car added successfully.";
        } else {
            $message = "Database Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Cars page -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Midnight Motors — Cars for Sale</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- main css file -->
  <link rel="stylesheet" href="css/style.css" />

  <!-- small css just for this page -->
  <style>
    /* image upload hover effect */
    .form__upload:hover {
      border-color: var(--accent);
      background: rgba(59,130,246,0.04);
    }
    /* small delete button */
    .btn--remove {
      background: transparent;
      color: var(--text-muted);
      border-color: var(--border);
      font-size: 0.75rem;
      padding: 4px 10px;
    }
    .btn--remove:hover {
      color: var(--danger);
      border-color: var(--danger);
      background: rgba(239,68,68,0.06);
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
      <li><a href="register.php" class="nav__link">Register</a></li>
      <?php if (isset($_SESSION['seller_id'])) { ?>
      <li><a href="logout.php" class="nav__link">Logout</a></li>
      <?php } else { ?>
      <li><a href="login.php" class="nav__link">Login</a></li>
      <?php } ?>
      <li><a href="cars.php" class="nav__link nav__link--active">Cars for Sale</a></li>
      <li><a href="search.php" class="nav__link">Search</a></li>
      <li><a href="feedback.php" class="nav__link">Feedback</a></li>
    </ul>

    <button class="nav__hamburger" id="hamburger" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>
  </div>

  <ul class="nav__mobile" id="mobile-menu">
    <li><a href="index.php" class="nav__link">Home</a></li>
    <li><a href="register.php" class="nav__link">Register</a></li>
    <?php if (isset($_SESSION['seller_id'])) { ?>
      <li><a href="logout.php" class="nav__link">Logout</a></li>
      <?php } else { ?>
      <li><a href="login.php" class="nav__link">Login</a></li>
      <?php } ?>
    <li><a href="cars.php" class="nav__link nav__link--active">Cars for Sale</a></li>
    <li><a href="search.php" class="nav__link">Search</a></li>
    <li><a href="feedback.php" class="nav__link">Feedback</a></li>
  </ul>
</nav>

  <main>

    <!-- page banner -->
    <div class="banner" style="height:140px; background: linear-gradient(135deg, #060D1A 0%, #0A0A0F 100%);">
      <div class="banner__overlay">
        <h2 class="banner__title">Cars for Sale</h2>
      </div>
    </div>

    <div class="container">
      <div class="page-layout">

        <!-- add car form -->
        <div style="margin-top: 32px;">
          <div class="page-header" style="margin-bottom: 24px;">
            <div class="page-header__badge">List your car</div>
            <h1 class="page-header__title">Add a listing</h1>
            <p class="page-header__sub">Fill in the details below to list your car on Midnight Motors.</p>
          </div>

          <!-- message area -->
          <?php if (!empty($message)) { ?>
          <div class="notification notification--show notification--success">
          <?php echo $message; ?>
            </div>
          <?php } ?>

          <form class="form" method="POST" action="cars.php" novalidate>

            <div class="form__section">Car details</div>

            <div class="form__row">
              <div class="form__group">
                <label class="form__label" for="car-make">Company name</label>
                <input class="form__input" type="text" id="car-make" name="car-make" placeholder="e.g. Toyota" />
                <span class="form__hint" id="make-hint" data-original="Letters and spaces only">Letters and spaces only</span>
              </div>
              <div class="form__group">
                <label class="form__label" for="car-model">Model</label>
                <input class="form__input" type="text" id="car-model" name="car-model" placeholder="e.g. Camry" />
                <span class="form__hint" id="model-hint" data-original="Alphanumeric only">Alphanumeric only</span>
              </div>
            </div>

            <div class="form__row">
              <div class="form__group">
                <label class="form__label" for="car-year">Year</label>
                <select class="form__select" id="car-year" name="car-year">
                  <option value="">Select year</option>
                  <option>2024</option><option>2023</option><option>2022</option>
                  <option>2021</option><option>2020</option><option>2019</option>
                  <option>2018</option><option>2017</option><option>2016</option>
                  <option>2015</option><option>2014</option><option>2013</option>
                </select>
                <span class="form__hint" id="year-hint" data-original="Manufacturing year">Manufacturing year</span>
              </div>
              <div class="form__group">
                <label class="form__label" for="car-colour">Colour</label>
                <input class="form__input" type="text" id="car-colour" name="car-colour" placeholder="e.g. Midnight Black" />
                <span class="form__hint" id="colour-hint" data-original="Car colour">Car colour</span>
              </div>
            </div>

            <div class="form__row">
              <div class="form__group">
                <label class="form__label" for="car-location">Location</label>
                <input class="form__input" type="text" id="car-location" name="car-location" placeholder="e.g. Auckland" />
                <span class="form__hint" id="location-hint" data-original="Letters and spaces only">Letters and spaces only</span>
              </div>
              <div class="form__group">
                <label class="form__label" for="car-body">Body type</label>
                <input class="form__input" type="text" id="car-body" name="car-body" placeholder="e.g. Sedan" />
                <span class="form__hint" id="body-hint" data-original="Letters only">Letters only</span>
              </div>
            </div>

            <div class="form__row">
              <div class="form__group">
                <label class="form__label" for="car-mileage">Mileage (km)</label>
                <input class="form__input" type="text" id="car-mileage" name="car-mileage" placeholder="e.g. 45000" />
                <span class="form__hint" id="mileage-hint" data-original="Numbers only">Numbers only</span>
              </div>
              <div class="form__group">
                <label class="form__label" for="car-price">Price ($NZD)</label>
                <input class="form__input" type="text" id="car-price" name="car-price" placeholder="e.g. 18500" />
                <span class="form__hint" id="price-hint" data-original="Numbers only">Numbers only</span>
              </div>
            </div>

            <div class="form__section">Car image</div>

            <div class="form__group">
              <div class="form__upload">
                <div class="form__upload-icon">&#8679;</div>
                <span>Click to upload car photo</span>
                <span style="font-size:0.75rem; color: var(--text-muted);">JPG or PNG &middot; Max 5MB</span>
              </div>
            </div>

            <div class="form__actions">
              <button type="submit" class="btn btn--primary">Add listing</button>
              <button type="button" class="btn btn--secondary" id="cars-clear">Clear</button>
            </div>

          </form>
        </div>

        <!-- current listings -->
        <div style="margin-top: 32px;">
          <div class="listings">
            <div class="listings__header">
              <span class="listings__title">Current listings</span>
              <?php
                $seller_id = $_SESSION['seller_id'];
                $count_sql = "SELECT * FROM cars WHERE seller_id='$seller_id'";
                $count_result = mysqli_query($conn, $count_sql);
                $count = mysqli_num_rows($count_result);
                ?>

                <span class="listings__count" id="cars-listings-count">
                  <?php echo $count; ?> cars listed
                </span>
            </div>

            <!-- filter buttons for listings -->
            <div class="filters" style="margin-bottom: 12px;">
              <button class="filters__chip filters__chip--active" data-cars-filter="all">All</button>
              <button class="filters__chip" data-cars-filter="sedan">Sedan</button>
              <button class="filters__chip" data-cars-filter="hatchback">Hatchback</button>
              <button class="filters__chip" data-cars-filter="suv">SUV</button>
              <button class="filters__chip" data-cars-filter="ute">Ute</button>
              <button class="filters__chip" data-cars-filter="wagon">Wagon</button>
              <button class="filters__chip" data-cars-filter="under15000">Under $15k</button>
              <button class="filters__chip" data-cars-filter="under25000">Under $25k</button>
            </div>

            <!-- sort buttons -->
            <div class="sort">
              <button class="sort__chip sort__chip--active" data-cars-sort="newest">Newest</button>
              <button class="sort__chip" data-cars-sort="price-asc">Price &#8593;</button>
              <button class="sort__chip" data-cars-sort="price-desc">Price &#8595;</button>
              <button class="sort__chip" data-cars-sort="km-asc">Mileage &#8593;</button>
            </div>

            <?php
            $seller_id = $_SESSION['seller_id'];
            $sql = "SELECT * FROM cars WHERE seller_id='$seller_id'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
            ?>

            <?php while ($car = mysqli_fetch_assoc($result)) { ?>
              <div class="listing cars-listing">
                <div class="listing__img">
                  <span class="listing__badge card__badge--new">New</span>
                </div>

                <div class="listing__body">
                  <div class="listing__top">
                    <span class="listing__make">
                      <?php echo $car['model']; ?> <?php echo $car['year']; ?>
                    </span>
                    <span class="listing__price">
                      $<?php echo number_format($car['price']); ?>
                    </span>
                  </div>

                  <div class="listing__detail">
                    <?php echo $car['description']; ?> &middot; <?php echo $car['colour']; ?>
                  </div>

                  <div class="listing__footer">
                    <span class="listing__seller">&#9733; 4.5 seller rating</span>
                    <div class="listing__actions">
                      <button class="btn btn--secondary" style="font-size:0.75rem;padding:4px 12px;">View</button>

                      <a href="delete_car.php?id=<?php echo $car['car_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this car?');"
                        class="btn btn--remove">
                        Remove
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>

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
</body>
</html>
