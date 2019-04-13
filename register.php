<?php include'header.php';?>

<?php
require_once "recaptchalib.php";
$error = false;

if ( isset($_POST['btn-signup']) ) {

    // clean user inputs to prevent sql injections
    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $surname = trim($_POST['surname']);
    $surname = strip_tags($surname);
    $surname = htmlspecialchars($surname);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $captcha;
    if(isset($_POST['g-recaptcha-response']))
        $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha){
        $error = true;
        $captchaerror = "Please check the the captcha form.";
    }
    $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdqqhcUAAAAAB94vb2fbW3N2hs7YQFwR2BKCBYQ&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
    if($response['success'] == false)
    {
        $error = true;
        $captchaerror = "You are a spammer";
    }


    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $code = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < 5; $i++) {
        $code .= $characters[mt_rand(0, $max)];
    }

    // basic name validation
    if (empty($name)) {
        $error = true;
        $nameError = "Please enter your name.";
    }  else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $nameError = "Name must contain alphabets and space.";
    }

    if (empty($surname)) {
        $error = true;
        $surnameError = "Please enter your Surname.";
    }  else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $surnameError = "Surname must contain alphabets and space.";
    }


    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // check email exist or not
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);
        if($count!=0){
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }

    // password validation
    if (empty($pass)){
        $error = true;
        $passError = "Please enter password.";
    } else if(strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }

    // password encrypt using SHA256();
    $password = hash('sha256', $pass);

    //captcha validation


//    $to      = $email; // Send email to our user
//    $subject = 'Signup | Verification'; // Give the email a subject
//    $message = '
//
//Thanks for signing up!
//Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
//
//------------------------
//Username: '.$name.'
//Password: '.$pass.'
//------------------------
//
//Please type in the following verification code to Fully Sign Up: '.$code.'
//';
//
//    $headers = 'From:noreply@stuweb.cms.gre.ac.uk' . "\r\n"; // Set from headers

    // if there's no error, continue to signup
    if( !$error ) {

        $query = "INSERT INTO users(firstName,lastName,email,password,code) VALUES('$name','$surname','$email','$pass','$code')";
        $res = mysqli_query($conn, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully entered the details, please check your email for activation code";
            unset($name);
            unset($email);
            unset($pass);
            //mail($to, $subject, $message, $headers); // Send our email
            header("Location: verify.php");

        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }

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
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  enctype="multipart/form-data">

                <div class="col-md-12">

                    <div class="form-group">
                        <h2 class="">Sign Up.</h2>
                    </div>

                    <div class="form-group">
                        <hr/>
                    </div>

                    <?php
                    if ( isset($errMSG) ) {

                        ?>
                        <div class="form-group">
                            <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                                <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <label>Enter Name:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" name="name" class="form-control" maxlength="50" value="<?php echo $name ?>" />
                        </div>
                        <span class="text-danger"><?php echo $nameError; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Enter Surname:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" name="surname" class="form-control" maxlength="50" value="<?php echo $surname ?>" />
                        </div>
                        <span class="text-danger"><?php echo $surnameError; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Enter Email:</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input type="text" name="email" class="form-control" maxlength="40" value="<?php echo $email ?>" />
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
                        <div class="input-group">
                        <div class="g-recaptcha" data-sitekey="6LdqqhcUAAAAANJQOac4D0hI___bc97vfMVA5OyU"></div>
                            <span class="text-danger"><?php echo $captchaerror; ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <hr/>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
                    </div>

                    <div class="form-group">
                        <hr/>
                    </div>

                    <div class="form-group">
                        <a href="login.php">Sign in Here...</a>
                    </div>

                </div>

            </form>
        </div>

    </div>
<?php include'footer.php';?>