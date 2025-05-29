<?php
require_once __DIR__ . '/../classes/Database.php';

function getHobbyStats() {
    try {
        $db = Database::getInstance();
        $sql = "SELECT h.name, COUNT(sh.survey_id) as count 
                FROM hobbies h 
                LEFT JOIN survey_hobbies sh ON h.id = sh.hobby_id 
                GROUP BY h.id, h.name 
                ORDER BY count DESC";
        return $db->fetchAll($sql);
    } catch (Exception $e) {
        error_log("Error fetching hobby statistics: " . $e->getMessage());
        return [];
    }
} 