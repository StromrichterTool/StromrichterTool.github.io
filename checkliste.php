<?php
require 'functions.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    /*$Auftragsnummer = $_POST['Auftragsnummer'];
    $Meldungsnummer = $_POST['Meldungsnummer'];
    $TicketNr = $_POST['TicketNr'];
    $altesBauteil = $_POST['Bauteil'];
    $abbIdentNrOld = $_POST['ABBIdentNrOld'];
    $serienNrOld = $_POST['SerienNrOld'];
    $abbIdentNrNew = $_POST['ABBIdentNrNew'];
    $serienNrNew = $_POST['SerienNrNew'];
    */

    // Update the information in the 'eingebaute_bauteile2' table
    $result = updateBauteileInfo($_POST['Zugnummer'], $_POST['Stromrichter'], $_POST['Auftragsnummer'], $_POST['Meldungsnummer'], $_POST['TicketNr'], $_POST['Bauteil'], $_POST['ABBIdentNrNew'], $_POST['SerienNrNew']);
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkliste</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .form-section {
            width: 48%;
            margin-bottom: 20px;
        }

        .form-section label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-section input,
        .form-section select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 16px;
        }

        .form-section button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .form-section button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>Checkliste</header>

        <div class="form-container">
            <form method="post" action="">
                <div class="form-section">
                    <label for="Zugnummer">Zugnummer</label>
                    <input type="text" id="Zugnummer" name="Zugnummer" placeholder="Zugnummer" value="<?php echo @$_POST['Zugnummer']; ?>"required>

                    <label for="Stromrichter">Stromrichter</label>
                    <input type="text" id="Stromrichter" name="Stromrichter" placeholder="Stromrichter" value="<?php echo @$_POST['Stromrichter']; ?>"required>

                    <label for="Auftragsnummer">Auftragsnummer</label>
                    <input type="text" id="Auftragsnummer" name="Auftragsnummer" placeholder="Auftragsnummer" value="<?php echo @$_POST['Auftragsnummer']; ?>"required>

                    <label for="Meldungsnummer">Meldungsnummer</label>
                    <input type="text" id="Meldungsnummer" name="Meldungsnummer" placeholder="Meldungsnummer" value="<?php echo @$_POST['Meldungsnummer']; ?>"required>

                    <label for="TicketNr">Ticket Nr</label>
                    <input type="text" id="TicketNr" name="TicketNr" placeholder="Ticket Nr" value="<?php echo @$_POST['TicketNr']; ?>"required>

                    <label for="Bauteil">Bauteil</label>
                    <input type="text" id="Bauteil" name="Bauteil" placeholder="Bauteil" value="<?php echo @$_POST['Bauteil']; ?>"required>

                    <label for="ABBIdentNrNew">ABB Ident Nr (neues Bauteil)</label>
                    <input type="text" id="ABBIdentNrNew" name="ABBIdentNrNew" placeholder="ABB Ident Nr (neues Bauteil)" value="<?php echo @$_POST['ABBIdentNrNew']; ?>"required>

                    <label for="SerienNrNew">Serien Nr (neues Bauteil)</label>
                    <input type="text" id="SerienNrNew" name="SerienNrNew" placeholder="Serien Nr (neues Bauteil)" value="<?php echo @$_POST['SerienNrNew']; ?>">

                    <button type="submit">Checkliste erstellen</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
