<?php include ("header.php") ?>
<?php

$error = false;
if ( isset($_POST['btn-activation']) ) {

       $actcode = trim($_POST['actcode']);
       $actcode = strip_tags($actcode);
       $actcode = htmlspecialchars($actcode);

        $search = mysqli_query($conn, "SELECT code, active FROM users WHERE code='".$actcode."' AND active='0'") or die(mysqli_error());
        $match  = mysqli_num_rows($search);

        if($match > 0){
            // We have a match, activate the account
            mysqli_query($conn, "UPDATE users SET active='1' WHERE code='".$actcode."' AND active='0'") or die(mysqli_error());

            header("Location: login.php");
            //echo 'Your account has been activated, you can now login';
        }else{
            // No match -> invalid url or account has already been activated.
            //echo 'The code entered is incorrect.';
            $error = true;
            $verError = "Activation code incorrect. Please Re-enter.";
        }

}
?>
    <!-- banner -->
    <div class="inside-banner">
        <div class="container">
            <span class="pull-right"><a href="#">Home</a> / Register</span>
            <h2>Register</h2>
        </div>
    </div>
    <!-- banner -->


<div class="container">

    <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

        <div class="col-md-12">

            <div class="form-group">
                <h2 class="">Account Verification.</h2>
            </div>

            <div class="form-group">
                <hr />
            </div>


            <div class="form-group">
                <label>Enter Code:</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="text" name="actcode" class="form-control" maxlength="50" value="" />
                </div>
                <span class="text-danger"><?php echo $verError; ?></span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-activation">Activate Account</button>
            </div>
        </form>
        </div>
    </div>

</body>
</html>

<?php ob_end_flush(); ?>