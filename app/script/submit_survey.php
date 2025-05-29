<?php
session_start();
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Survey.php';

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Content-Security-Policy: default-src \'self\'');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid security token',
        'post_csrf_token' => $_POST['csrf_token'],
        'session_csrf_token' => $_SESSION['csrf_token'],
    ]);
    exit;
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$response = [
    'success' => true,
    'message' => '',
    'errors' => [],
    'csrf_token' => $_SESSION['csrf_token']
];

try {
    // Create and validate survey
    $survey = new Survey($_POST);
    
    if ($survey->validate()) {
        // Save survey if validation passed
        $surveyId = $survey->save();
        $response['success'] = true;
        $response['message'] = 'Survey submitted successfully!';
        $response['survey_id'] = $surveyId;
    } else {
        // Return validation errors
        $response['success'] = false;
        $response['message'] = 'Please correct the errors above.';
        $response['errors'] = $survey->getErrors();
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'An error occurred while saving your survey.';
    $response['errors']['database'] = $e->getMessage();
}

echo json_encode($response);
