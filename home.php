<?php
session_start();
$is_logged_in = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petspal Connect - Home</title>
    <link rel="stylesheet" href="home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <style>
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 250px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 1rem;
            z-index: 1000;
        }

        .profile-dropdown:hover .profile-menu {
            display: block;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            background: #8C1AF6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            text-transform: uppercase;
        }

        .profile-info h3 {
            margin: 0;
            font-size: 1rem;
        }

        .profile-info p {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
        }

        .profile-section {
            margin-top: 1rem;
        }

        .profile-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .profile-menu ul li a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .message-badge {
            background: #4CAF50;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
        }

        .logout-btn {
            display: block;
            text-align: center;
            padding: 0.5rem;
            margin-top: 1rem;
            color: #ff4444;
            text-decoration: none;
            border-top: 1px solid #eee;
        }

        /* Popup Styles */
        /* Popup Styles */
.popup {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

.popup-content {
    background-color: blueviolet;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 40px; /* Increased padding for a larger popup */
    border: 2px solid #888;
    border-radius: 20px; /* Rounded borders */
    width: 60%; /* Increased width for a larger popup */
    text-align: center;
    color: white; /* Make text color white for better visibility */
    font-size: 1.5rem; /* Increased font size */
}

.close {
    color: white;
    float: right;
    font-size: 30px; /* Increased close button font size */
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">Petspal<span>Connect</span></div>
            <nav>
                <ul class="nav-links">
                    <li><a href="home.php">Home</a></li>
                    <li class="dropdown">
                        <a href="findapet.php" class="dropbtn">Adopt a Pet </a>
                    </li>
                    <li><a href="#" onclick="checkLogin(event)">List a Pet</a></li>
                    <li><a href="#">About Us</a></li>
                    <?php if ($is_logged_in): 
                        $first_letter = strtoupper(substr($_SESSION['user'], 0, 1));
                    ?>
                        <li class="profile-dropdown">
                            <a href="#" class="profile-trigger">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></a>
                            <div class="profile-menu">
                                <div class="profile-header">
                                    <div class="profile-avatar"><?php echo $first_letter; ?></div>
                                    <div class="profile-info">
                                        <h3><?php echo htmlspecialchars($_SESSION['user']); ?></h3>
                                        <p><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></p>
                                    </div>
                                </div>
                                
                                <div class="profile-section">
                                    <ul>
                                        <li>
                                            <a href="messages.html">
                                                My Messaging
                                                <?php if (isset($_SESSION['unread_messages']) && $_SESSION['unread_messages'] > 0): ?>
                                                    <span class="message-badge"><?php echo $_SESSION['unread_messages']; ?></span>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                        <li><a href="profile.php">My Profile</a></li>
                                        <li><a href="favorites.php">Favourites</a></li>
                                        <li><a href="preferences.php">Preferences</a></li>
                                    </ul>
                                </div>
                                
                                <a href="logout.php" class="logout-btn">Log out</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="userregistration.php">Login/Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Popup HTML -->
    <div id="login-popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <p>You haven't logged in. Please log in.</p>
        </div>
    </div>

    <main>
        <div class="content">
            <h1>Welcome to Petspal <span>Connect</span></h1>
            <p>Your one-stop platform for adopting and caring for pets.</p>
            <a href="findapet.php" class="adopt-button">I want to adopt a pet</a>
            <a href="list-a-pet.php" class="rehome-button">I need to rehome a pet </a>
        </div>

        <section class="why-choose-us">
            <h2>Why Choose Petspal Connect?</h2>
            <p>Because we enable direct pet adoption, from one good home to another.</p>
            <div class="benefits">
                <div class="benefit">
                    <div class="icon">
                        <img src="images/icons/favorite_24dp_8C1AF6_FILL0_wght400_GRAD0_opsz24.png" alt="Kind To Everyone">
                    </div>
                    <h3>Kind To Everyone</h3>
                    <p>We believe that...</p>
                    <ul>
                        <li>Every pet deserves to be safe, loved, and respected.</li>
                        <li>People who are great candidates for adoption shouldn't be put off by complicated processes or one-size-fits-all rules.</li>
                        <li>People who need to rehome their pets should be empowered to do so without being judged.</li>
                    </ul>
                </div>
                <div class="benefit">
                    <div class="icon">
                        <img src="images/icons/pets_24dp_8C1AF6_FILL0_wght400_GRAD0_opsz24.png" alt="Advocate Adoption">
                    </div>
                    <h3>Advocate Adoption</h3>
                    <p>This value sits at the heart of everything we do. Adoption reduces the demand for puppy farming, industrial-scale breeding, illegal pet imports, and other forms of exploitation and abuse.</p>
                    <p>We’re proud supporters of #AdoptDontShop.</p>
                </div>
                <div class="benefit">
                    <div class="icon">
                        <img src="images/icons/person_4_24dp_8C1AF6_FILL0_wght400_GRAD0_opsz24.png" alt="Responsible Rehoming">
                    </div>
                    <h3>Responsible Rehoming</h3>
                    <p>We’re champions of rehoming, but not at any cost. We believe in finding the right match between adopters and pets, not taking risks or rushing. We always prioritize pet welfare.</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
       <div class="footer-container">
            <div class="footer-section about">
                <h3>About Petspal Connect</h3>
                <p>We’re reimagining how you can responsibly rehome and adopt pets...</p>
            </div>
            <div class="footer-section links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Frequently Asked Questions</a></li>
                    <li><a href="">Register for a free PetspalConnect Account</a></li>
                    <li><a href="userregistration.php">Login to your PetspalConnect Account</a></li>
                    <li><a href="#">Tips For Adopters</a></li>
                </ul>
            </div>
            <div class="footer-section follow">
                <h3>Follow Us</h3>
                <ul class="social-icons">
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Copyright - PetspalConnect</p>
        </div>
    </footer>

    <script>
        function checkLogin(event) {
            event.preventDefault(); // Prevent the default link behavior
            <?php if (!$is_logged_in): ?>
                document.getElementById('login-popup').style.display = 'block'; // Show the popup
            <?php else: ?>
                window.location.href = 'list-a-pet.php'; // Redirect to the page if logged in
            <?php endif; ?>
        }

        function closePopup() {
            document.getElementById('login-popup').style.display = 'none'; // Hide the popup
        }
        
        // Close the popup if the user clicks anywhere outside of it
        window.onclick = function(event) {
            const popup = document.getElementById('login-popup');
            if (event.target === popup) {
                closePopup();
            }
        }
    </script>
</body>
</html>
