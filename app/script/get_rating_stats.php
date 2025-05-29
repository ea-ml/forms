<?php
require_once __DIR__ . '/../classes/Database.php';

function getAverageRating() {
    try {
        $db = Database::getInstance();
        $sql = "SELECT ROUND(AVG(rating), 1) as average_rating 
                FROM surveys";
        $result = $db->fetch($sql);
        return $result['average_rating'] ?? 0;
    } catch (Exception $e) {
        error_log("Error fetching average rating: " . $e->getMessage());
        return 0;
    }
} 