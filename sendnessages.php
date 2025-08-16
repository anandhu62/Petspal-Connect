<?php
include('connection.php');
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$positive_responses = array(
    'yes', 'yeah', 'yep', 'sure', 'okay', 'ok', 'interested', 
    'im interested', "i'm interested", 'definitely', 'absolutely', 
    'of course', 'would love to', 'want to', 'ready', 'certainly','Yes','YES'
    
);

$negative_responses = array(
    'no', 'nah', 'nope', 'not interested', 'not ready',
    'cant', "can't", 'cannot', 'maybe later', 'next time',
    'not now', 'sorry', 'negative', 'pass'
);

if (isset($_POST['message']) && isset($_POST['pet_id'])) {
    $sender_id = $_SESSION['user_id'];
    $user_message = trim($_POST['message']);
    $user_message_lower = strtolower($user_message);
    
    
    $pet_query = "SELECT p.user_id, p.name, 
                  (SELECT content FROM messages 
                   WHERE pet_id = p.id 
                   ORDER BY timestamp DESC 
                   LIMIT 1) as last_message 
                  FROM pets p 
                  WHERE p.id = ?";
    
    $stmt = mysqli_prepare($conn, $pet_query);
    mysqli_stmt_bind_param($stmt, "i", $_POST['pet_id']);
    mysqli_stmt_execute($stmt);
    $pet_result = mysqli_stmt_get_result($stmt);
    // var_dump($pet_result);

    
    if ($pet_result && mysqli_num_rows($pet_result) > 0) {
        $pet = mysqli_fetch_assoc($pet_result);
        $receiver_id = $pet['user_id'];
        $pet_name = $pet['name'];
        $last_message = $pet['last_message'];
        
        
        $insert_query = "INSERT INTO messages (sender_id, receiver_id, pet_id, content, timestamp) 
                        VALUES (?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, "iiis", $sender_id, $receiver_id, $_POST['pet_id'], $user_message);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $auto_response = "";
            
            
            if ($last_message == "Please type CONFIRM to verify") {
                if (strtoupper($user_message) == "CONFIRM") {
                    $auto_response = "Thank you! Please provide your contact number so that we can call you and share the location for pickup.";
                } else {
                    
                    $auto_response = "Please type CONFIRM (in capital letters) to verify your adoption request for " . $pet_name;
                }
            }
            
            else if ($last_message == "Are you ready to adopt " . $pet_name . "?") {
                if (in_array($user_message_lower, $positive_responses) || 
                    preg_match('/\b(' . implode('|', $positive_responses) . ')\b/', $user_message_lower)) {
                    $auto_response = "Please type CONFIRM to verify";
                } else if (in_array($user_message_lower, $negative_responses) || 
                         preg_match('/\b(' . implode('|', $negative_responses) . ')\b/', $user_message_lower)) {
                    $auto_response = "Okay, bye! Feel free to check back when you're ready.";
                } else {
                    $auto_response = "I'm sorry, I didn't understand your response. Are you ready to adopt " . $pet_name . "? Please answer with yes or no.";
                }
            }
            
            
            
            else if ($last_message == "Great! Please provide your contact number so we can proceed with the adoption process.") {
                if (preg_match('/\+?\d{1,4}[\s\-]?\(?\d{1,3}\)?[\s\-]?\d{3}[\s\-]?\d{4,6}/', $user_message)) {
                    $auto_response = "Thank you for providing your contact details. Our team will get in touch with you shortly.";
                    
                    
                    $adoption_query = "INSERT INTO adoptions (pet_id, adopter_id, adoption_date, status) 
                                     VALUES (?, ?, NOW(), 'pending')";
                    $stmt = mysqli_prepare($conn, $adoption_query);
                    mysqli_stmt_bind_param($stmt, "ii", $_POST['pet_id'], $sender_id);
                    $adoption_result = mysqli_stmt_execute($stmt);
                    
                    if ($adoption_result) {
                
                        $update_pet_status = "UPDATE pets SET status = 'pending' WHERE id = ?";
                        $stmt = mysqli_prepare($conn, $update_pet_status);
                        mysqli_stmt_bind_param($stmt, "i", $_POST['pet_id']);
                        mysqli_stmt_execute($stmt);
                    } else {
                        echo json_encode(['success' => false, 'message' => "Error updating adoption: " . mysqli_error($conn)]);
                        exit;
                    }
                } else {
                    $auto_response = "Please provide a valid contact number to proceed with the adoption.";
                }
            }
            
            else {
                $auto_response = "Are you ready to adopt " . $pet_name . "?";
                $last_message = $auto_response;
            }
            
            // Insert automatic response
            if ($auto_response) {
                $response_query = "INSERT INTO messages (sender_id, receiver_id, pet_id, content, timestamp) 
                                 VALUES (?, ?, ?, ?, NOW()+1)";
                $stmt = mysqli_prepare($conn, $response_query);
                mysqli_stmt_bind_param($stmt, "iiis", $receiver_id, $sender_id, $_POST['pet_id'], $auto_response);
                $response_result = mysqli_stmt_execute($stmt);
                
                if ($response_result) {
                    echo json_encode(['success' => true, 'response' => $auto_response]);
                } else {
                    echo json_encode(['success' => false, 'message' => "Error sending automatic response: " . mysqli_error($conn)]);
                }
            }
        } else {
            echo json_encode(['success' => false, 'message' => "Error sending message: " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "Pet not found!"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => "Message or Pet ID not provided."]);
}

mysqli_close($conn);
?>
