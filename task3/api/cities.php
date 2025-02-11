<?php
require '../config.php';
require '../auth.php';

header('Content-Type: application/json');

try {
    $pdo = new PDO(
        "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset=utf8",
        $db_config['user'],
        $db_config['password']
    );

    $query = "
        SELECT 
            IFNULL(city, 'Не определен') AS city,
            COUNT(*) AS count
        FROM visits
        GROUP BY city
        ORDER BY count DESC
    ";
    
    $stmt = $pdo->query($query);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($data);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}