<?php
require "functions.php";

if(isset($_POST['submitlogin'])){
  $responselogin = login($_POST['username'], $_POST['password']);
}
if(isset($_POST['submitregister'])){
	echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo '    document.getElementById("container").classList.add("right-panel-active-quick");';
    echo '});';
    echo '</script>';
	$responseregister = registerUser($_POST['email'], $_POST['username'], $_POST['password'], $_POST['confirm-password']);
  
  
}
if(isset($_SESSION['user'])){
	header("location: account.php");
	exit();
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrierung und Anmeldung</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,800">
  <style>

    
	@import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
	box-sizing: border-box;
}

body {
	background: #313233;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	font-family: 'Montserrat', sans-serif;
	height: 100vh;
	margin: -20px 0 50px;
}

h1 {
	font-weight: bold;
	margin: 0;
}

h2 {
	text-align: center;
}

p {
	font-size: 14px;
	font-weight: 100;
	line-height: 20px;
	letter-spacing: 0.5px;
	margin: 20px 0 30px;
}

span {
	font-size: 12px;
}

a {
	color: #333;
	font-size: 14px;
	text-decoration: none;
	margin: 15px 0;
}

button {
	border-radius: 20px;
	border: 1px solid #FF4B2B;
	background-color: #FF4B2B;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
	padding: 12px 45px;
	letter-spacing: 1px;
	text-transform: uppercase;
	transition: transform 80ms ease-in;
}

button:active {
	transform: scale(0.95);
}

button:focus {
	outline: none;
}

button.ghost {
	background-color: transparent;
	border-color: #FFFFFF;
}

form {
	background-color: #C8C6D7;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 50px;
	height: 100%;
	text-align: center;
}

input {
	border: none;
	padding: 12px 15px;
	margin: 8px 0;
	width: 100%;
}

.container {
	background-color: #C8C6D7;
	border-radius: 10px;
	box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
		0 10px 10px rgba(0,0,0,0.22);
	position: relative;
	overflow: hidden;
	width: 768px;
	max-width: 100%;
	min-height: 480px;
}

.form-container {
	position: absolute;
	top: 0;
	height: 100%;
	transition: all 0.6s ease-in-out;
}

.sign-in-container {
	left: 0;
	width: 50%;
	z-index: 2;
}

.container.right-panel-active .sign-in-container {
	transform: translateX(100%);
}
.container.right-panel-active-quick .sign-in-container {
	transform: translateX(100%);
}

.sign-up-container {
	left: 0;
	width: 50%;
	opacity: 0;
	z-index: 1;
}

.container.right-panel-active .sign-up-container {
	transform: translateX(100%);
	opacity: 1;
	z-index: 5;
	animation: show 0.6s;
}
.container.right-panel-active-quick .sign-up-container {
	transform: translateX(100%);
	opacity: 1;
	z-index: 5;
	animation: show 0.00000000000000006s;
}
@keyframes show {
	0%, 49.99% {
		opacity: 0;
		z-index: 1;
	}

	50%, 100% {
		opacity: 1;
		z-index: 5;
	}
}

.overlay-container {
	position: absolute;
	top: 0;
	left: 50%;
	width: 50%;
	height: 100%;
	overflow: hidden;
	transition: transform 0.6s ease-in-out;
	z-index: 100;
}

.container.right-panel-active .overlay-container{
	transform: translateX(-100%);
}

.container.right-panel-active-quick .overlay-container{
	transform: translateX(-100%);
}

.overlay {
	background: #FF416C;
	background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
	background: linear-gradient(to right, #FF4B2B, #FF416C);
	background-repeat: no-repeat;
	background-size: cover;
	background-position: 0 0;
	color: #FFFFFF;
	position: relative;
	left: -100%;
	height: 100%;
	width: 200%;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
	transform: translateX(50%);
}

.container.right-panel-active-quick .overlay {
	transform: translateX(50%);
}

.overlay-panel {
	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 40px;
	text-align: center;
	top: 0;
	height: 100%;
	width: 50%;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
}

.overlay-left {
	transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
	transform: translateX(0);
}

.container.right-panel-active-quick .overlay-left {
	transform: translateX(0);
}

.overlay-right {
	right: 0;
	transform: translateX(0);
}

.container.right-panel-active .overlay-right {
	transform: translateX(20%);
}

.container.right-panel-active-quick .overlay-right {
	transform: translateX(20%);
} 
</style>
 
</head>
<body>

      <div class="container" id="container">
    <h2>Stromrichter Tool</h2>
    <div class="container" id="container">
    	<div class="form-container sign-up-container">
    		<form action="" method="post">
    			<h1>Konto erstellen</h1>
    			<span>Gib deine Daten an, um ein Konto zu erstellen</span>
    			<input type="text" name="username" placeholder="E/U-Nummer" value="<?php echo @$_POST['username']; ?>"required>
    			<input type="text" name="email" placeholder="EMail" value="<?php echo @$_POST['email']; ?>"required>
    			<input type="text" name="password" placeholder="Passwort" value="<?php echo @$_POST['password']; ?>"required>
          		<input type="text" name="confirm-password" placeholder="Passwort bestätigen" value="<?php echo @$_POST['confirm-password']; ?>"required>
    			<button type="submit" id ="submitregister" name="submitregister">Registrieren</button>
          <p class="error" style="color: red;"><?php echo @$responseregister; ?></p>    		

    		</form>
    	</div>
    	<div class="form-container sign-in-container">
      <form action="" method="post" style="max-width: 300px; margin: 0 auto;">
    			<h1>Anmelden</h1>
    			<span>mit bestehenden Konto</span>
    			<input type="text" id="username" name="username" placeholder="E/U-Nummer" value="<?php echo @$_POST['username']; ?>" required>
    			<input type="password" id="password" name="password" placeholder="Passwort" value="<?php echo @$_POST['password']; ?>" required>
    			<a href="forgot-password.php">Passwort zurücksetzen</a>
          <button type="submit" name="submitlogin" >Anmelden</button>
          <p class="error" style="color: red;"><?php echo @$responselogin ; ?></p>   		
        </form>
    	</div>
    	<div class="overlay-container">
    		<div class="overlay">
    			<div class="overlay-panel overlay-left">
    				<h1>Registriere dich</h1>
    				<p>für das All in One Stromrichter Tool</p>
    				<button class="ghost" id="signIn">Anmelden</button>
    			</div>
    			<div class="overlay-panel overlay-right">
    				<h1>Hallo zurück</h1>
    				<p>zu dem All in One Stromrichter Tool</p>
    				<button class="ghost" id="signUp">Registrieren</button>
    			</div>
    		</div>
    	</div>
    </div>

  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('container');
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const submitregisterButton = document.getElementById('submitregister');


        signUpButton.addEventListener('click', function () {
			container.classList.remove("right-panel-active-quick");
            container.classList.add("right-panel-active");

    });
        signInButton.addEventListener('click', function () {
            container.classList.remove("right-panel-active");
			container.classList.remove("right-panel-active-quick");
        });
    });
  </script>


</body>
</html>



