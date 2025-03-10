<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petstore";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch all pets
    $stmt = $pdo->prepare("SELECT * FROM pets");
    $stmt->execute();
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fudge - Pet Adoption</title>
    
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Carter+One&family=Nunito+Sans:wght@400;700&display=swap" rel="stylesheet">

    <style>
        .header {
            background-color: var(--portland-orange) !important;
            position: fixed;
        }

        .header.active {
            background-color: var(--portland-orange) !important;
        }

        .navbar-link {
            color: var(--white) !important;
        }

        .navbar-link:hover {
            color: var(--eerie-black-1) !important;
        }

        .logo {
            color: var(--white) !important;
        }

        .action-btn {
            color: var(--white) !important;
        }

        .action-btn:hover {
            color: var(--eerie-black-1) !important;
        }

        .navbar-action-btn {
            color: var(--white) !important;
            border: 1px solid var(--white) !important;
        }

        .navbar-action-btn:hover {
            background-color: var(--white) !important;
            color: var(--portland-orange) !important;
        }

        .adoption-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
            padding: 0 20px;
        }

        .pet-card {
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .pet-card:hover {
            transform: translateY(-5px);
        }

        .pet-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            aspect-ratio: 1 / 1;
        }

        .pet-info {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .pet-name {
            font-size: 1.5rem;
            color: var(--eerie-black-1);
            margin-bottom: 10px;
            font-family: "Carter One", cursive;
        }

        .pet-details {
            font-size: 0.9rem;
            color: var(--sonic-silver);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .adopt-btn {
            background: var(--portland-orange);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
            font-family: "Nunito Sans", sans-serif;
            font-weight: bold;
            margin-top: auto;
        }

        .adopt-btn:hover {
            background: var(--orange-web);
        }

        .adoption-hero {
            background-color: var(--portland-orange);
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }

        .adoption-hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-family: "Carter One", cursive;
        }

        .adoption-hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
    </style>
</head>
<body id="top">

    <!-- Header -->
    <header class="header" data-header>
        <div class="container">
            <button class="nav-toggle-btn" aria-label="toggle menu" data-nav-toggler>
                <ion-icon name="menu-outline" aria-hidden="true" class="menu-icon"></ion-icon>
                <ion-icon name="close-outline" aria-label="true" class="close-icon"></ion-icon>
            </button>

            <a href="index.html" class="logo">Fudge</a>

            <nav class="navbar" data-navbar>
                <ul class="navbar-list">
                    <li class="navbar-item">
                        <a href="index.html" class="navbar-link" data-nav-link>Home</a>
                    </li>

                    <li class="navbar-item">
                        <a href="product-listing.html" class="navbar-link" data-nav-link>Shop</a>
                    </li>

                    <li class="navbar-item">
                        <a href="adopt.php" class="navbar-link" data-nav-link>Adopt me</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#" class="navbar-link" data-nav-link>Blogs</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#contact" class="navbar-link" data-nav-link>Contact</a>
                    </li>
                </ul>

                <a href="login.php" class="navbar-action-btn">Log In</a>
            </nav>

            <div class="header-actions">
                <button class="action-btn" aria-label="Search">
                    <ion-icon name="search-outline" aria-hidden="true"></ion-icon>
                </button>

                <button onclick="location.href='login.php';" class="action-btn user" aria-label="User">
                    <ion-icon name="person-outline" aria-hidden="true"></ion-icon>
                </button>

                <button class="action-btn" aria-label="cart">
                    <ion-icon name="bag-handle-outline" aria-hidden="true"></ion-icon>
                    <span class="btn-badge">0</span>
                </button>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="adoption-hero">
            <div class="container">
                <h1>Find Your Perfect Companion</h1>
                <p>Give a loving home to our adorable pets and make a difference in their lives.</p>
            </div>
        </section>

        <!-- Adoption Section -->
        <section class="section" aria-label="adoption">
            <div class="container">
                <h2 class="h2 section-title">
                    <span class="span">Available</span> Pets
                </h2>

                <div class="adoption-grid">
                    <?php foreach ($pets as $pet): ?>
                        <?php
                            $imageData = base64_encode($pet['Image']);
                            $src = "data:image/jpeg;base64," . $imageData;
                        ?>
                        <div class="pet-card">
                            <img src="<?php echo $src; ?>" alt="<?php echo htmlspecialchars($pet['Breed']); ?>" class="pet-image">
                            <div class="pet-info">
                                <h3 class="pet-name"><?php echo htmlspecialchars($pet['Breed']); ?></h3>
                                <p class="pet-details">
                                    <?php echo htmlspecialchars($pet['Pet_Type']); ?>
                                </p>
                                <a href="adopt-form.php?id=<?php echo $pet['Pet_id']; ?>" class="adopt-btn">Adopt Me</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer" style="background-image: url('./assets/images/footer-bg.jpg')">
        <div class="footer-top section">
            <div class="container">
                <div class="footer-brand">
                    <a href="#" class="logo">Fudge</a>

                    <p class="footer-text">
                        If you have any question, please contact us at
                        <a href="mailto:support@gmail.com" class="link">fudgesupport@gmail.com</a>
                    </p>

                    <ul class="contact-list">
                        <li class="contact-item">
                            <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
                            <address class="address">Pcce Goa</address>
                        </li>

                        <li class="contact-item">
                            <ion-icon name="call-outline" aria-hidden="true"></ion-icon>
                            <a href="tel:+919999999999" class="contact-link" id="contact">+91 999999999</a>
                        </li>
                    </ul>

                    <ul class="social-list">
                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-facebook"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-twitter"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-pinterest"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-instagram"></ion-icon>
                            </a>
                        </li>
                    </ul>
                </div>

                <img src="./assets/images/payment.png" width="397" height="32" loading="lazy" alt="payment method" class="img">
            </div>
        </div>
    </footer>

    <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
        <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
    </a>

    <!-- Scripts -->
    <script src="./assets/js/script.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html> 