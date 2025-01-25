<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "educonsult";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Changed ORDER BY to id instead of created_at
    $sql = "SELECT * FROM books ORDER BY id DESC";
    $result = $conn->query($sql);
    $books = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $books]);
    } else {
        echo json_encode(['success' => true, 'data' => []]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if(isset($conn)) {
        $conn->close();
    }
}
?>