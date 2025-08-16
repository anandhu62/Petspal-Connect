<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petspal Connect - Home</title>
    <link rel="stylesheet" href="findapet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">

    <style>
        /* Popup styles */
        .popup {
            display: none; /* Initially hidden */
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(138, 43, 226, 0.8); /* Low opacity */
            color: white;
            padding: 40px; /* Increased padding for larger size */
            border-radius: 10px;
            z-index: 1000;
            font-size: 1.5em; /* Larger text */
            text-align: center; /* Center text */
            width: 60%;
        }
        .popup.show {
            display: block; /* Show the popup */
        }
        .popup-header {
            background-color: blueviolet;
            color: white;
            padding: 10px;
            font-size: 1.2em;
        }
        .popup-body {
            margin: 10px 0;
        }
        .popup button {
            background-color: blueviolet;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<?php
session_start(); // Start the session

// Display success message if exists
if (isset($_SESSION['success_message'])): ?>
    <div class="popup show" id="successPopup">
        <div class="popup-header">Success</div>
        <div class="popup-body">
            <?php echo $_SESSION['success_message']; ?>
        </div>
        <button onclick="closePopup()">Okay</button>
    </div>
    <?php unset($_SESSION['success_message']); // Clear the message after displaying ?>
<?php endif; ?>

<div class="navigation">
    <div class="logo">Petspal<span>Connect</span></div>
    <nav>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li class="dropdown">
                <a href="findapet.php" class="dropbtn">Adopt a Pet &#9662;</a>
                <div class="dropdown-content">
                    <a href="readytoadopt.html">Are You Ready To Adopt A Pet?</a>
                    <a href="testimonials.html">Testimonials from Adopters</a>
                    <a href="findapet.php">Browse Pets</a>
                </div>
            </li>
            <li><a href="list-a-pet.html">List a Pet</a></li>
            <li><a href="userregistration.php">Login/Register</a></li>
            <li><a href="#">About Us</a></li>
        </ul>
    </nav>
</div>

<h1>Find Your New Best Friend: Explore Pets Ready for Adoption</h1>
<section class="about-us">
    <div class="heading-paragraph">
        <p>Welcome to Petspal Connect, your trusted partner in finding and adopting pets. Our mission is to connect loving families with pets in need of a forever home. We are a passionate team dedicated to ensuring that every pet finds a safe and loving environment where they can thrive. Our platform offers a comprehensive list of pets available for adoption, making it easier for you to find the perfect companion.</p>
        <p>At Petspal Connect, we believe in the power of companionship and the joy that pets bring into our lives. Whether you're looking for a playful puppy, a gentle kitten, or a loyal senior pet, we are here to help you find the right match. We work closely with shelters and rescue organizations to provide you with accurate and up-to-date information about available pets.</p>
    </div>
</section>

<div class="container">
    
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Database connection
        $conn = new mysqli("localhost", "root", "akshay", "petadoption");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to get pets
        $sql = "SELECT id, breed, name, location, image_path FROM pets"; 
        $result = $conn->query($sql);

        // Begin dynamic pet listing
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePaths = explode(", ", $row["image_path"]);
                $firstImage = $imagePaths[0] ?? ''; 
                
                echo '
                <a href="petdetails.php?id=' . htmlspecialchars($row["id"]) . '">
                <div class="pet">
                    
                        <div class="thumbnail">';
                
                if (!empty($firstImage)) {
                    echo '<img src="' . htmlspecialchars($firstImage) . '" alt="' . htmlspecialchars($row["breed"]) . '">';
                } else {
                    echo '<img src="images/placeholder.jpg" alt="No image available">'; 
                }
                
                echo '</div>
                    <div class="pet-info">
                    <p class="petbreed">' . htmlspecialchars($row["breed"]) . '</p>
                        <p class="petname">' . htmlspecialchars($row["name"]) . '</p>
                        <p class="petlocation">Location: ' . htmlspecialchars($row["location"]) . '</p>
                    </div>
                    
                </div>
                </a> ';
                
            }
        } else {
            echo "<p>No pets found.</p>";
        }

        $conn->close();
        ?>
     


<script>
    // Show the popup if there is a success message
    window.onload = function() {
        var popup = document.getElementById("successPopup");
        if (popup) {
            popup.style.display = "block";
            setTimeout(function() {
                popup.style.display = "none";
            }, 2000); // Auto hide after 2 seconds
        }
    };
</script>

</body>
</html>
