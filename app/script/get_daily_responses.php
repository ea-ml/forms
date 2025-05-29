<?php
require_once __DIR__ . '/../classes/Database.php';

function getDailyResponses() {
    try {
        $db = Database::getInstance();
        $sql = "SELECT 
                    DATE(created_at) as date,
                    COUNT(*) as count
                FROM surveys 
                GROUP BY DATE(created_at)
                ORDER BY date ASC";
        return $db->fetchAll($sql);
    } catch (Exception $e) {
        error_log("Error fetching daily responses: " . $e->getMessage());
        return [];
    }
} 