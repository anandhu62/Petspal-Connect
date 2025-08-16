<?php

$servername = "localhost"; 
$username = "root";         
$password = "akshay";             
$dbname = "petadoption";        

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    
    $email = sanitizeInput($_POST['email']);
    $firstname = sanitizeInput($_POST['firstname']);
    $lastname = sanitizeInput($_POST['lastname']);
    $phone_number = sanitizeInput($_POST['phone']);
    $location = sanitizeInput($_POST['location']); // Sanitize location input
    
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo "Invalid email format";
        exit;
    }

    $password = sanitizeInput($password);
    $repassword = sanitizeInput($_POST['repassword']);

    if ($password !== $repassword) {
        $register_error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $email_check_query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($email_check_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $register_error = "Email is already registered.";
        } else {
            // Include the location field in the insert query
            $insert_query = "INSERT INTO users (email, firstname, lastname, phone_number, location, password) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ssssss", $email, $firstname, $lastname, $phone_number, $location, $hashed_password);

            if ($stmt->execute()) {
                header("Location: success.php");  
                exit();
            } else {
                $register_error = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo "Invalid email format";
        exit;
    }

    // Check if the email exists in the database
    $login_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($login_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            echo "Login successful for: " . $user['email'];
            
            // Start a session and redirect the user to the home page
            session_start();
            $_SESSION['user'] = $user['firstname'];
           
            
            header("Location: home.php"); // Redirect to home page
            exit();
        } else {
            $login_error = "Incorrect password.";
        }
    } else {
        $login_error = "No account found with that email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petspal Connect</title>  
    <link rel="stylesheet" href="userregistration.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-register-container">
        <div class="tabs">
            <button id="loginTab" class="active" onclick="showLogin()">Login</button>
            <button id="registerTab" onclick="showRegister()">Register</button>
        </div>

        <!-- Login Form -->
        <div id="loginContent" class="form-content">
            <div class="form-image">
                <img src="images/035bb369-826c-407f-9db6-372a8ffc2ec1.jpeg" alt="Login Image">
                <p>Login</p>
            </div>
            <div class="login-form">
                <form action="" method="POST">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="remember-forgot">
                        <label>
                            <input type="checkbox" name="remember"> Remember me
                        </label>
                        <a href="forgot-password.php">Lost your password?</a>
                    </div>
                    <button type="submit" name="login" class="login-button">Log In</button>
                </form>
                <?php if (isset($login_error)) echo "<p style='color:red;'>$login_error</p>"; ?>
                <p class="register-link">"Don't have an account? "<a href="#" onclick="showRegister()">Register</a></p>
            </div>
        </div>

        <!-- Register Form -->
        <div id="registerContent" class="form-content hidden">
            <div class="form-image">
                <img src="images/f009138f-637a-4c16-821c-89f182b06d53.jpeg" alt="Register Image">
                <p>Register</p>
            </div>
            <div class="register-form">
                <form action="" method="POST">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" placeholder="First name" required>
                    </div>
                    <div class="input-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Last name" required>
                    </div>
                    <div class="input-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Phone number" required>
                    </div>
                    
                    <!-- New Location Input Field -->
                    <div class="input-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="Enter your location" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="input-group">
                        <label for="repassword">Re-enter Password</label>
                        <input type="password" id="repassword" name="repassword" placeholder="Re-enter Password" required>
                    </div>
                    <div class="terms">
                        <label>
                            <input type="checkbox" name="terms" required> I have read and agree to the Terms and Privacy Policy
                        </label>
                    </div>
                    <button type="submit" name="register" class="register-button">Register</button>
                </form>
                <?php if (isset($register_error)) echo "<p style='color:red;'>$register_error</p>"; ?>
                <p class="login-link">Already have an account? <a href="#" onclick="showLogin()">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        function showLogin() {
            document.getElementById('loginTab').classList.add('active');
            document.getElementById('registerTab').classList.remove('active');
            document.getElementById('loginContent').classList.remove('hidden');
            document.getElementById('registerContent').classList.add('hidden');
        }
        
        function showRegister() {
            document.getElementById('loginTab').classList.remove('active');
            document.getElementById('registerTab').classList.add('active');
            document.getElementById('loginContent').classList.add('hidden');
            document.getElementById('registerContent').classList.remove('hidden');
        }
    </script>
</body>
</html>
