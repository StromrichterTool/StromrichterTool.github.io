<?php 
   require "functions.php";
   if(!isset($_SESSION['user'])){
      header("location: index.php");
      exit();
   }
 
   if(isset($_GET['logout'])){
      logoutUser();
   }
   
   if(isset($_GET['confirm-account-deletion'])){
      deleteAccount();
   }
?>
<h2>Hallo <?php echo $_SESSION["user"] ?></h2>
<h4>Account Seite</h4>
 
<a href="?logout">Abmelden</a>
 
<?php 
   if(isset($_GET['delete-account'])){
      ?>
         <p class="confirm-deletion">
            Bist du dir sicher, dass du deinen Account löschen willst?
            <a href="?confirm-account-deletion">Account löschen</a>
         </p>
      <?php
   }else{
      ?>
         <a href="?delete-account">Account löschen</a>
      <?php
   }
?>