<?php
require_once __DIR__ . '/../classes/Database.php';

function getHobbies() {
    try {
        $db = Database::getInstance();
        $sql = "SELECT id, name FROM hobbies ORDER BY name ASC";
        return $db->fetchAll($sql);
    } catch (Exception $e) {
        error_log("Error fetching hobbies: " . $e->getMessage());
        return [];
    }
} 