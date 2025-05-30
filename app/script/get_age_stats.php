<?php
require_once __DIR__ . '/../classes/Database.php';

function getAgeStats() {
    $db = Database::getInstance();
    
    // Define age ranges
    $ranges = [
        ['min' => 1, 'max' => 17, 'label' => 'Under 18'],
        ['min' => 18, 'max' => 24, 'label' => '18-24'],
        ['min' => 25, 'max' => 34, 'label' => '25-34'],
        ['min' => 35, 'max' => 44, 'label' => '35-44'],
        ['min' => 45, 'max' => 54, 'label' => '45-54'],
        ['min' => 55, 'max' => 64, 'label' => '55-64'],
        ['min' => 65, 'max' => 99, 'label' => '65+']
    ];

    $stats = [];
    
    foreach ($ranges as $range) {
        $query = "SELECT COUNT(*) as count FROM surveys WHERE age BETWEEN ? AND ?";
        $result = $db->fetch($query, [$range['min'], $range['max']]);
        $stats[] = [
            'range' => $range['label'],
            'count' => (int)$result['count']
        ];
    }
    
    return $stats;
} 