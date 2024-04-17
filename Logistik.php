<?php
require 'functions.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a button with the name "confirm" in your form
    if (isset($_POST['confirm'])) {
        // Perform the action to confirm the material (update the database, etc.)
        confirmMaterial($_POST['Zugnummer'], $_POST['Stromrichter'], $_POST['Auftragsnummer'], $_POST['Meldungsnummer'], $_POST['TicketNr'], $_POST['ABBIdentNrOld'], $_POST['SerienNrOld'], $_POST['ABBIdentNrNew'], $_POST['SerienNrNew']);
    }
}



// Fetch data from the logistik table
$logistikData = getLogistikData();

function getLogistikData() {
    $mysqli = connect();

    // Fetch all rows from the logistik table
    $query = "SELECT * FROM `logistik`";
    $result = $mysqli->query($query);

    // Check if there are rows
    if ($result->num_rows > 0) {
        // Fetch rows into an associative array
        $logistikData = $result->fetch_all(MYSQLI_ASSOC);
        return $logistikData;
    }

    // Close the database connection
    $mysqli->close();

    return [];
}

function confirmMaterial($Zugnummer, $Stromrichter, $Auftragsnummer, $Meldungsnummer, $TicketNr, $ABBIdentNrOld, $SerienNrOld, $ABBIdentNrNew, $SerienNrNew) {
    // Update the logistik table to confirm the material for a specific row
    $mysqli = connect();
    $updateQuery = "UPDATE `logistik` SET `Ausgebucht` = 1 WHERE `Auftragsnummer` = ? AND `Meldungsnummer` = ? AND `Ticket Nr` = ? AND `ABB Ident Nr (altes Bauteil)` = ? AND `Serien Nr (altes Bauteil)` = ? AND `ABB Ident Nr (neues Bauteil)` = ? AND `Serien Nr (neues Bauteil)` = ? AND `Zugnummer` = ? AND `Stromrichter` = ?";
    $updateStmt = $mysqli->prepare($updateQuery);
    $updateStmt->bind_param("sssssssss", $Auftragsnummer, $Meldungsnummer, $TicketNr, $ABBIdentNrOld, $SerienNrOld, $ABBIdentNrNew, $SerienNrNew, $Zugnummer, $Stromrichter);
    $updateStmt->execute();
    $updateStmt->close();
    $mysqli->close();
}



?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logistik Material Ausbuchen</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background-color: #f2f2f2;
        }

        .confirm-button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        .confirm-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>Logistik Material Ausbuchen</header>

        <table>
            <thead>
                <tr>
                    <th>Zugnummer</th>
                    <th>Stromrichter</th>
                    <th>Auftragsnummer</th>
                    <th>Meldungsnummer</th>
                    <th>Ticket Nr</th>
                    <th>ABB Ident Nr (altes Bauteil)</th>
                    <th>Serien Nr (altes Bauteil)</th>
                    <th>SBB Art Nr (altes Bauteil)</th>
                    <th>ABB Ident Nr (neues Bauteil)</th>
                    <th>Serien Nr (neues Bauteil)</th>
                    <th>SBB Art Nr (neues Bauteil)</th>
                    <th>Ausgebucht</th>
                    <th>Ausbuchen</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($logistikData as $row): ?>
                <tr>
                    <td><?php echo $row['Zugnummer']; ?></td>
                    <td><?php echo $row['Stromrichter']; ?></td>
                    <td><?php echo $row['Auftragsnummer']; ?></td>
                    <td><?php echo $row['Meldungsnummer']; ?></td>
                    <td><?php echo $row['Ticket Nr']; ?></td>
                    <td><?php echo $row['ABB Ident Nr (altes Bauteil)']; ?></td>
                    <td><?php echo $row['Serien Nr (altes Bauteil)']; ?></td>
                    <td><?php echo $row['SBB Art Nr (altes Bauteil)']; ?></td>
                    <td><?php echo $row['ABB Ident Nr (neues Bauteil)']; ?></td>
                    <td><?php echo $row['Serien Nr (neues Bauteil)']; ?></td>
                    <td><?php echo $row['SBB Art Nr (neues Bauteil)']; ?></td>
                    <td><?php echo $row['Ausgebucht']; ?></td>
                    <?php if ($row['Ausgebucht'] == 0): ?>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="Zugnummer" value="<?php echo $row['Zugnummer']; ?>">
                                <input type="hidden" name="Stromrichter" value="<?php echo $row['Stromrichter']; ?>">
                                <input type="hidden" name="Auftragsnummer" value="<?php echo $row['Auftragsnummer']; ?>">
                                <input type="hidden" name="Meldungsnummer" value="<?php echo $row['Meldungsnummer']; ?>">
                                <input type="hidden" name="TicketNr" value="<?php echo $row['Ticket Nr']; ?>">
                                <input type="hidden" name="ABBIdentNrOld" value="<?php echo $row['ABB Ident Nr (altes Bauteil)']; ?>">
                                <input type="hidden" name="SerienNrOld" value="<?php echo $row['Serien Nr (altes Bauteil)']; ?>">
                                <input type="hidden" name="ABBIdentNrNew" value="<?php echo $row['ABB Ident Nr (neues Bauteil)']; ?>">
                                <input type="hidden" name="SerienNrNew" value="<?php echo $row['Serien Nr (neues Bauteil)']; ?>">
                                <button class="confirm-button" type="submit" name="confirm">Ausbuchen</button>
                            </form>
                        </td>
                    <?php else: ?>
                        <td>Ausgebucht</td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</body>
</html>
