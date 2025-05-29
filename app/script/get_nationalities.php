<?php
require_once __DIR__ . '/../classes/Database.php';

function getNationalities() {
    try {
        $db = Database::getInstance();
        $sql = "SELECT id, name FROM nationalities ORDER BY name ASC";
        return $db->fetchAll($sql);
    } catch (Exception $e) {
        error_log("Error fetching nationalities: " . $e->getMessage());
        return [];
    }
} 