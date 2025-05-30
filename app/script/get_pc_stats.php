<?php
require_once __DIR__ . '/../classes/Database.php';

function getPCStats() {
    $db = Database::getInstance();
    
    $query = "SELECT has_pc, COUNT(*) as count FROM surveys GROUP BY has_pc";
    $results = $db->fetchAll($query);
    
    $stats = [];
    foreach ($results as $result) {
        $stats[] = [
            'has_pc' => $result['has_pc'] ? 'Yes' : 'No',
            'count' => (int)$result['count']
        ];
    }
    
    return $stats;
} 