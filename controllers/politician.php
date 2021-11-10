<?php
global $conn;
require __DIR__ . "/../config/config.inc.php";
require_once __DIR__ . "/../functions.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Politician {

    public $uuid;
    public $hash;
    public $name = [
        "fname" => "",
        "lname" => ""
    ];
    public $email;
    public $beruf;
    public $jahrgang;
    public $partei;
    public $behörde;
    public $gemeinde;
    public $picture;
    public $antworten;
    public $statement;
    public $status = 0;

    public function __construct() {}

    public function get($uuid) {
        global $conn;
        $stmt = $conn->prepare("SELECT * from `politicians` WHERE `politician_UUID` = ?;");
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            $result = $result->fetch_assoc();
            return unserialize($result["politician_info"]);
        } 
    }

    public function new($politician, $uuid) {
        global $conn;
        $this->uuid = $uuid;
        $this->hash = hash("sha256", rand(50000, 100000) * rand(50000, 100000));
        $stmt = $conn->prepare("SELECT * from `politicians` WHERE `politician_UUID` = ?;");
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT into `politicians` (`politician_UUID`, `politician_info`) VALUES (?,?);");
            $politician_info = serialize($politician);
            $stmt->bind_param("ss", $uuid, $politician_info);
            $result = $stmt->execute();
        }
    }

    public function register($data) {
        $return = [
            "type" => "",
            "code" => 0,
            "msg" => "",
            "next" => ""
        ];
        if ($this->check_party($data["partycode"]) == NULL) {
            $return["type"] = "error";
            $return["msg"] = "Der Partei Code konnte nicht verifiziert werden. Bitte versuche es nochmals.";
            echo(json_encode($return));
            return;
        }
        $politician = $this->get($data["uuid"]);
        global $conn;
        $stmt = $conn->prepare("UPDATE `politicians` SET `politician_info` = ? WHERE `politician_UUID` = ?;");
        $politician->name["fname"] = $data["fname"];
        $politician->name["lname"] = $data["lname"];
        $politician->email = $data["email"];
        $politician->beruf = $data["beruf"];
        $politician->jahrgang = $data["year"];
        $politician->partei = $this->check_party($data["partycode"]);
        $politician->behörde = $data["behörde"];
        $politician->gemeinde = findGemeinde($data["gemeinde"]);
        $politician_info = serialize($politician);
        $stmt->bind_param("ss", $politician_info, $data["uuid"]);
        $result = $stmt->execute();
        if ($result != 1) {
            $return["type"] = "error";
            $return["msg"] = "Es ist ein unerwarteter Fehler aufgetreten. Bitte versuche es nochmals";
            echo(json_encode($return));
            return;
        }
        $return["code"] = 200;
        $return["next"] = "/foto/{$data["uuid"]}";
        echo(json_encode($return));
    }

    public function check_party($hash) {
        global $conn;
        $stmt = $conn->prepare("SELECT * from `partyhashes` WHERE `hash_code` = ?;");
        $stmt->bind_param("s", $hash);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 1) {
            return NULL;
        } else {
            return findParty($result->fetch_assoc()["hash_party"]);
        }
    }

    public function get_from_hash($hash) {
        global $conn;
        $stmt = $conn->prepare("SELECT * from `politicians` WHERE `politician_info` LIKE ?;");
        $argument = '%"' . $hash . '"%';
        $stmt->bind_param("s", $argument);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            $result = $result->fetch_assoc();
            return unserialize($result["politician_info"]);
        } else {
            header("Content-type: application-json");
            echo(json_encode([
                "code" => 404,
                "type" => "error",
                "category" => "hash",
                "msg" => "Hash not found."
            ]));
            exit;
        }
    }

    public function update() {
        global $conn;
        $stmt = $conn->prepare("UPDATE `politicians` SET `politician_info` = ? WHERE `politician_UUID` = ?;");
        $politician_info = serialize($this);
        $stmt->bind_param("ss", $politician_info, $this->uuid);
        $result = $stmt->execute();
        if ($result == 1) {
            return 200;
        } else {
            return 500;
        }
    }

    public function upload_image($uuid, $files) {
        $politician = $this->get($uuid);
        $filename = strtolower($politician->name["fname"]) . "_" . strtolower($politician->name["lname"]) . "_" . $politician->hash . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

        $tempFile = $files['file']['tmp_name'];

        move_uploaded_file($tempFile, dirname(__FILE__) . "/../public/uploads/{$filename}");

        $politician->picture = $filename;

        if ($politician->update() == 200){
            echo(json_encode([
                "code" => 200,
                "next" => "/email/{$politician->uuid}"
            ]));
        };
    }

    public function send_link() {
        global $config;
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'victorinus.metanet.ch';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $config["email"]["user"];                     //SMTP username
            $mail->Password   = $config["email"]["pw"];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($config["email"]["user"], $config["email"]["from"]);
            $mail->addAddress($this->email, "{$this->name["fname"]} {$this->name["lname"]}");     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Ihr Link zur Umfrage, {$this->name["fname"]} {$this->name["lname"]}!";
            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
            $msgbody = str_replace(["{{FNAME}}", "{{LNAME}}", "{{PARTICIPATE LINK}}"], [$this->name["fname"], $this->name["lname"], $actual_link . "/umfrage/{$this->hash}"], file_get_contents(__DIR__ . "/../templates/emails/link.html"));
            $mail->Body    = $msgbody;

            if (!$mail->send()){
                die("Unable to send confirmation E-Mail");
            };
        } catch (Exception $e) {
            die("Unable to send confirmation E-Mail");
        }
    }

    public function send_confirmation() {
        global $config;
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'victorinus.metanet.ch';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $config["email"]["user"];                     //SMTP username
            $mail->Password   = $config["email"]["pw"];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($config["email"]["user"], $config["email"]["from"]);
            $mail->addAddress($this->email, "{$this->name["fname"]} {$this->name["lname"]}");     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "Danke für Ihre Teilnahme, {$this->name["fname"]} {$this->name["lname"]}!";
            $msgbody = str_replace(["{{FNAME}}", "{{LNAME}}"], [$this->name["fname"], $this->name["lname"]], file_get_contents(__DIR__ . "/../templates/emails/confirmation.html"));
            $mail->Body    = $msgbody;

            if (!$mail->send()){
                die("Unable to send confirmation E-Mail");
            };
        } catch (Exception $e) {
            die("Unable to send confirmation E-Mail");
        }
    }

    // Status

    public function set_status($step) {
        $this->status = $step;
        $this->update();
    }
    
    public function check_status($step) {
        if ($this->status == $step) {
            return;
        } else {
            die("Seomthing went wrong, please start over.");
        }
    }
}