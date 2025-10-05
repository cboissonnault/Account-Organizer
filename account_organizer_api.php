<?php
// --- Account Organizer API (STABLE & SECURE) ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'account_organizer_db_config.php';

header('Content-Type: application/json');

function send_json_response($data, $statusCode = 200) {
    http_response_code($statusCode);
    if (!isset($data['success'])) {
        $data['success'] = ($statusCode === 200);
    }
    echo json_encode($data);
    exit;
}

$action = $_REQUEST['action'] ?? '';

try {
    $accounts_table = 'accounts';
    $categories_table = 'account_categories';

    if ($action === 'get_all_data') {
        $accounts = $conn->query("SELECT * FROM `$accounts_table` ORDER BY account_name ASC")->fetch_all(MYSQLI_ASSOC);
        $categories = $conn->query("SELECT * FROM `$categories_table` ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
        send_json_response(['success' => true, 'accounts' => $accounts, 'categories' => $categories]);
    } 
    elseif ($action === 'add_category') {
        $name = trim($_POST['name'] ?? '');
        if (empty($name)) send_json_response(['message' => 'Category name cannot be empty.'], 400);
        
        $stmt = $conn->prepare("INSERT INTO `$categories_table` (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        send_json_response(['message' => "Category '$name' added successfully."]);
    }
    elseif ($action === 'add_account') {
        $stmt = $conn->prepare(
            "INSERT INTO `$accounts_table` (account_name, category, website, username, card_on_file, security_questions, notes, secure_data_1, secure_data_2) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssssssss", 
            $_POST['account_name'], $_POST['category'], $_POST['website'], $_POST['username'],
            $_POST['card_on_file'], $_POST['security_questions'], $_POST['notes'],
            $_POST['secure_data_1'], $_POST['secure_data_2']
        );
        $stmt->execute();
        send_json_response(['message' => 'Account saved successfully.']);
    }
    elseif ($action === 'delete_account') {
        $id = intval($_POST['id'] ?? 0);
        if (empty($id)) send_json_response(['message' => 'Invalid ID for deletion.'], 400);
        
        $stmt = $conn->prepare("DELETE FROM `$accounts_table` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        send_json_response(['message' => 'Account deleted successfully.']);
    }
    else {
        send_json_response(['message' => 'Invalid action specified.'], 400);
    }

} catch (Exception $e) {
    send_json_response(['message' => 'An unexpected server error occurred: ' . $e->getMessage()], 500);
} finally {
    if (isset($stmt) && $stmt) $stmt->close();
    $conn->close();
}
?>

