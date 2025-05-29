<?php
require_once __DIR__ . '/../classes/Database.php';

function getGenderStats() {
    try {
        $db = Database::getInstance();
        $sql = "SELECT gender, COUNT(*) as count 
                FROM surveys 
                GROUP BY gender 
                ORDER BY gender";
        return $db->fetchAll($sql);
    } catch (Exception $e) {
        error_log("Error fetching gender statistics: " . $e->getMessage());
        return [];
    }
} 