<?php
require_once __DIR__ . '/../classes/Database.php';

function getNationalityStats() {
    try {
        $db = Database::getInstance();
        $sql = "SELECT n.name, COUNT(s.id) as count 
                FROM nationalities n 
                LEFT JOIN surveys s ON n.id = s.nationality_id 
                GROUP BY n.id, n.name 
                ORDER BY count DESC";
        return $db->fetchAll($sql);
    } catch (Exception $e) {
        error_log("Error fetching nationality statistics: " . $e->getMessage());
        return [];
    }
} 