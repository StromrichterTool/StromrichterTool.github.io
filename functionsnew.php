<?php 
require "config.php";
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';
require 'PHPMailer/PHPMailer/src/Exception.php';
function connect(){
   // MySQLi Objekt erstellen und verbinden mit gegebenen Parametern
   
   $mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
 
   // Nach Errors prüfen
   if($mysqli->connect_errno != 0){
      
      // Bei Errors Infos holen
      $error = $mysqli->connect_error;
 
      // Get the current date and time in 
      // a human-readable format.
      $error_date = date("F j, Y, g:i a");
 
      // Fehlermeldung erstellen
      $message = "{$error} | {$error_date} \r\n";
 
      // Fehlermeldung speichern
      file_put_contents("db-log.txt", $message, FILE_APPEND);
      
      // Return false to indicate a connection failure.
      return false;
   }else{
      // Bei erfolgreicher Verbingung utf8mb4 setzen
      $mysqli->set_charset("utf8mb4");
 
      // MySQLi Objekt zurücksenden
      
      return $mysqli;	
   }
}


function zugsuebersicht(){
    // Mit Datenbank verbinden
    $mysqli = connect();
    $Zugsuebersicht = [];
    
    // Zugnummer und Stromrichter Daten holen


    $stmt = $mysqli->prepare("SELECT Fahrzeugnummer, Stromrichter FROM eingebaute_bauteile");
    $stmt->execute();
    $result = $stmt->get_result();

    // Auf Duplikate prüfen, und anschliessend in Array hinzufügen

    while ($row = $result->fetch_assoc()) {
        $Zugsinformation = [
            'Fahrzeugnummer' => $row['Fahrzeugnummer'],
            'Stromrichter' => $row['Stromrichter'],
        ];
        
        // Check for duplicates before adding to the array
        if (!in_array($Zugsinformation, $Zugsuebersicht)) {
            $Zugsuebersicht[] = $Zugsinformation;
        }
    }

    //Statement schliessen
    $stmt->close();
    
    //Zugsübersicht als Antwort zurück schicken
    return $Zugsuebersicht;
}



/*function verbauteTeile($fahrzeugnummer, $stromrichter){
    $mysqli = connect();
    $verbauteTeile = [];

    $stmt = $mysqli->prepare("SELECT
    `Netzeingang -U10 Ident. Nr.`, 
    `Netzeingang -U10 Serie Nr.`, 
    `SKiiP ohne CB -U11 Ident. Nr.`, 
    `SKiiP ohne CB -U11 Serie Nr.`, 
    `SKiiP mit CB -U12 Ident. Nr.`, 
    `SKiiP mit CB -U12 Serie Nr.`, 
    `SKiiP mit CB -U13 Ident. Nr.`, 
    `SKiiP mit CB -U13 Serie Nr.`, 
    `SKiiP ohne CB -U14 Ident. Nr.`, 
    `SKiiP ohne CB -U14 Serie Nr.`, 
    `C-Bank -U21 Ident. Nr.`, 
    `C-Bank -U21 Serie Nr.`, 
    `C-Bank -U22 Ident. Nr.`, 
    `C-Bank -U22 Serie Nr.`, 
    `C-Bank -U23 Ident. Nr.`, 
    `C-Bank -U23 Serie Nr.`, 
    `C-Bank -U24 Ident. Nr.`, 
    `C-Bank -U24 Serie Nr.`, 
    `BL/HBU -U31 Ident. Nr.`, 
    `BL/HBU -U31 Serie Nr.`, 
    `WR-Filter -U32 Ident. Nr.`, 
    `WR-Filter -U32 Serie Nr.`, 
    `Lüfterbaugruppe -E522 Ident. Nr.`, 
    `Lüfterbaugruppe -E522 Serie Nr.`, 
    `Klemmenreihe +A100`, 
    `Relais Tripkreis -K561`, 
    `Relais Trenner schliessen -K562`, 
    `Schütz Trenner öffnen -K563`, 
    `Schütz Vorladeschutz -K564`, 
    `Schütz Trenner öffnen extern`, 
    `Speisegerät 24V +- 15V -U591 Ident. Nr.`, 
    `Speisegerät 24V +- 15V -U591 Serie Nr.`, 
    `PEBB Interface Quad -U61 Ident. Nr.`, 
    `PEBB Interface Quad -U61 Serie Nr.`, 
    `Combi I/O Basic -U55 Ident. Nr.`, 
    `Combi I/O Basic -U55 Serie Nr.`, 
    `CT/VT Module -U581 Ident. Nr.`, 
    `CT/VT Module -U581 Serie Nr.`, 
    `PEC AC800 -U150 Ident. Nr.`, 
    `PEC AC800 -U150 Serie Nr.` 
    FROM eingebaute_bauteile
    WHERE Fahrzeugnummer = ? AND Stromrichter = ?");

    if (!$stmt) {
        die("Error in statement: " . $mysqli->error);
    }

    $stmt->bind_param("ss", $fahrzeugnummer, $stromrichter);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch all rows as an associative array
    while ($row = $result->fetch_assoc()) {
        $verbauteTeile[] = $row;
    }

    $stmt->close();

    return $verbauteTeile;
}*/


function verbauteTeile($fahrzeugnummer, $stromrichter){
    $mysqli = connect();
    $verbauteTeile = [];

    $stmt = $mysqli->prepare("SELECT
    `Netzeingang -U10 Ident. Nr.`, 
    `Netzeingang -U10 Serie Nr.`, 
    `SKiiP ohne CB -U11 Ident. Nr.`, 
    `SKiiP ohne CB -U11 Serie Nr.`, 
    `SKiiP mit CB -U12 Ident. Nr.`, 
    `SKiiP mit CB -U12 Serie Nr.`, 
    `SKiiP mit CB -U13 Ident. Nr.`, 
    `SKiiP mit CB -U13 Serie Nr.`, 
    `SKiiP ohne CB -U14 Ident. Nr.`, 
    `SKiiP ohne CB -U14 Serie Nr.`, 
    `C-Bank -U21 Ident. Nr.`, 
    `C-Bank -U21 Serie Nr.`, 
    `C-Bank -U22 Ident. Nr.`, 
    `C-Bank -U22 Serie Nr.`, 
    `C-Bank -U23 Ident. Nr.`, 
    `C-Bank -U23 Serie Nr.`, 
    `C-Bank -U24 Ident. Nr.`, 
    `C-Bank -U24 Serie Nr.`, 
    `BL/HBU -U31 Ident. Nr.`, 
    `BL/HBU -U31 Serie Nr.`, 
    `WR-Filter -U32 Ident. Nr.`, 
    `WR-Filter -U32 Serie Nr.`, 
    `Lüfterbaugruppe -E522 Ident. Nr.`, 
    `Lüfterbaugruppe -E522 Serie Nr.`, 
    `Klemmenreihe +A100`, 
    `Relais Tripkreis -K561`, 
    `Relais Trenner schliessen -K562`, 
    `Schütz Trenner öffnen -K563`, 
    `Schütz Vorladeschutz -K564`, 
    `Schütz Trenner öffnen extern`, 
    `Speisegerät 24V +- 15V -U591 Ident. Nr.`, 
    `Speisegerät 24V +- 15V -U591 Serie Nr.`, 
    `PEBB Interface Quad -U61 Ident. Nr.`, 
    `PEBB Interface Quad -U61 Serie Nr.`, 
    `Combi I/O Basic -U55 Ident. Nr.`, 
    `Combi I/O Basic -U55 Serie Nr.`, 
    `CT/VT Module -U581 Ident. Nr.`, 
    `CT/VT Module -U581 Serie Nr.`, 
    `PEC AC800 -U150 Ident. Nr.`, 
    `PEC AC800 -U150 Serie Nr.` 
    FROM eingebaute_bauteile
    WHERE Fahrzeugnummer = ? AND Stromrichter = ?");

    if (!$stmt) {
        die("Error in statement: " . $mysqli->error);
    }

    $stmt->bind_param("ss", $fahrzeugnummer, $stromrichter);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch all rows as an associative array
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $key => $value) {
            $name = str_replace(array(" Ident. Nr.", " Serie Nr."), "", $key);
            $verbauteTeile[$name][] = $value;
        }
    }

    $stmt->close();

    return $verbauteTeile;
}




function getColumnName($data){
    $mysqli = connect();
    $bauteile = [];

    // Calculate the column number based on $data

    $columnNumber = (int)$data["Kompatibilität"] + 6;
    $fields = $mysqli->query("SELECT * FROM kompatibilität LIMIT 1")->fetch_fields();

    $columnName = $fields[$columnNumber - 1]->name;
    return $columnName;
}

function getKompatibilität($Zugnummer,$Stromrichter){
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

    $columnName = getColumnName($data);
    
    return $columnName;
    
    

}   

function vorgeschlageneTeile($fahrzeugnummer, $stromrichter, $bauteil){
    $columnName = getKompatibilität($fahrzeugnummer,$stromrichter);

    $mysqli = connect();
    $vorgeschlageneTeile = [];

    $stmt = $mysqli->prepare("SELECT DISTINCT ABB_Ident_Nr,  SBB_Art_Nr FROM kompatibilität WHERE Baugruppe = (SELECT Baugruppe FROM kompatibilität WHERE ABB_Ident_Nr = ?) AND $columnName ='True'");

    if (!$stmt) {
        die("Error in statement: " . $mysqli->error);
    }

    $stmt->bind_param("s", $bauteil);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch ABB_Ident_Nr values and add them to the array
    while ($row = $result->fetch_assoc()) {
        $vorgeschlageneTeileInfo=[
        'ABB_IdentNr' => $row['ABB_Ident_Nr'],
        'SBB_ArtNr' => $row['SBB_Art_Nr']];

        $vorgeschlageneTeile[] = $vorgeschlageneTeileInfo;
    }

    $stmt->close();

    return $vorgeschlageneTeile;
}





function checklisteErstellen($Fahrzeugnummer, $Stromrichter, $IdentNrNew, $SBBArtNrNew, $BauteilCheckliste){

    $mysqli = connect();
    $vorgeschlageneTeile = [];

    $queryOld = "SELECT `{$BauteilCheckliste} Ident. Nr.`, `{$BauteilCheckliste} Serie Nr.` FROM `eingebaute_bauteile` WHERE `Fahrzeugnummer` = ? AND `Stromrichter` = ?";
    $stmtOld = $mysqli->prepare($queryOld);
    $stmtOld->bind_param("ss", $Fahrzeugnummer, $Stromrichter);
    $stmtOld->execute();
    $stmtOld->bind_result($ABBIdentNrOld, $SerienNrOld);
    $stmtOld->fetch();
    $stmtOld->close();

    $queryOld = "SELECT `SBB_Art_Nr` FROM `kompatibilität` WHERE `ABB_Ident_Nr` = ? ";
    $stmtOld = $mysqli->prepare($queryOld);
    $stmtOld->bind_param("s", $ABBIdentNrOld);
    $stmtOld->execute();
    $stmtOld->bind_result($SBBArtNrNrOld);
    $stmtOld->fetch();
    $stmtOld->close();

    


    return array(
        'Fahrzeugnummer' => $Fahrzeugnummer,
        'Stromrichter' => $Stromrichter,
        'ABBIdentNrOld' => $ABBIdentNrOld,
        'SerienNrOld' => $SerienNrOld,
        'SBBArtNrNrOld' => $SBBArtNrNrOld,
        'ABBIdentNrNew' => $IdentNrNew,
        'SBBArtNrNew' => $SBBArtNrNew
    );
    
}






?>