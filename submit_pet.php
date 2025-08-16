<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "akshay";
$dbname = "petadoption";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Form not submitted properly");
}

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

try {
    // Retrieve and validate form data
    $name = isset($_POST['pet-name']) ? $_POST['pet-name'] : die("Pet name missing");
    $breed = isset($_POST['breed']) ? $_POST['breed'] : die("Breed missing");
    $age = isset($_POST['pet-age']) ? (int)$_POST['pet-age'] : die("Age missing");
    $sex = isset($_POST['pet-sex']) ? $_POST['pet-sex'] : die("Sex missing");
    $size = isset($_POST['pet-size']) ? $_POST['pet-size'] : die("Size missing");

    // Boolean values for yes/no selections
    $vaccinated = isset($_POST['vaccinated']) && $_POST['vaccinated'] === 'yes' ? 1 : 0;
    $neutered = isset($_POST['neutered']) && $_POST['neutered'] === 'yes' ? 1 : 0;

    $good_with_kids = isset($_POST['good-with-kids']) ? $_POST['good-with-kids'] : 'no';
    $good_with_dogs = isset($_POST['good-with-dogs']) ? $_POST['good-with-dogs'] : 'no';
    $good_with_cats = isset($_POST['good-with-cats']) ? $_POST['good-with-cats'] : 'no';
    $house_trained = isset($_POST['housetrained']) && $_POST['housetrained'] === 'yes' ? 'yes' : 'no';
    $microchipped = isset($_POST['microchipped']) && $_POST['microchipped'] === 'yes' ? 'yes' : 'no';
    $purebred = isset($_POST['purebred']) && $_POST['purebred'] === 'yes' ? 'yes' : 'no';
    $has_special_needs = isset($_POST['has-special-needs']) && $_POST['has-special-needs'] === 'yes' ? 'yes' : 'no';
    $has_behavioural_issues = isset($_POST['has-behavioural-issues']) && $_POST['has-behavioural-issues'] === 'yes' ? 'yes' : 'no';
    
    // Description and user ID from session
    $description = isset($_POST['pet-description']) ? $_POST['pet-description'] : '';
    $user_id = $_SESSION['user_id'];
    $location = $_SESSION['address']; // Use 'address' from session since it maps to 'location' in the form

    // Handle image uploads
    $imagePaths = [];   
    for ($i = 1; $i <= 4; $i++) {
        if (isset($_FILES["pet-photo$i"]) && $_FILES["pet-photo$i"]["error"] === 0) {
            $target_dir = "uploads/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . time() . '_' . basename($_FILES["pet-photo$i"]["name"]);
            if (move_uploaded_file($_FILES["pet-photo$i"]["tmp_name"], $target_file)) {
                $imagePaths[] = $target_file;
            }
        }
    }
    $imagePathsString = implode(", ", $imagePaths);

    // Prepare SQL query
    $query = "INSERT INTO pets (
        name, breed, age, sex, size, vaccinated, neutered, location, description,
        good_with_kids, good_with_dogs, good_with_cats, house_trained,
        microchipped, purebred, has_special_needs, has_behavioural_issues,
        image_path, user_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssiissssssssssss", 
        $name, $breed, $age, $sex, $size, 
        $vaccinated, $neutered, $location, $description, 
        $good_with_kids, $good_with_dogs, $good_with_cats, 
        $house_trained, $microchipped, $purebred, 
        $has_special_needs, $has_behavioural_issues, 
        $imagePathsString, $user_id);

    // Execute query
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    echo "<br><br>Insert successful!";
    $stmt->close();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
} finally {
    $conn->close();
}
?>
