<?php
require 'config.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $pdo = new PDO(
        "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset=utf8",
        $db_config['user'],
        $db_config['password']
    );
    
    $stmt = $pdo->prepare(
        "INSERT INTO visits (ip, city, device) 
         VALUES (:ip, :city, :device)"
    );
    
    $stmt->execute([
        ':ip' => $data['ip'],
        ':city' => $data['city'],
        ':device' => $data['device']
    ]);
    
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}