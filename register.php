<?php
require "functions.php";

if(isset($_POST['submit'])){
    $response = registerUser($_POST['email'], $_POST['username'], $_POST['password'], $_POST['confirm-password']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Include any additional CSS or styling here -->
</head>
<body>

    <h2>User Registration</h2>

    <form action="" method="post">
        <label>Email *</label>
        <input type="text" name="email" value="<?php echo @$_POST['email']; ?>">

        <label>Username *</label>
        <input type="text" name="username" value="<?php echo @$_POST['username']; ?>">

        <label>Password *</label>
        <input type="text" name="password" value="<?php echo @$_POST['password']; ?>">

        <label>Confirm Password *</label>
        <input type="text" name="confirm-password" value="<?php echo @$_POST['confirm-password']; ?>">

        <button type="submit" name="submit">Submit</button>

        <?php 
        if(isset($response)){
            if($response == "success"){
                ?>
                <p class="success">Your registration was successful</p>
                <?php
            } else {
                ?>
                <p class="error"><?php echo $response; ?></p>
                <?php
            }
        }
        ?>
    </form> <!-- end of register form -->

    <!-- Include any additional scripts or JS here -->

</body>
</html>
