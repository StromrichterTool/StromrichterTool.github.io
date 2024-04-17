<?php
require "functions.php";

if(isset($_POST['KompatibilitätPrüfen'])){
    $KompatibilitätPrüfen = KompatibilitätPrüfen($_POST['Zugnummer'], $_POST['Stromrichter'], $_POST['Bauteil']);
    
    if (empty($KompatibilitätPrüfen)) {
        // No data found
        $KompatibilitätPrüfen = "Kein passendes Bauteil gefunden. Überprüfe die Eingabe.";
    } elseif (is_array($KompatibilitätPrüfen)) {
        // Data found, do something with $result['Kompatibilität']
        echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>';
        echo '<script>';
        echo '$(document).ready(function(){';
        echo '    $(".dropDown").slideDown(0);';
        echo '});';
        echo '</script>';
        //echo "Kompatibilität: ";
        //print_r($KompatibilitätPrüfen);
    }
}


/*        $('.dropDown').slideDown("slow");
*/
if(!isset($_SESSION['user'])){
    header("location: index.php");
    exit();
}
if(isset($_SESSION['user'])){
    $loadedBauteile= suggestBauteile();
    if ($loadedBauteile) {
        // Data found, do something with $result['Kompatibilität']
        //echo "loadedBauteile: ";
        //print_r($loadedBauteile);
    } else {    
        // No data found
        echo "Es ist ein Fehler aufgetreten. Versuche es später erneut.";
    }
} else {
    header("location: index.php");
    exit();

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Dropdown Menu</title>
    <style>
        body {
            background-color: #313233;
            font-family: Arial, sans-serif;
        }

        nav {
            width: 600px; /* Adjusted width */
            margin: 0 auto;
            margin-top: 100px; /* Adjusted margin-top */
        }

        .menu {
            background-color: #ff782e;
            border-radius: 20px; /* Adjusted border-radius */
            color: #fff;
            display: block;
            position: relative;
            font-size: 40px; /* Adjusted font-size */
            padding: 40px; /* Adjusted padding */
            transition: background 300ms ease;
            border-bottom: 6px solid #cc6025; /* Adjusted border thickness */
            margin-top: 4px; /* Adjusted margin-top */
        }


        .dropdownIcon {
            display: block;
            width: 48px; /* Adjusted width */
            margin-top: 4px; /* Adjusted margin-top */
            right: 0;
            float: right;
        }

        .menu:hover .dropdownIcon span {
            box-shadow: 0px 6px 10px 0px rgba(50, 50, 50, 0.3); /* Adjusted box shadow */
        }

        .menu:hover {
            cursor: pointer;
            background: #ff853a;
        }
        
        .dropDown {
            background: #DDDBE6;
            border-radius: 0 0 20px 20px ; /* Adjusted border-radius (0 for top left and top right) */
            text-align: center;
            margin: 0;
            padding-top: 30px;
            list-style: none;
            position: relative;
            margin-top: 0px; /* Adjusted margin-top */
            display: none;
            top: -20px;;
            z-index: -1; /* Set a negative z-index to place it behind the menu*/
        }
        /*       
        .dropDown {
        background: #f0f0f0;
        top border-radius: 10px;
        text-align: center;
        margin:0;
        padding:0;
        list-style:none;
        position: relative;
        margin-top:20px;
        display:none;
        z-index: 1;
        }*/


        
        /*.dropDown:before {
            content: "";
            position: absolute;
            border: 30px solid #f0f0f0; /* Adjusted border thickness */
            /*border-top: 0 solid transparent !important;
            border-right: 30px solid transparent !important;
            border-left: 30px solid transparent !important;
            right: 20px; /* Adjusted right position */
            /*top: -30px; /* Adjusted top position 
        }*/

        .menu form {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 20px; /* Adjust the font size as needed */

        }

        .menu h1, .menu span {
            text-align: center;
            font-size: 24x; /* Adjust the font size as needed */
            margin-top: -15px;


        }

        .menu span {
            display: inline-block;
            width: 100%;
            margin-bottom: 10px; /* Adjust the margin as needed */
            font-size: 14px;
        }

        .menu input {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0;
            background-color: #DDDBE6;
            border: none;
            font-size: 10px;
        }

        .menu button {
            width: 100%;
            border-radius: 20px;
            border: 1px solid #FF4B2B;
            background-color: #FF4B2B;
            color: #FFFFFF;
            font-size: 14px;
            font-weight: bold;
            padding: 12px 0;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
            margin-top: 10px;
        }
        
        #suggestionsContainer {
            position: relative;
        }

        .suggestions {
            position: absolute;
            width: 100%;
            border: 1px solid #ccc;
            max-height: 100px;
            overflow-y: auto;
            background: white;
            box-shadow: 0px 6px 10px 0px rgba(50, 50, 50, 0.3);
            display: none;
        }
        .suggestion {
            padding: 1px;
            font-size: 12px;
            border: 1px solid #ddd; /* Adjust border color as needed */
            cursor: pointer;
            color: #000 !important; /* Set the text color to black, adjust as needed */
        }

        .suggestion:hover {
            background-color: #f5f5f5; /* Adjust background color on hover as needed */
        }
        .dropDown li a {
        text-decoration: none;
        color: #000; /* Set the desired text color */
    }
    </style>
</head>
<body>

<nav>
    <div class="menu">
        <form action="" method="post">
            <h1>Kompatibilität prüfen</h1>
            <span>Gib die Zugdaten und das Bauteil ein und überprüfe die Kompatibilität</span>
            <input type="text" name="Zugnummer" placeholder="Zugnummer" value="<?php echo @$_POST['Zugnummer']; ?>" required autocomplete="off">
            <input type="text" name="Stromrichter" placeholder="Stromrichter" value="<?php echo @$_POST['Stromrichter']; ?>" required autocomplete="off">
            <input type="text" id="bauteilInput" name="Bauteil" placeholder="Bauteil" value="<?php echo @$_POST['Bauteil']; ?>" oninput="showSuggestions()" required autocomplete="off">
            <div id="suggestionsContainer" class="suggestions"></div>
            <button type="submit" id="KompatibilitätPrüfen" name="KompatibilitätPrüfen">Kompatibilität prüfen</button>
            <?php 
                if (isset($KompatibilitätPrüfen) && !is_array($KompatibilitätPrüfen)):
            ?>
            <p class="error" style="color: red; font-size: 18px;">
                <?php echo $KompatibilitätPrüfen; ?>
            </p>
            <?php endif; ?>
        </form>
    </div>
    <style>
        .compatibility-table {
            width: 100%;
            margin-bottom: 10px;
            margin-left: -20px; /* Adjust the left margin as needed */
            table-layout: fixed;
        }

        .compatibility-table th,
        .compatibility-table td {
            padding: 6px; /* Increase the padding for spacing */
            text-align: left;
            font-size: 16px;
        }

        .compatibility-table th {
            background-color: #f2f2f2;
        }
    </style>


    <ul class="dropDown">
        <?php
            // Check if $KompatibilitätPrüfen is an array
            if (is_array($KompatibilitätPrüfen)) {
                // Loop through the data and generate list items
                foreach ($KompatibilitätPrüfen as $index => $item) {
                    echo '<li>';
                    echo '<div class="dropdown-content">';
                    echo '<table class="compatibility-table">';
                    echo '<thead>';

                    // Display the header row only for the first item
                    if ($index === 0) {
                        echo '<tr>';
                        echo '<th>Baugruppe</th>';
                        echo '<th>ABB IdentNr</th>';
                        echo '<th>SBB Art Nr</th>';
                        echo '</tr>';
                    }

                    echo '</thead>';
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td>' . $item['Baugruppe'] . '</td>';
                    echo '<td>' . $item['ABB_IdentNr'] . '</td>';
                    echo '<td>' . $item['SBB_Art_Nr'] . '</td>';
                    echo '</tr>';
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    echo '</li>';
                }
            }
        ?>
    </ul>




</nav>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var bauteilSuggestions = <?php echo json_encode(suggestBauteile()); ?>;

    function showSuggestions() {
        var input = document.getElementById("bauteilInput").value.toLowerCase();
        var suggestionsContainer = document.getElementById("suggestionsContainer");

        // Clear previous suggestions
        suggestionsContainer.innerHTML = "";

        // Filter suggestions based on input
        var filteredSuggestions = bauteilSuggestions.filter(function (bauteil) {
            return bauteil.toLowerCase().includes(input);
        });

        // Display suggestions
        if (filteredSuggestions.length > 0) {   
            suggestionsContainer.style.display = "block";
            filteredSuggestions.forEach(function (bauteil) {
                var suggestionDiv = document.createElement("div");
                suggestionDiv.className = "suggestion";
                suggestionDiv.innerHTML = bauteil;
                suggestionDiv.onclick = function () {
                    document.getElementById("bauteilInput").value = bauteil;
                    suggestionsContainer.style.display = "none";
                };
                suggestionsContainer.appendChild(suggestionDiv);
            });
        } else {
            suggestionsContainer.style.display = "none";
        }
    }
    const KompatibilitätPrüfenButton = document.getElementById('KompatibilitätPrüfen');
    KompatibilitätPrüfenButton.addEventListener('click', function (event) {
        // Prevent the form from submitting for testing purposes
        //event.preventDefault();
        // Show or hide the dropdown based on your requirements
        //$('.dropDown').slideDown("slow");
    });


</script>




</body>
</html>