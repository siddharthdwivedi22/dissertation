<?php include'header.php';?>

<?php

$error = false;

if( isset($_POST['btn-login']) ) {

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if(empty($pass)){
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {

        $password = hash('sha256', $pass); // password hashing using SHA256

        $res=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
        $row=mysqli_fetch_array($res);
        $count = mysqli_num_rows($res); // if email/pass correct it returns must be 1 row

        $search = mysqli_query($conn, "SELECT email, password FROM users WHERE active='0'") or die(mysqli_error());
        $match  = mysqli_num_rows($search);
        $row1 = mysqli_fetch_array($search);
        if( $count == 1 && $row['password']==$pass && $match== 0 ) {
            $_SESSION['user'] = $row['userID'];
            $res1=mysqli_query($conn,"SELECT * FROM users WHERE userID=".$_SESSION['user']);
            $userRow=mysqli_fetch_assoc($res1);
            $_SESSION['username'] = $userRow['firstName'];
            header("Location: home.php");
        }


        else if($match>0 && $row1['email'] == $email && $row1['password'] == $pass) {
           header("Location:verify.php");

        }
        else {
            $errMSG = "Incorrect Credentials, Try again...";
       }

    }

}
?>
    <!-- banner -->
    <div class="inside-banner">
        <div class="container">
            <span class="pull-right"><a href="#">Home</a> / Register</span>
            <h2>Login</h2>
        </div>
    </div>
    <!-- banner -->


    <div class="container">

        <div id="login-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

                <div class="col-md-12">

                    <div class="form-group">
                        <h2 class="">Sign In.</h2>
                    </div>

                    <div class="form-group">
                        <hr/>
                    </div>

                    <?php
                    if ( isset($errMSG) ) {

                        ?>
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <label>Enter email:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" maxlength="40" />
                        </div>
                        <span class="text-danger"><?php echo $emailError; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Enter Password:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" name="pass" class="form-control" maxlength="15" />
                        </div>
                        <span class="text-danger"><?php echo $passError; ?></span>
                    </div>

                    <div class="form-group">
                        <hr/>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
                    </div>

                    <div class="form-group">
                        <hr/>
                    </div>

                    <div class="form-group">
                        <a href="register.php">Sign Up Here...</a>
                    </div>

                </div>

            </form>
        </div>

    </div>

    <!-- Modal -->
    <div id="loginpop" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Sign Up</h2>
                </div>
                <div class="modal-body">
                    <a class="btn btn-block btn-social btn-facebook" href= "#">
                        <span class="fa fa-facebook"></span> Continue With Facebook
                    </a>
                    <p>OR</p>
                    <a href="register.php">Sign Up With Email.</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- /.modal -->

<?php include'footer.php';?>