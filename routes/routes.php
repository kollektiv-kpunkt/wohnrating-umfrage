<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

include __DIR__ . "/../config/config.inc.php";
include __DIR__ . "/../functions.php";
include __DIR__ . "/../controllers/politician.php";

Router::get('/', function() {
    global $config;
    global $page;
    $page = [
        "title" => "Jetzt mitmachen!"
    ];
    include_once __DIR__ . "/../templates/umfrage/index.php";
    exit;
});

Router::get("/registrieren/{politicianId}", function($politicianId){
    $politician = new Politician;
    $politician->new($politician, $politicianId);

    global $config;
    global $page;
    $page = [
        "title" => "Registration"
    ];
    include_once __DIR__ . "/../templates/umfrage/register.php";
    exit;
});

Router::get("/foto/{politicianId}", function($politicianId){
    $politician = new Politician;
    $politician->get($politicianId);
    global $config;
    global $page;
    $page = [
        "title" => "Foto hochladen"
    ];
    include_once __DIR__ . "/../templates/umfrage/picture.php";
    exit;
});

Router::get("/umfrage/{hash}", function($hash){
    $politician = new Politician;
    $politician = $politician->get_from_hash($hash);
    global $config;
    global $page;
    $page = [
        "title" => "Umfrage"
    ];
    include_once __DIR__ . "/../templates/umfrage/umfrage.php";
    exit;
});

Router::get("/statement/{politicianId}", function($politicianId){
    $politician = new Politician;
    $politician = $politician->get($politicianId);
    global $config;
    global $page;
    $page = [
        "title" => "Ihr statement"
    ];
    include_once __DIR__ . "/../templates/umfrage/statement.php";
    exit;
});

Router::get("/danke/{politicianId}", function($politicianId){
    $politician = new Politician;
    $politician = $politician->get($politicianId);
    $politician->send_confirmation();
    global $config;
    global $page;
    $page = [
        "title" => "Danke!"
    ];
    include_once __DIR__ . "/../templates/umfrage/thx.php";
    exit;
});

Router::get("/confirm/{politicianId}", function($politicianId){
    $politician = new Politician;
    $politician = $politician->get($politicianId);
    $politician->status = 1;
    $politician->update();
    global $config;
    global $page;
    $page = [
        "title" => "E-Mail Adresse bestätigt!"
    ];
    include_once __DIR__ . "/../templates/umfrage/confirmed.php";
    exit;
});


Router::post("/register", function(){
    header("Content-type: application/json");
    $politician = new Politician;
    $politician->register($_POST);
});

Router::post("/picture-upload/{politicianId}", function($politicianId){
    header("Content-type: application/json");
    $politician = new Politician;
    $politician->upload_image($politicianId, $_FILES);
});

Router::post("/questionaire", function(){
    header("Content-type: application/json");
    $politician = new Politician;
    $politician = $politician->get($_POST["uuid"]);
    $politician->antworten = serialize($_POST["answers"]);
    if ($politician->update() == 200) {
        $return = [
            "code" => 200,
            "next" => "/statement/{$politician->uuid}"
        ];
        echo(json_encode($return));
    } else {
        $return = [
            "type" => "error",
            "msg" => "Es ist ein unerwarteter Fehler aufgetreten. Bitte versuchen Sie es später nochmals!"
        ];
        echo(json_encode($return));
    };
});

Router::post("/statement", function(){
    header("Content-type: application/json");
    $politician = new Politician;
    $politician = $politician->get($_POST["uuid"]);
    $politician->statement = $_POST["statement"];
    if ($politician->update() == 200) {
        $return = [
            "code" => 200,
            "next" => "/danke/{$politician->uuid}"
        ];
        echo(json_encode($return));
    } else {
        $return = [
            "type" => "error",
            "msg" => "Es ist ein unerwarteter Fehler aufgetreten. Bitte versuchen Sie es später nochmals!"
        ];
        echo(json_encode($return));
    };
});