<?php 
require "config.php";
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';
require 'PHPMailer/PHPMailer/src/Exception.php';
function connect(){
   // Create a new MySQLi object and establish 
   // a connection using the defined constants from 
   // the config file.
   $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
 
   // Check if there is a connection error.
   if($mysqli->connect_errno != 0){
      
      // If an error occurs, retrieve the error details.
      $error = $mysqli->connect_error;
 
      // Get the current date and time in 
      // a human-readable format.
      $error_date = date("F j, Y, g:i a");
 
      // Create a message combining the error and the date.
      $message = "{$error} | {$error_date} \r\n";
 
      // Append the error message to a log file 
      // named 'db-log.txt'.
      file_put_contents("db-log.txt", $message, FILE_APPEND);
      
      // Return false to indicate a connection failure.
      return false;
   }else{
      // If the connection is successful, 
      // set the character set to "utf8mb4" which 
      // supports a wider range of characters. 
      $mysqli->set_charset("utf8mb4");
 
      // Return the MySQLi object, indicating 
      // a successful connection.
      return $mysqli;	
   }
}
function registerUser($email, $username, $password, $confirm_password) {
    // Establish a database connection.
    $mysqli = connect();
    
    // Trim whitespace from input values.
    $email = trim($email);
    $username = trim($username);
    $password = trim($password);
    $confirm_password = trim($confirm_password);
 
    // Check if any field is empty.
    $args = func_get_args();
    foreach ($args as $value) {
        if (empty($value)) {
            // If any field is empty, return an error message.
            return "Alle Felder müssen ausgefüllt werden";
        }
    }
 
    // Check for disallowed characters (< and >).
    foreach ($args as $value) {
        if (preg_match("/([<|>])/", $value)) {
            // If disallowed characters are found, 
            // return an error message.
            return "< und > Zeichen sind nicht erlaubt";
        }
    }
 
    // Validate email format.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If email is not valid, return an error message.
        return "EMail nicht gültig";
    }
 
    // Check if the email already exists in the database.
    $stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data != NULL) {
        // If email already exists, return an error message.
        return "EMail wird bereits verwendet";
    }
 
    // Check if the username is too long.
    if (strlen($username) > 100) {
        // If username is too long, return an error message.
        return "E-Nummer nicht gültig";
    }
 
    // Check if the username already exists in the database.
    $stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data != NULL) {
        // If username already exists, return an error message.
        return "E-Nummer bereits registriert.";
    }
 
    // Check if the password is too long.
    if (strlen($password) > 255) {
        // If password is too long, return an error message.
        return "Passwort ist zu lang";
    }
 
    // Check if the passwords match.
    if ($password != $confirm_password) {
        // If passwords don't match, return an error message.
        return "Passwörter stimmen nicht überein";
    }
 
    // Hash the password for security.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 
    // Insert user data into the 'users' table.
    $stmt = $mysqli->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);
    $stmt->execute();
 
    // Check if the insertion was successful.
    if ($stmt->affected_rows != 1) {
        // If an error occurred during insertion, return an error message.
        return "Es ist ein Fehler aufgetreten, versuche es nochmals";
    } else {
        // If successful, return a success message.
        $responselogin = login($_POST['username'], $_POST['password']);
        return "Dein Konto wurde erfolgreich erstellt";
    }
}

function login($username, $password) {
    // Establish a database connection.
    $mysqli = connect();
 
    // Trim leading and trailing whitespaces 
    // from username and password.
    $username = trim($username);
    $password = trim($password);
 
    // Check if either username or password is empty.
    if ($username == "" || $password == "") {
        return "Alle Felder müssen ausgefüllt werden";
    }
 
    // Sanitize username and password to prevent SQL injection.
    $username = filter_var($username, 513); 
    $password = filter_var($password, 513);
 
    // Prepare SQL statement to select username 
    // and password from users table.
    $sql = "SELECT username, password FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    
    // Bind the username parameter to the prepared statement.
    $stmt->bind_param("s", $username);
    
    // Execute the prepared statement to query the database.
    $stmt->execute();
    
    // Get the result set from the executed statement.
    $result = $stmt->get_result();
    
    // Fetch the associative array representing the first
    // row of the result set.
    $data = $result->fetch_assoc();
 
    // Check if the username exists in the database.
    if ($data == NULL) {
        return "Falsche E-Nummer oder Passwort";
    }
 
    // Verify the provided password against the 
    // hashed password in the database.
    if (password_verify($password, $data["password"]) == FALSE) {
        return "Falsche E-Nummer oder Passwort";
    } else {
        // If authentication is successful, 
        // set the user session and redirect to account page.
        $_SESSION["user"] = $username;
        header("location: account.php");
        exit();
    }
}
function logoutUser(){
    session_destroy();
    header("location: index.php");
    exit();
 }
function passwordReset($email){
// Establish a database connection.
$mysqli = connect();

// Trim leading and trailing whitespaces from the email.
$email = trim($email);

// Validate the email format using the 
// FILTER_VALIDATE_EMAIL filter.
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    return "EMail ist nicht gültig";
}

// Prepare and execute a query to check if the email 
// exists in the 'users' table.
$stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Check if the email exists in the database.
if($data == NULL){
    return "EMail ist nicht registriert";
}

// Generate a new password.
$str = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz";
$password_length = 7;
$new_pass = substr(str_shuffle($str), 0, $password_length);

// Hash the new password.
$hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

// Create a new PHPMailer instance.
$mail = new PHPMailer\PHPMailer\PHPMailer(true);
$mail->CharSet = 'UTF-8';

// Configure PHPMailer for SMTP mailing.
$mail->isSMTP();	                  				
$mail->Host = MAIL_HOST;      		 				
$mail->SMTPAuth = true;        
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail      				
$mail->Username = MAIL_USERNAME;     				
$mail->Password = MAIL_PASSWORD;     				
$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;  	
$mail->Port = 587; 

// Set email recipients, subject, and body.
$mail->setFrom(MAIL_USERNAME, WEBSITE_NAME);  
$mail->addAddress($email);					 
$mail->Subject = 'Passwort Zurücksetzung';
$mail->Body = "Du kannst dich mit deinem neuen Passwort einloggen : {$new_pass}
Falls du ein spezifisches Passwort willst, melde dich bei dem Server Admin.";

// Send the email.
if(!$mail->send()){
    return "Es ist ein Fehler beim senden der EMail aufgetreten. Versuche es später erneut.";
}else{
    // Update the user's password in the 'users' table.
    $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();
    
    // Check if the password update was successful.
    if($stmt->affected_rows != 1){
        return "Es ist ein Verbindungsfehler aufgetreten. Versuche es erneut."; 
    }else{
        return "Das Passwort wurde erfolgreich zurückgesetzt";
    }
}
}
function deleteAccount(){
// Establish a database connection.
$mysqli = connect();

// Prepare and execute a query to delete the 
// user's information from the 'users' table.
$sql = "DELETE FROM users WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();

// Check if the deletion was successful.
if($stmt->affected_rows != 1){
    return "Es ist ein Fehler aufgetreten. Versuche es erneut.";
}else{
    // Destroy the user's session.
    session_destroy();

    // Redirect to the delete-message.php page.
    header("location: index.php");
    exit();
}
}
function KompatibilitätPrüfen($Zugnummer,$Stromrichter,$Bauteil){
    $mysqli = connect();
    
    $Zugnummer = trim($Zugnummer);
    $Stromrichter = trim($Stromrichter);

    // Prepare and execute a query to check if the email 
    // exists in the 'users' table.
    $stmt = $mysqli->prepare("SELECT Kompatibilität FROM eingebaute_bauteile WHERE Fahrzeugnummer = ? AND Stromrichter = ?");
    $stmt->bind_param("ss", $Zugnummer, $Stromrichter);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data != NULL) {
        $columnName = getColumnName($data);
        if ($columnName != NULL) {            
            $bauteile = getAvailableBauteile($columnName,$Bauteil);
            return $bauteile; // Return the fetched data
            // Process $bauteile or do something with it
        } else {
            return "Es ist ein Fehler aufgetreten. Versuche es erneut.";
        }
    } else {
        return "Es wurde kein passendes Fahrzeug oder Stromrichter gefunden. Versuche es erneut.";

    }
    

}   

function getColumnName($data){
    $mysqli = connect();
    $bauteile = [];

    // Calculate the column number based on $data

    $columnNumber = (int)$data["Kompatibilität"] + 6;
    $fields = $mysqli->query("SELECT * FROM kompatibilität LIMIT 1")->fetch_fields();

    if ($fields && isset($fields[$columnNumber - 1])) {
        $columnName = $fields[$columnNumber - 1]->name;
        return $columnName;
    } else {
        return "Es ist ein Fehler aufgetreten. Versuche es erneut.";
    }
}
/*function getAvailableBauteile($columnName,$Bauteil) {
    $mysqli = connect();
    $bauteile = [];

    
    $stmt = $mysqli->prepare("SELECT tag FROM kompatibilität WHERE $columnName = ?");
    $TrueValue = "True";
    $stmt->bind_param("s", $TrueValue);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results into an array
    while ($row = $result->fetch_assoc()) {
        $bauteil = $row['tag'];

        // Check for duplicates before adding to the array
        if (!in_array($bauteil, $bauteile)) {
            $bauteile[] = $bauteil;
        }
    }

    // Close the statement
    $stmt->close();

    return $bauteile;
}*/
function getAvailableBauteile($columnName, $Bauteil) {
    $mysqli = connect();
    $bauteile = [];

    $stmt = $mysqli->prepare("SELECT  Baugruppe, ABB_Ident_Nr, SBB_Art_Nr FROM kompatibilität WHERE $columnName = 'True' AND tag = ?");
    $searchTerm = $Bauteil; // Adjust as needed for your search conditions

    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results into an array
    while ($row = $result->fetch_assoc()) {
        $bauteilInfo = [
            'Baugruppe' => $row['Baugruppe'],
            'ABB_IdentNr' => $row['ABB_Ident_Nr'],
            'SBB_Art_Nr' => $row['SBB_Art_Nr'],
        ];
        
        // Check for duplicates before adding to the array
        if (!in_array($bauteilInfo, $bauteile)) {
            $bauteile[] = $bauteilInfo;
        }
    }

    // Close the statement
    $stmt->close();

    return $bauteile;
}


function suggestBauteile() {
    $mysqli = connect();
    $bauteileSuggest = [];

    $stmt = $mysqli->prepare("SELECT tag FROM kompatibilität");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $bauteil = $row['tag'];

        // Check for duplicates before adding to the array
        if (!in_array($bauteil, $bauteileSuggest)) {
            $bauteileSuggest[] = $bauteil;
        }
    }

    return $bauteileSuggest;
}

function updateBauteileInfo($Zugnummer, $Stromrichter, $Auftragsnummer, $Meldungsnummer, $TicketNr, $Bauteil, $ABBIdentNrNew, $SerienNrNew) {
    // Connect to the database
    $mysqli = connect();

    // Fetch the ABB Ident Nr and Serien Nr for the "old" bauteil
    $queryOld = "SELECT `{$Bauteil} Ident. Nr.`, `{$Bauteil} Serie Nr.` FROM `eingebaute_bauteile` WHERE `Fahrzeugnummer` = ? AND `Stromrichter` = ?";
    $stmtOld = $mysqli->prepare($queryOld);
    $stmtOld->bind_param("ss", $Zugnummer, $Stromrichter);
    $stmtOld->execute();
    $stmtOld->bind_result($ABBIdentNrOld, $SerienNrOld);
    $stmtOld->fetch();
    $stmtOld->close();

    // Fetch the SBB article number for the "old" ABB Ident Nr
    $sbbArticleOld = '';
    if (!empty($ABBIdentNrOld)) {
        $querySbbOld = "SELECT `SBB_Art_Nr` FROM `kompatibilität` WHERE `ABB_Ident_Nr` = ?";
        $stmtSbbOld = $mysqli->prepare($querySbbOld);
        $stmtSbbOld->bind_param("s", $ABBIdentNrOld);
        $stmtSbbOld->execute();
        $stmtSbbOld->bind_result($sbbArticleOld);
        $stmtSbbOld->fetch();
        $stmtSbbOld->close();
    }

    // Fetch the SBB article number for the "new" ABB Ident Nr
    $sbbArticleNew = '';
    if (!empty($ABBIdentNrNew)) {
        $querySbbNew = "SELECT `SBB_Art_Nr` FROM `kompatibilität` WHERE `ABB_Ident_Nr` = ?";
        $stmtSbbNew = $mysqli->prepare($querySbbNew);
        $stmtSbbNew->bind_param("s", $ABBIdentNrNew);
        $stmtSbbNew->execute();
        $stmtSbbNew->bind_result($sbbArticleNew);
        $stmtSbbNew->fetch();
        $stmtSbbNew->close();
    }
    $AusgebuchtValue = 0;  // Assuming it's always set to 1 when confirming

    // Insert the values into the logistik table
    $insertQuery = "INSERT INTO `logistik` 
                    (`Zugnummer`, `Stromrichter`, `Auftragsnummer`, `Meldungsnummer`, `Ticket Nr`, 
                    `ABB Ident Nr (altes Bauteil)`, `Serien Nr (altes Bauteil)`, `SBB Art Nr (altes Bauteil)`, 
                    `ABB Ident Nr (neues Bauteil)`, `Serien Nr (neues Bauteil)`, `SBB Art Nr (neues Bauteil)`, `Ausgebucht`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $mysqli->prepare($insertQuery);
    $insertStmt->bind_param("ssssssssssss", $Zugnummer, $Stromrichter, $Auftragsnummer, $Meldungsnummer, $TicketNr,
                            $ABBIdentNrOld, $SerienNrOld, $sbbArticleOld, $ABBIdentNrNew, $SerienNrNew, $sbbArticleNew, $AusgebuchtValue);
    $insertStmt->execute();
    $insertStmt->close();

    // Close the database connection
    $mysqli->close();

    return true;
}



?>