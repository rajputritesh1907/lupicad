<?php
ob_start(); // Start output buffering
require_once(__DIR__ . "/connection.inc.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_password'])) {
    $user_id = $_SESSION['user_id']; // Ensure the user is logged in
    $old = trim($_POST['old_password'] ?? '');
    $new = trim($_POST['new_password'] ?? '');
    $confirm = trim($_POST['confirm_password'] ?? '');

    // Initialize response array
    $response = [
        'success' => false,
        'error' => '',
    ];

    if (empty($old) || empty($new) || empty($confirm)) {
        $response['error'] = "All fields are required.";
    } else {
        $getPassword = $connection->prepare("SELECT password FROM user WHERE id = ?");
        $getPassword->bind_param("i", $user_id);
        $getPassword->execute();
        $result = $getPassword->get_result();
        $data = $result->fetch_assoc();
        $getPassword->close();

        if (!$data || !password_verify($old, $data['password'])) {
            $response['error'] = "Old password is incorrect.";
        } elseif ($new !== $confirm) {
            $response['error'] = "New passwords do not match.";
        } else {
            $newHashed = password_hash($new, PASSWORD_DEFAULT);
            $update = $connection->prepare("UPDATE user SET password = ? WHERE id = ?");
            $update->bind_param("si", $newHashed, $user_id);

            if ($update->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = "Something went wrong. Please try again.";
            }

            $update->close();
        }
    }

    // Return JSON response
    ob_end_clean(); // Clean any previous output
    echo json_encode($response);
    exit();
}
?>