<?php
require 'functionsnew.php';
$Zugsuebersicht=[];
if(isset($_POST['ZugsuebersichtButton'])){
    $Zugsuebersicht = zugsuebersicht();
}
$selectedBauteil='';

if (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter']) && !isset($_POST['Auftragsnr'], $_POST['Meldungsnr'], $_POST['TicketNr'])) {
    $verbauteTeile = verbauteTeile($_POST['Fahrzeugnummer'], $_POST['Stromrichter']);
    //echo "<script>console.log('Fetched verbauteTeile: " . $verbauteTeile . "' );</script>";
    // Log the information
    //error_log("Fetched verbauteTeile: " . print_r($verbauteTeile, true));
}

if (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['IdentNr']) && !isset($_POST['Auftragsnr'], $_POST['Meldungsnr'], $_POST['TicketNr'])) {
    $vorgeschlageneTeile = vorgeschlageneTeile($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['IdentNr']);
}

if (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['IdentNr'], $_POST['SBBArtNr'], $_POST['BauteilCheckliste']) && !isset($_POST['Auftragsnr'], $_POST['Meldungsnr'], $_POST['TicketNr'])) {
    $checkliste = checklisteErstellen($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['IdentNr'], $_POST['SBBArtNr'], $_POST['BauteilCheckliste']);

    //print_r($checkliste);
}

if (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['ABBIdentNrOld'], $_POST['SerienNrOld'], $_POST['SBBArtNrNrOld'], $_POST['IdentNrNew'], $_POST['SBBArtNrNew'], $_POST['Auftragsnr'], $_POST['Meldungsnr'], $_POST['TicketNr'])){



}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
            transition: margin-left 0.5s;
        }

        .container {            
            display: flex;
            flex-grow: 1;
        }

        .sidebar {
            width: 80px;
            background-color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar-button {
            margin-top: 10px;
            font-size: 16px;
            width: 64px;
            height: 64px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        

        .content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: #ddd;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-left {
            display: flex;
            align-items: left;
        }

        .topbar-right {
            display: flex;
            align-items: right;
        }

        .topbar-button {
            font-size: 16px;
            width: 64px;
            height: 64px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .topbar-text {
            font-weight: bold;
            margin-right: 20px;
            margin-top: 22px;
        }

        .settings-button {
            background-image: url('zahnrad.png');
            background-size: 80%;
            background-repeat: no-repeat;
            background-position: center;
            font-size: 16px;
            width: 64px;
            height: 64px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: none;
            border-radius: 3px; /* Adjust the value as needed for rounded corners */
            border: 1px solid #767676; /* Set the border color */
            background-color: #ccc;
        }
        
        .main-content {
            flex-grow: 1;
            padding: 20px;
            padding-left: 30px;

        }

        .expanded-sidebar {
            background-color: #ccc;
            padding-top: 32.625px;
            overflow: hidden;
            width: 0;
            transition:  0.5s;
            visibility: hidden;
        }

        .expanded-sidebar.active {
            background-color: #ccc;
            padding-top: 32.625px;
            overflow: hidden;
            transition:  0.5s;
            width: 200px; /* Adjust the value as needed */
            visibility: visible;
        }

        .expanded-text {
            margin-top: 0px; /* Adjust the value as needed */
            font-size: 16px;
            padding-left: 30px;
            color: #333;
            font-weight: bold;
            margin-bottom: 55.65px;  /*Adjust the value as needed */
        }

        #ZugsuebersichtButton {
            background-image: url('train.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            
            /* Additional styles to reset default styles and remove click effect */
            box-shadow: none;
            border-radius: 3px; /* Adjust the value as needed for rounded corners */
            border: 1px solid #767676; /* Set the border color */
            padding: 0; /* Reset padding to avoid extra space around the button */
        }


        .sidebar-button:nth-child(3) {
            background-image: url('plus-sign.png');
            background-size: 70%;
            background-repeat: no-repeat;
            background-position: center;
            
            /* Additional styles to reset default styles and remove click effect */
            box-shadow: none;
            border-radius: 3px; /* Adjust the value as needed for rounded corners */
            border: 1px solid #767676; /* Set the border color */
        }

        .sidebar-button:nth-child(4) {
            background-image: url('document.png');
            background-size: 70%;
            background-repeat: no-repeat;
            background-position: center;
            
            /* Additional styles to reset default styles and remove click effect */
            box-shadow: none;
            border-radius: 3px; /* Adjust the value as needed for rounded corners*/
            border: 1px solid #767676; /* Set the border color*/
        }

        .sidebar-button:nth-child(5) {
            background-image: url('palette.png');
            background-size: 90%;
            background-repeat: no-repeat;
            background-position: center top -5px; /* Move the background image up by 10 pixels */

            /* Additional styles to reset default styles and remove click effect */
            box-shadow: none;
            border-radius: 3px; /* Adjust the value as needed for rounded corners */
            border: 1px solid #767676; /* Set the border color */
        }  

        .sidebar-button:nth-child(6) {
            background-image: url('kompatibilität.png');
            background-size: 80%;
            background-repeat: no-repeat;
            background-position: center ; /* Move the background image up by 10 pixels */

            /* Additional styles to reset default styles and remove click effect */
            box-shadow: none;
            border-radius: 3px; /* Adjust the value as needed for rounded corners */
            border: 1px solid #767676; /* Set the border color */
        }  

        .sidebar-button:nth-child(7) {
            background-image: url('profile.png');
            background-size: 80%;
            background-repeat: no-repeat;
            background-position: center ; /* Move the background image up by 10 pixels */

            /* Additional styles to reset default styles and remove click effect */
            box-shadow: none;
            border-radius: 3px; /* Adjust the value as needed for rounded corners */
            border: 1px solid #767676; /* Set the border color */
        }  


        .topbar-button {
            background-image: url('homeicon.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            
            /* Additional styles to reset default styles and remove click effect */
            box-shadow: none;
            border-radius: 3px; /* Adjust the value as needed for rounded corners */
            border: 1px solid #767676; /* Set the border color */
            background-color: #ccc;
        }

        .sidebar-button {
            border-radius: 3px; /* Adjust the value as needed for rounded corners */
            border: 1px solid #767676; /* Set the border color */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Even row background color */
        }
        

        .main-content table {
            padding-left: 100px;
            border-collapse: collapse;
            width: 87%; /* Adjust the width as needed */
            margin-top: 10px;
            border: 1px solid #ddd;
        }


        .main-content table .EingebauteTeileComponent {
            padding: 12px;
            width: 16.9%;  
            
        }
        
        .main-content table .EingebauteTeileIdentNr{
            width: 15%;  
            padding-right:0px;

            

        }
        .main-content table .EingebauteTeileSerienNr{
            width: 18.3%;  
            padding-right:0px;

            

        }
        .main-content table .VorgeschlageneTeileIdentNr {
            padding: 12px;
            width: 16.9%;  
            
        }

        .main-content table .VorgeschlageneTeileSBBArtNr {
            padding: 12px;
            width: 16.9%;  
            
        }
        .main-content th,
        .main-content td {
            
            text-align: left;
            padding: 12px; /* Adjust the padding as needed */
            font-size: 20px; /* Adjust the font size as needed */
        }


        .main-content th {
            
            background-color: #f2f2f2;
        }


        .main-content tr:nth-child(odd) {
            background-color: #dcdcdc; /* Adjust the color as needed */
        }

        .topbar-middle th,
        .topbar-middle td {
            text-align: left;
            padding: 12px;
            font-size: 22px; 
        }

        .main-content .EingebauteTeile th,
        .main-content .EingebauteTeile td {
            margin-right:100px;
            
        }
        
        .main-content .VorgeschlageneTeile th,
        .main-content .VorgeschlageneTeile td {
            margin-right:100px;
            
        }


        .topbar-middle .fahrzeug-header {
            text-align: left;
            padding-right: 45px;
            font-size: 22px; /* Adjust the font size as needed */
        }

        .topbar-middle .stromrichter-header{
            text-align: left;
            border-right: 10px;
            margin-left: 10px; /* Adjust the padding as needed for the Stromrichter column */
            font-size: 22px; /* Adjust the font size as needed */
        }

        .topbar-middle .VorgeschlageneTeileSBBArtNr-header{
            text-align: left;
            /*padding-left: 150px;*/
            font-size: 22px; /* Adjust the font size as needed */
        }

        .topbar-middle .VorgeschlageneTeileidentNr-header{
            text-align: left;
            width: 51.5%;
            font-size: 22px; /* Adjust the font size as needed */
        }

        .topbar-middle {

            display: flex;
            flex-grow: 0.9; 
            padding-left: 0px;
        }
        
        .topbar-middle .EingebauteTeile{
            width: 97.75%;
            margin-left: 3px;
            
        }

        .topbar-middle .bauteil-header{
            background-color: #f2f2f2;
            text-align: left;
            padding-right: 100px;
            font-size: 22px; /* Adjust the font size as needed */
        }
        .topbar-middle .identNr-header{
            background-color: #f2f2f2;
            text-align: left;
            padding-left: 12px;
            padding-right: 90px;
            font-size: 22px; /* Adjust the font size as needed */
        }
        .topbar-middle .serienNr-header{
            background-color: #f2f2f2;
            text-align: left;
            padding-right: 0px;
            font-size: 22px; /* Adjust the font size as needed */
        }
        .topbar-middle .fahrzeugnummer-header{
            background-color: #f2f2f2;
            text-align: right;   
            padding-right: 12px;
            padding-left: 0px;

            font-size: 22px; /* Adjust the font size as needed */
        }
        
        
        
        .topbar-middle table {
            border-collapse: collapse;
            width: 100%;
            /*padding-top: 10px;*/
            border: 1px solid #ddd;
        }
        
        

        .topbar-middle th {
            background-color: #f2f2f2;
        }
        /*
        .topbar-middle tr:nth-child(even) {
            background-color: #dcdcdc; 
        }*/
        

        .main-content .ChecklisteSubmitTable{
            width: 88.9%;
        }

        .ChecklisteSubmitTable input[type="text"],
        .ChecklisteSubmitTable input[type="submit"] {
            border: none;
            font-size: 16px;
            padding: 12px 15px;
            margin: 8px 0;
            width: 100%;
        }

        .ChecklisteSubmitTable input[type="text"] {
            box-sizing: border-box;
        }

        .ChecklisteSubmitTable input[type="submit"] {
            background-color: #f2f2f2;
            color: black;
            cursor: pointer;
        }

        .ChecklisteSubmitTable input[type="submit"]:hover {
            background-color: #f2f2f2;
        }

        .topbar-middle .Zugsübersicht{
            margin-left:0px;
            padding-left:0px;

        }

        

    </style>
    <script>
        let selectedBauteil = 'asfd';
        function expandSidebar() {

            const body = document.body;
            const expandedSidebar = document.querySelector('.expanded-sidebar');

            body.classList.toggle("sidebar-expanded");
            expandedSidebar.classList.toggle("active", body.classList.contains("sidebar-expanded"));
        }
        

        document.addEventListener("DOMContentLoaded", function () {
        const rows = document.querySelectorAll('.main-content .Zugsübersicht tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function () {
                    const zugnummer = row.cells[0].innerText;
                    const stromrichter = row.cells[1].innerText;

                    // Create a form element
                    const form = document.createElement('form');

                    // Set form attributes
                    form.action = ''; // Set your server-side script URL here
                    form.method = 'post';

                    // Create input elements for Fahrzeugnummer and Stromrichter
                    const inputZugnummer = document.createElement('input');
                    inputZugnummer.type = 'hidden';
                    inputZugnummer.name = 'Fahrzeugnummer';
                    inputZugnummer.value = zugnummer;

                    const inputStromrichter = document.createElement('input');
                    inputStromrichter.type = 'hidden';
                    inputStromrichter.name = 'Stromrichter';
                    inputStromrichter.value = stromrichter;

                    // Append the input elements to the form
                    form.appendChild(inputZugnummer);
                    form.appendChild(inputStromrichter);

                    // Append the form to the document body
                    document.body.appendChild(form);

                    // Submit the form
                    form.submit();
                });
            });
        });
        
        
        <?php $Fahrzeugnummer = isset($_POST['Fahrzeugnummer']) ? $_POST['Fahrzeugnummer'] : '';?>
        <?php $Stromrichter = isset($_POST['Stromrichter']) ? $_POST['Stromrichter'] : '';?>

        document.addEventListener("DOMContentLoaded", function () {
        const rows = document.querySelectorAll('.main-content .EingebauteTeile tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function () {
                    BauteilCheckliste = row.cells[0].innerText;
                    const IdentNr = row.cells[1].innerText;


                    // Create a form element
                    const form = document.createElement('form');

                    // Set form attributes
                    form.action = ''; // Set your server-side script URL here
                    form.method = 'post';

                    // Create input elements for Fahrzeugnummer and Stromrichter
                    const inputZugnummer = document.createElement('input');
                    inputZugnummer.type = 'hidden';
                    inputZugnummer.name = 'Fahrzeugnummer';
                    inputZugnummer.value = '<?php echo $Fahrzeugnummer; ?>';

                    const inputStromrichter = document.createElement('input');
                    inputStromrichter.type = 'hidden';
                    inputStromrichter.name = 'Stromrichter';
                    inputStromrichter.value = '<?php echo $Stromrichter; ?>';

                    const inputIdentNr = document.createElement('input');
                    inputIdentNr.type = 'hidden';
                    inputIdentNr.name = 'IdentNr';
                    inputIdentNr.value = IdentNr;

                    const inputBauteilCheckliste = document.createElement('input');
                    inputBauteilCheckliste.type = 'hidden';
                    inputBauteilCheckliste.name = 'BauteilCheckliste';
                    inputBauteilCheckliste.value = BauteilCheckliste;

                    // Append the input elements to the form
                    form.appendChild(inputZugnummer);
                    form.appendChild(inputStromrichter);
                    form.appendChild(inputIdentNr);
                    form.appendChild(inputBauteilCheckliste);


                    // Append the form to the document body
                    document.body.appendChild(form);

                    // Submit the form
                    form.submit();
                });
            });
        });



        <?php $Fahrzeugnummer = isset($_POST['Fahrzeugnummer']) ? $_POST['Fahrzeugnummer'] : '';?>
        <?php $Stromrichter = isset($_POST['Stromrichter']) ? $_POST['Stromrichter'] : '';?>
        <?php $BauteilCheckliste = isset($_POST['BauteilCheckliste']) ? $_POST['BauteilCheckliste'] : '';?>

        document.addEventListener("DOMContentLoaded", function () {
        const rows = document.querySelectorAll('.main-content .VorgeschlageneTeile tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function () {
                    const IdentNr = row.cells[0].innerText;
                    const SBBArtNr = row.cells[1].innerText;
                    // Create a form element
                    const form = document.createElement('form');

                    // Set form attributes
                    form.action = ''; // Set your server-side script URL here
                    form.method = 'post';

                    // Create input elements for Fahrzeugnummer and Stromrichter
                    const inputZugnummer = document.createElement('input');
                    inputZugnummer.type = 'hidden';
                    inputZugnummer.name = 'Fahrzeugnummer';
                    inputZugnummer.value = '<?php echo $Fahrzeugnummer; ?>';

                    const inputStromrichter = document.createElement('input');
                    inputStromrichter.type = 'hidden';
                    inputStromrichter.name = 'Stromrichter';
                    inputStromrichter.value = '<?php echo $Stromrichter; ?>';

                    const inputIdentNr = document.createElement('input');
                    inputIdentNr.type = 'hidden';
                    inputIdentNr.name = 'IdentNr';
                    inputIdentNr.value = IdentNr;

                    const inputSBBArtNr = document.createElement('input');
                    inputSBBArtNr.type = 'hidden';
                    inputSBBArtNr.name = 'SBBArtNr';
                    inputSBBArtNr.value = SBBArtNr;

                    const inputBauteilCheckliste = document.createElement('input');
                    inputBauteilCheckliste.type = 'hidden';
                    inputBauteilCheckliste.name = 'BauteilCheckliste';
                    inputBauteilCheckliste.value = '<?php echo $BauteilCheckliste; ?>';

                    // Append the input elements to the form
                    form.appendChild(inputZugnummer);
                    form.appendChild(inputStromrichter);
                    form.appendChild(inputIdentNr);
                    form.appendChild(inputSBBArtNr);
                    form.appendChild(inputBauteilCheckliste);




                    // Append the form to the document body
                    document.body.appendChild(form);

                    // Submit the form
                    form.submit();
                });
            });
        });



    </script>
    <title>Stromrichter Tool</title>
</head>
<body>
    <!-- ... Your existing HTML code ... -->

    <div class="topbar">
        <div class="topbar-left">
            <button class="topbar-button"></button>
        </div>

        <div class="topbar-middle">
            <?php if (isset($_POST['ZugsuebersichtButton'])): ?>
                <table class="Zugsübersicht" id="Zugsübersicht">
                    <thead>
                        <tr>
                            <th class="fahrzeug-header">Fahrzeugnummer</th>
                            <th class="stromrichter-header">Stromrichter</th>
                        </tr>
                    </thead>
                </table>
            <?php elseif (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter']) && !isset($_POST['IdentNr'])): ?>
                <?php   $Fahrzeugnummer = isset($_POST['Fahrzeugnummer']) ? $_POST['Fahrzeugnummer'] : '';?>
                <table class="EingebauteTeile" id="EingebauteTeile">
                    <thead>
                        <tr>
                            <th class="bauteil-header">Bauteil</th>
                            <th class="identNr-header">Ident Nr.</th>
                            <th class="serienNr-header">Serien Nr.</th>
                            <th class="fahrzeugnummer-header"><?php echo $Fahrzeugnummer; ?></th>
                        </tr>
                    </thead>
                </table>
            <?php elseif (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['IdentNr']) && !isset($_POST['SBBArtNr'], $_POST['BauteilCheckliste'])): ?>
                <?php   $Fahrzeugnummer = isset($_POST['Fahrzeugnummer']) ? $_POST['Fahrzeugnummer'] : '';?>
                <table class="VorgeschlageneTeile" id="VorgeschlageneTeile">
                    <thead>
                        <tr>
                            <th class="VorgeschlageneTeileidentNr-header">Ident Nr.</th>
                            <th class="VorgeschlageneTeileSBBArtNr-header">SBB Artikel Nr.</th>
                            <th class="VorgeschlageneTeilefahrzeugnummer-header"><?php echo $Fahrzeugnummer; ?></th>
                        </tr>
                    </thead>
                </table>
            <?php elseif (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['IdentNr'], $_POST['SBBArtNr'], $_POST['BauteilCheckliste'])): ?>
                <?php   $Fahrzeugnummer = isset($_POST['Fahrzeugnummer']) ? $_POST['Fahrzeugnummer'] : '';?>
                <table class="ChecklisteSubmitHeader" id="ChecklisteSubmitHeader">
                    <thead>
                        <tr>
                            <th class="ChecklisteSubmitAuftrags_Nr-header">Auftragsnr.</th>
                            <th class="ChecklisteSubmitMeldungs_Nr-header">Meldungsnr.</th>
                            <th class="ChecklisteSubmitTicket_Nr-header">Ticket Nr.</th>
                            <th class="ChecklisteSubmitSerien_Nr-header">Serien Nr.</th>
                            <th class="ChecklisteSubmitfahrzeugnummer-header"><?php echo $Fahrzeugnummer; ?></th>
                        </tr>
                    </thead>
                </table>
            <?php endif; ?>
        </div>




        <div class="topbar-right">
            <div class="topbar-text">OWT</div>
            <button class="settings-button"></button>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <!-- Placeholder buttons, you can replace them with images later -->
            <button class="sidebar-button" name="expand-sidebar" id="expand-sidebar" onclick="expandSidebar()">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 5h16v1H4V5Zm0 14h16v1H4v-1Zm16-7H4v1h16v-1Z" fill="#000" stroke="#000" stroke-width="2"/>
                </svg>
            </button>
            <form action="" method="post">
                <button class="sidebar-button" type="submit" name="ZugsuebersichtButton" id="ZugsuebersichtButton"></button>
            </form>
            <button class="sidebar-button"></button>
            <button class="sidebar-button"></button>
            <button class="sidebar-button"></button>
            <button class="sidebar-button"></button>
            <button class="sidebar-button"></button>
        </div>
        <div class="expanded-sidebar">
            <div class="expanded-text">Menu</div>
            <div class="expanded-text">Zugsübersicht</div>
            <div class="expanded-text">Checkliste</div>
            <div class="expanded-text">Dispo</div>
            <div class="expanded-text">Logistik</div>
            <div class="expanded-text">Kompatibilität</div>
            <div class="expanded-text">Reparaturen</div>
        </div>
        <div class="content">
            <div class="main-content">
                <!-- Your main content goes here -->
                <?php if (isset($_POST['ZugsuebersichtButton'])): ?>
                    <table class="Zugsübersicht" id="Zugsübersicht">
                        <thead>
                        </thead>
                        <tbody>
                            <?php foreach ($Zugsuebersicht as $Zugsinformation): ?>
                                <tr>
                                    <td><?php echo $Zugsinformation['Fahrzeugnummer']; ?></td>
                                    <td><?php echo $Zugsinformation['Stromrichter']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php elseif (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter']) && !isset($_POST['IdentNr'])): ?>
                    <table class="EingebauteTeile">
                        <thead>
                        </thead>
                        <tbody>
                        <?php foreach ($verbauteTeile as $component => $data): ?>
                            <tr>
                                <td class="EingebauteTeileComponent"><?php echo $component; ?></td>
                                <td class="EingebauteTeileIdentNr"><?php echo isset($data[0]) ? $data[0] : ''; ?></td>
                                <td class="EingebauteTeileSerienNr"><?php echo isset($data[1]) ? $data[1] : ''; ?></td>
                            </tr>   
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php elseif (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['IdentNr']) && !isset($_POST['SBBArtNr'], $_POST['BauteilCheckliste'])): ?>
                    <table class="VorgeschlageneTeile">
                        <thead>
                        </thead>
                        <tbody>
                        <?php foreach ($vorgeschlageneTeile as $component => $data): ?>
                            <tr>
                                <td class="VorgeschlageneTeileIdentNr"><?php echo isset($data["ABB_IdentNr"]) ? $data["ABB_IdentNr"] : ''; ?></td>
                                <td class="VorgeschlageneTeileSBBArtNr"><?php echo isset($data["SBB_ArtNr"]) ? $data["SBB_ArtNr"] : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php elseif (isset($_POST['Fahrzeugnummer'], $_POST['Stromrichter'], $_POST['IdentNr'], $_POST['SBBArtNr'], $_POST['BauteilCheckliste'])): ?><?php
                    $Fahrzeugnummer = isset($_POST['Fahrzeugnummer']) ? $_POST['Fahrzeugnummer'] : '';?>
                    <form method="post" action="">
                        <input type="hidden" name="Fahrzeugnummer" value="<?php echo $checkliste['Fahrzeugnummer']; ?>">
                        <input type="hidden" name="Stromrichter" value="<?php echo $checkliste['Stromrichter']; ?>">
                        <input type="hidden" name="ABBIdentNrOld" value="<?php echo $checkliste['ABBIdentNrOld']; ?>">
                        <input type="hidden" name="SerienNrOld" value="<?php echo $checkliste['SerienNrOld']; ?>">
                        <input type="hidden" name="SBBArtNrNrOld" value="<?php echo $checkliste['SBBArtNrNrOld']; ?>">
                        <input type="hidden" name="IdentNrNew" value="<?php echo $checkliste['ABBIdentNrNew']; ?>">
                        <input type="hidden" name="SBBArtNrNew" value="<?php echo $checkliste['SBBArtNrNew']; ?>">

                        <table class="ChecklisteSubmitTable">
                            <tbody>
                                <tr>
                                    <td><input type="text" name="Auftragsnr" placeholder="Auftragsnr." class=ChecklisteAuftragsNr required>
                                    <td><input type="text" name="Meldungsnr" placeholder="Meldungsnr." class=ChecklisteMeldungsNr required>
                                    <td><input type="text" name="TicketNr" placeholder="Ticket Nr." class=ChecklisteTicketNr required>
                                    <td><input type="text" name="SerienNrNew" placeholder="Serien Nr." class=ChecklisteSerienNr>
                                    <td><input type="submit" value="Erstellen" class="ChecklisteSubmitButton">
                                </tr>
                            </tbody>
                        </table>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>

<!-- ... Your existing HTML code ... -->

</body>
</html>
        


