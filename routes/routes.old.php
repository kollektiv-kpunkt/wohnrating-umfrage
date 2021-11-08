Router::get('/danke', function() {
    include_once __DIR__ . "/../templates/umfrage/danke.php";
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
    $contact = json_decode($politician["politician_info"], true);

    include_once __DIR__ . "/../templates/verify/index.php";
    exit;
});


// POST REQUESTS

Router::post("/umfrage/submit", function() {
    header("Content-Type: application/json");
    $response = json_decode(file_get_contents('php://input'), true);
    $answers = json_encode($response["questions"]);
    global $conn;
    $stmt = $conn->prepare("UPDATE `politicians` SET `politician_answers` = ? WHERE `politician_UUID` = ?;");
    $stmt->bind_param("ss", $answers, $response["politId"]);
    $resultSQL = $stmt->execute();
    if ($resultSQL != 1) {
        $response = [
            "code" => 500.1,
            "type" => "error",
            "text" => "Something went wrong (DB Failed)"
        ];
        echo(json_encode($response));
        exit;
    }
    $response = [
        "code" => 200,
        "type" => "success"
    ];
    echo(json_encode($response));
});

Router::post("/verify", function(){
    header("Content-Type: application/json");
    $contact = array();
    parse_str(json_decode($_POST["contact"]), $contact);
    $politician = json_encode([
        "ID" => uniqid(),
        "name" => [
            "fname"=>$contact["fname"],
            "lname"=>$contact["lname"]
        ],
        "email" => $contact["email"],
        "partei" => findParty($contact["partei"])["slug"],
        "gemeinde" => findGemeinde($contact["gemeinde"])["nr"],
        "contactStatus" => 1
    ]);

    global $conn;
    $stmt = $conn->prepare("UPDATE `politicians` SET `politician_info` = ? WHERE `politician_UUID` = ?;");
    $stmt->bind_param("ss", $politician, $_POST["politId"]);
    $resultSQL = $stmt->execute();
    if ($resultSQL != 1) {
        $response = [
            "code" => 500.1,
            "type" => "error",
            "text" => "Something went wrong (DB Failed)"
        ];
        echo(json_encode($response));
        exit;
    }
    $response = [
        "code" => 200,
        "type" => "success"
    ];
    echo(json_encode($response));
});