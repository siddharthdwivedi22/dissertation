<?php include ("header.php") ?>

<?php
if( empty($_SESSION['user']) ){
    header("Location: login.php");
}
$error = false;

if ( isset($_POST['btn-Submit']) ) {

    $groupName = trim($_POST['groupName']);

    $uni = trim($_POST['uni']);

    $p = (isset($_POST['public']) && $_POST['public'] == 'private');

// basic validation
    if (empty($groupName)) {
        $error = true;
        $groupNameError = "Please enter the Group Name.";
    }

    if(isset($_REQUEST['uni']) && $_REQUEST['uni'] == '0') {
        $error = true;
        $uniError = "Please select the University.";
    }

    if(!isset($_POST['public'])){
        $error = true;
        $publicError = "Please select Who you want to share the event with";
    }

    //$resQuery=mysqli_query($conn,"SELECT userID FROM users WHERE userID=".$_SESSION['user']);
    //$userRow=mysqli_fetch_array($resQuery);
    //$userID = $userRow['userID'];
    if (!$error){
     if($p) {

        $query = "INSERT INTO groups(groupName,uniGroup,public) VALUES('$groupName','$uni','1')";
        $res = mysqli_query($conn, $query);
         if ($res) {
             $errTyp = "success";
             $errMSG = "Successfully entered the details";

         }
         else {
             $errTyp = "danger";
             $errMSG = "Something went wrong, try again later...";
         }
    }
    else {

        $query = "INSERT INTO groups(groupName,uniGroup) VALUES('$groupName','$uni')";
        $res = mysqli_query($conn, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully entered the details";

             $Query=mysqli_query($conn,"SELECT groupID FROM groups WHERE groupName='$groupName'");
             $Row=mysqli_fetch_array($Query);
             $groupId = $Row['groupID'];
            header('Location: addmembers.php?groupId='.$groupId);

        }
        else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }

    }

    }
}
?>

<body onload="initialize()">
<!-- banner -->
<div class="inside-banner">
    <div class="container">
        <span class="pull-right"><a href="#">Home</a> / Create Group</span>
        <h2>Create Group</h2>
    </div>
</div>
<!-- banner -->

<div class="container">
    <div class="spacer">
        <div class="row register">
            <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                    <h1>Group Details</h1>

                    <div> <label>Group Name:</label><input type="text" class="form-control" placeholder="Give your group a creative name" name="groupName"/><span class="text-danger"><?php echo $groupNameError; ?></span></div>


                    <div><label>Event For University: </label><select name="uni" id="uni" class="form-control">
                            <option value="0">Select the university</option>
                            <option>University of Greenwich</option>
                            <option>Goldsmiths,University of London</option>
                            <option>King's College London</option>
                            <option>Brunel University</option>
                            <option>University of Manchester</option>
                            <option>University of Kent</option>
                            <option>University of Derby</option>
                            <option>Kingston University</option>
                            <option>Oxford University</option>
                            <option>University of Cambridge</option>
                        </select><span class="text-danger"><?php echo $uniError; ?></span></div>

                        <div>
                        <label><input type="radio" name="public" value="public">Public</label>
                        <label><input type="radio" name="public" value="private">Private</label>
                        <span class="text-danger"><?php echo $publicError; ?></span>
                        </div>

            <button type="submit" class="btn btn-success" name="btn-Submit" id="upload">Create Group</button>

                </form>
            </div>

        </div>

    </div>
</div>
</body>
<?php include ("footer.php") ?>
