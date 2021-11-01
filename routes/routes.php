<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

include __DIR__ . "/../config/config.inc.php";

Router::get('/', function() {
    
    include_once __DIR__ . "/../templates/umfrage/index.php";
    exit;
});

Router::get('/umfrage/{politId}', function($politId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * from `politicians` WHERE `politician_UUID` = ?;");
    $stmt->bind_param("s", $politId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        header("Location: /");
        exit;
    }
    $politician = $result->fetch_assoc();
    $contact = json_decode($politician["politician_info"]);
    if ($contact->contactStatus == 0) {
        header("Location: /verify/{$politId}");
        exit;
    }

    include_once __DIR__ . "/../templates/umfrage/form.php";
    exit;
});


Router::get('/verify/{politId}', function($politId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * from `politicians` WHERE `politician_UUID` = ?;");
    $stmt->bind_param("s", $politId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        header("Location: /");
        exit;
    }
    $politician = $result->fetch_assoc();

    include_once __DIR__ . "/../templates/verify/index.php";
    exit;
});


Router::post("/umfrage/submit", function() {
    $input = json_decode(file_get_contents('php://input'), true);
    print_r($input);
});