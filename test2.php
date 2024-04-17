<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAP Interface Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Ensuring the icons from Font Awesome are loaded */
        .fa {
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
        }

        /* Custom styles for this specific interface */
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #2d3748; /* Dark gray background */
        }

        /* Toolbar styles */
        .toolbar {
            background-color: #1a202c; /* Darker gray */
            color: white;
        }

        /* Content styles */
        .content {
            background-color: #2d3748; /* Dark gray */
        }

        /* Input and button styles */
        .input-field, .button, .dropdown, .search-bar {
            background-color: #2d3748; /* Dark gray */
            border: 1px solid #4a5568; /* Slightly lighter gray for borders */
            color: white;
        }

        /* Specific style adjustments */
        .search-bar {
            flex: 1;
            margin-left: 0.5rem;
        }

        .button {
            margin-left: 0.5rem;
        }

        .dropdown {
            margin-left: 0.5rem;
        }

        /* Footer styles */
        .footer {
            background-color: #4a5568; /* Medium gray */
        }

        /* Ensuring full height for flex container */
        .flex-grow {
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <div class="flex flex-col h-screen">
        <!-- Toolbar -->
        <div class="toolbar p-4 flex items-center text-sm">
            <i class="fas fa-bars mr-4"></i>
            <span>19.01.2024 / 06:00 - 17:00 Fahrzeug-Modul zu Master: 03755704</span>
            <span class="flex-grow"></span>
            <span>Gleis 117</span>
            <i class="fas fa-sync ml-4"></i>
            <i class="fas fa-cog ml-4"></i>
            <i class="fas fa-question-circle ml-4"></i>
        </div>

        <!-- Content -->
        <div class="content flex flex-col flex-1 p-4">
            <!-- Replace with actual content -->
            <div class="flex mb-4">
                <button class="button"><i class="fas fa-bars"></i></button>
                <button class="button"><i class="fas fa-th"></i></button>
                <div class="dropdown">
                    <!-- Dropdown content -->
                </div>
                <div class="search-bar p-2">
                    <input type="search" class="input-field p-2" placeholder="Fahrzeug">
                    <button class="button"><i class="fas fa-search"></i></button>
                </div>
                <div class="dropdown">
                    <!-- Dropdown content -->
                </div>
                <button class="button"><i class="fas fa-trash"></i></button>
                <button class="button"><i class="fas fa-sliders-h"></i></button>
            </div>
            <div class="flex-1 bg-blue-800">
                <!-- Main content area, now just a blue background for placeholder -->
            </div>
        </div>

        <!-- Footer -->
        <div class="footer p-4 flex items-center justify-between">
            <button class="button"><i class="fas fa-plus"></i></button>
            <div class="flex-grow"></div>
            <button class="button"><i class="fas fa-question-circle"></i></button>
        </div>
    </div>

    <script>
        // JavaScript can be added here to handle interactions
    </script>
</body>

</html>