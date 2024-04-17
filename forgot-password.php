<?php 
   require "functions.php";
   if(isset($_POST['submit'])){
      $response = passwordReset($_POST['email']);
   }
?>
<form action="" method="post">
   <label>Email</label>
   <input type="text" name="email" value="<?php echo @$_POST['email']; ?>">
   
   <button type="submit" name="submit">Submit</button>	
   <?php 
      if(@$response == "success"){
         ?>
            <p class="success">Please go to your email account and use your new password.</p>
         <?php
      }else{
         ?>
            <p class="error"><?php echo @$response; ?></p>
         <?php
      }
   ?>
</form>