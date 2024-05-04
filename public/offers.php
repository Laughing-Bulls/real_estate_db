<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Manage Offers at NJIT Real Estate</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicon -->
  <link href="img/favicon.ico" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap"
        rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-xxl bg-white p-0">
  <!-- Spinner Start -->
  <div id="spinner"
       class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <!-- Spinner End -->


  <!-- Navbar Start -->
  <div class="container-fluid nav-bar bg-transparent">
    <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
      <a href="index.html" class="navbar-brand d-flex align-items-center text-center">
        <div class="icon p-2 me-2">
          <img class="img-fluid" src="img/icon-deal.png" alt="Icon" style="width: 30px; height: 30px;">
        </div>
        <h1 class="m-0 text-primary">NJIT Realty</h1>
      </a>
      <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto">
          <a href="index.html" class="nav-item nav-link active">Home</a>
          <a href="about.html" class="nav-item nav-link">About</a>
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Properties</a>
            <div class="dropdown-menu rounded-0 m-0">
              <a href="for_sale.html" class="dropdown-item">For Sale</a>
              <a href="for_rent.html" class="dropdown-item">For Rent</a>
            </div>
          </div>
          <!-- <a href="password.html" class="nav-item nav-link">Realtor Hub</a> -->
          <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Realtor Hub</a>
            <div class="dropdown-menu rounded-0 m-0">
              <a href="listings.html" class="dropdown-item">Manage Listings</a>
              <a href="viewings.html" class="dropdown-item">Manage Viewings</a>
              <a href="offers.php" class="dropdown-item">Manage Offers</a>
              <a href="transactions.html" class="dropdown-item">View Transactions</a>
            </div>
          </div>
          <a href="password2.html" class="nav-item nav-link">Realty Database</a>
        </div>
        <a href="offer.php" class="btn btn-primary px-3 d-none d-lg-flex">Make an Offer</a>
      </div>
    </nav>
  </div>
  <!-- Navbar End -->


  <!-- Make Offer Start -->
  <div class="container-xxl py-5">
    <div class="container">
      <div class="bg-light rounded p-3">
        <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
          <div class="row g-5 align-items-center">
            <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
              <img class="img-fluid rounded w-100" src="img/math.jpg" alt="">
            </div>
            <div class="col-lg-8 wow fadeIn" data-wow-delay="0.5s">
              <div class="mb-4">
                <h1 class="mb-3">Manage Offers on a Property</h1>
                <p>View current offers.
                  Accept or Decline offers on behalf of your customer.</p>
              </div>

              <?php
              ini_set('display_errors', 1);
              error_reporting(E_ALL);

              $host = 'sql1.njit.edu';
              $user = 'asd26';
              $password = '@Yl&K9Akh0';
              $dbname = 'asd26';

              // Create connection
              $conn = new mysqli($host, $user, $password, $dbname, 3306);

              // Check connection
              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $errorMessage = '';
              $displayResult = false;

              if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $searchKey = $_POST['searchKey'] ?? '';
                $searchValue = $_POST['searchValue'] ?? '';

                if ($searchKey && $searchValue) {
                  $query = "SELECT o.offer_id, o.MLS_id, o.offer_date, o.buyer_id, l.listing_price, o.offer_price, o.offer_status
                                FROM Offers o
                                JOIN Listings l ON o.MLS_id = l.MLS_id
                                WHERE o.$searchKey = ?";
                  $stmt = $conn->prepare($query);
                  if ($stmt) {
                    $stmt->bind_param("s", $searchValue);
                    $stmt->execute();
                    $stmt->bind_result($offer_id, $MLS_id, $offer_date, $buyer_id, $listing_price, $offer_price, $offer_status);
                    while ($stmt->fetch()) {
                      // echo "Offer ID: $offer_id, MLS#: $MLS_id, Offer Date: $offer_date, Customer ID: $buyer_id, Listing Price: $listing_price, Offer: $offer_price, Status: $offer_status<br/>";
                      echo "<strong>Offer ID:</strong> $offer_id, <strong>MLS#:</strong> $MLS_id, <strong>Offer Date:</strong> $offer_date, <strong>Customer ID:</strong> $buyer_id<br/>";
                      echo "<strong>Listing Price:</strong> $" . number_format($listing_price, 0) . ", <strong>Offer:</strong> $" . number_format($offer_price, 0) . "<br/>";
                      echo "<strong>Status:</strong> $offer_status<br/><br/>";
                    }
                    $stmt->close();
                  } else {
                    echo "Prepare error: " . $conn->error;
                  }
                }

                // PART 2 ACCEPT or DECLINE

                $offer_id = $_POST['offer_id'] ?? '';
                $action = $_POST['action'] ?? ''; // 'accept' or 'decline'

                if ($offer_id && $action) {
                  $conn->begin_transaction();
                  try {
                    if ($action == 'accept') {
                      $updateStatus = $conn->prepare("UPDATE Offers o1
                                                            JOIN Offers o2 ON o1.MLS_id = o2.MLS_id
                                                            SET o1.offer_status = CASE WHEN o1.offer_id = ? THEN 'accepted' ELSE 'declined' END
                                                            WHERE o2.offer_id = ?");


                      $updateStatus->bind_param("ii", $offer_id, $offer_id);
                      $updateStatus->execute();
                      $updateStatus->close();

                      $updateListing = $conn->prepare("UPDATE Listings SET listing_status = 'unavailable'
                                                             WHERE MLS_id IN
                                                                   (SELECT MLS_id FROM Offers WHERE offer_id = ?)");
                      $updateListing->bind_param("i", $offer_id);
                      $updateListing->execute();
                      $updateListing->close();

                      // Additional updates here for Transactions table
                    } else {
                      $updateStatus = $conn->prepare("UPDATE Offers SET offer_status = 'declined' WHERE offer_id = ?");
                      $updateStatus->bind_param("i", $offer_id);
                      $updateStatus->execute();
                      $updateStatus->close();
                    }
                    $displayResult = true;
                    $conn->commit();
                  } catch (Exception $e) {
                    $conn->rollback();
                    echo "Failed: " . $e->getMessage();
                  }
                }
              }
              $conn->close();
              ?>

              <div class="container">
                <?php if ($displayResult): ?>
                  <div class="container mt-4">
                    <div class='col-md-12'>
                      <h4 class='text-primary mb-2'>Action on Offer</h4>
                      <p><strong>Offer ID:</strong> <?php echo htmlspecialchars($offer_id); ?></p>
                      <p><strong>Status:</strong> <?php echo htmlspecialchars($action); ?></p>
                    </div>
                  </div>";
                <?php endif; ?>
              </div>
              <!-- Form for Viewing Offers -->
              <br><br>
              <h2>View Offers</h2>
              <?php if (!empty($errorMessage)) echo "<div class='alert alert-danger'>$errorMessage</div>"; ?>
              <form method="post" action="">
                <label for="searchKey">Search by:</label>
                <select name="searchKey" id="searchKey">
                  <option value="offer_id">Offer ID</option>
                  <option value="MLS_id">MLS#</option>
                  <option value="buyer_id">Customer ID</option>
                </select>
                <input type="text" name="searchValue" id="searchValue" required placeholder="Enter search value">
                <button type="submit">Search Offers</button>
              </form>
              <!-- Form for Accepting or Declining Offers -->
              <br><br>
              <h2>Accept or Decline Offers</h2>
              <form method="post" action="">
                <label for="action">Choose an action:</label>
                <select name="action" id="action">
                  <option value="accept">Accept</option>
                  <option value="decline">Decline</option>
                </select>
                <input type="text" name="offer_id" id="offer_id" required placeholder="Enter Offer ID">
                <button type="submit">Submit</button>
              </form>

            </div>
            <br><br>
            <a href="realtor_hub.html" class="btn btn-dark py-3 px-4"><i class="fa fa-dollar-alt me-2"></i>Back to
              Realtor Hub</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Make Offer End -->

<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="container py-5">
    <div class="row g-5">
      <div class="col-lg-3 col-md-6">
        <h5 class="text-white mb-4">Get In Touch</h5>
        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>154 Summit St, Newark, NJ</p>
        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>(123) 456 7890</p>
        <p class="mb-2"><i class="fa fa-envelope me-3"></i>CS631@NJITdatabase.com</p>
        <div class="d-flex pt-2">
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
          <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5 class="text-white mb-4">Quick Links</h5>
        <a class="btn btn-link text-white-50" href="about.html">About Us</a>
        <a class="btn btn-link text-white-50" href="">Contact Us</a>
        <a class="btn btn-link text-white-50" href="">Our Services</a>
        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5 class="text-white mb-4">Photo Gallery</h5>
        <div class="row g-2 pt-2">
          <div class="col-4">
            <img class="img-fluid rounded bg-light p-1" src="img/property-1.jpg" alt="">
          </div>
          <div class="col-4">
            <img class="img-fluid rounded bg-light p-1" src="img/property-2.jpg" alt="">
          </div>
          <div class="col-4">
            <img class="img-fluid rounded bg-light p-1" src="img/property-3.jpg" alt="">
          </div>
          <div class="col-4">
            <img class="img-fluid rounded bg-light p-1" src="img/property-4.jpg" alt="">
          </div>
          <div class="col-4">
            <img class="img-fluid rounded bg-light p-1" src="img/property-5.jpg" alt="">
          </div>
          <div class="col-4">
            <img class="img-fluid rounded bg-light p-1" src="img/property-6.jpg" alt="">
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5 class="text-white mb-4">Newsletter</h5>
        <p>Subscribe to our newsletter for exciting new property listings.</p>
        <div class="position-relative mx-auto" style="max-width: 400px;">
          <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
          <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="copyright">
      <div class="row">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
          &copy; <a class="border-bottom" href="index.html">NJIT Database Project</a>, NOT A REAL COMPANY!

          <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
          Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <div class="footer-menu">
            <a href="index.html">Home</a>
            <a href="">Cookies</a>
            <a href="">Help</a>
            <a href="">FAQs</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>

</html>
