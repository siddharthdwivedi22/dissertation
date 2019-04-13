<?php include ("header.php") ?>

<?php
if( empty($_SESSION['user']) ){
    header("Location: login.php");
}
$error = false;

if ( isset($_POST['btn-Submit']) ) {

    $title = trim($_POST['title']);

    $location = $_POST['location'];

    $addressline1 = $_POST['addressline1'];

    $addressline2 = $_POST['addressline2'];

    $city = $_POST['city'];

    $country = trim($_POST['country']);
    //$rate = strip_tags($name);
    //$rate = htmlspecialchars($name);

    $postCode = trim($_POST['postcode']);

    $desc = trim($_POST['form_desc']);

    $uni = trim($_POST['uni']);

    $event_type = trim($_POST['event_type']);

    $start_date = trim($_POST['start_date']);

    $end_date = trim($_POST['end_date']);

    $start_time = date('H:i:s', strtotime($_POST['start_time']));

    $end_time = date('H:i:s', strtotime($_POST['end_time']));

    $lat = $_POST['lat'];

    $lng = $_POST['lng'];

// basic validation
    if (empty($title)) {
        $error = true;
        $titleError = "Please enter the title.";
    }
    if (empty($location)) {
        $error = true;
        $locationError = "Please enter the Address/Postcode.";
    }
    if (empty($city)) {
        $error = true;
        $cityError = "Please enter the City name.";
    }
    if (empty($postCode)) {
        $error = true;
        $postCodeError = "Please enter the Post Code.";
    }
    if (empty($desc)) {
        $error = true;
        $descError = "Please enter the Event Details.";
    }

    if(isset($_REQUEST['event_type']) && $_REQUEST['event_type'] == '0') {
        $error = true;
        $typeError = "Please select an Event Type.";
    }

    if(isset($_REQUEST['uni']) && $_REQUEST['uni'] == '0') {
        $error = true;
        $uniError = "Please select the University.";
    }

    $resQuery=mysqli_query($conn,"SELECT userID FROM users WHERE userID=".$_SESSION['user']);
    $userRow=mysqli_fetch_array($resQuery);
    $userID = $userRow['userID'];

    $j = 0; //Variable for indexing uploaded image

    $target_path = "events_images/"; //Declaring Path for uploaded images


    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {  //loop to get individual element from the array

        $validextensions = array("jpeg", "jpg", "png");  //Extensions which are allowed
        $ext = explode('.', basename($_FILES['file']['name'][$i]));//explode file name from dot(.)
        $file_extension = end($ext); //store extensions in the variable

        $target_path = $target_path . md5(uniqid()) . "." . $ext[count($ext) - 1];//set the target path with a new name of image
        $j = $j + 1;//increment the number of uploaded images according to the files in array

        if (($_FILES["file"]["size"][$i] < 90000000000000000) //Approx. 9MB files can be uploaded.
            && in_array($file_extension, $validextensions) && (!$error)
        ) {
            if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {//if file moved to folder
               // echo $j . ').<span id="noerror">Image uploaded successfully!.</span><br/><br/>';

                //$property = $_GET['id'];
                //$insert_path = "INSERT INTO events(imagePath) VALUES('$target_path')";
               // $var = mysqli_query($conn, $insert_path);
               // $Query=mysqli_query($conn,"SELECT imgsID FROM images WHERE propID='$property'");
              //  $Row=mysqli_fetch_array($Query);
              //  $_SESSION['images'] = $Row['imgsID'];
            $error = false;
            } else {//if file was not moved.
                $error = true;
                $imageError = "Please Try Again";
                //echo $j . ').<span id="error">please try again!.</span><br/><br/>';
            }
        } else {//if file size and file type was incorrect.
            $error = true;
            $imageError = "Invalid File size or Input";
            //echo $j . ').<span id="error">***Invalid file Size or Type***</span><br/><br/>';
        }
    }

    if (!$error) {

        $query = "INSERT INTO events(userID,uni,title,eventType,addressline1,addressline2,city,postcode,country,startDate,startTime,endDate,endTime,imagePath,description,lat,lng) VALUES('$userID','$uni','$title','$event_type','$addressline1','$addressline2','$city','$postCode','$country','$start_date','$start_time','$end_date','$end_time','$target_path','$desc','$lat','$lng')";
        $res = mysqli_query($conn, $query);
        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully entered the details";
           // $Query=mysqli_query($conn,"SELECT propID FROM property WHERE Title='$title'");
           // $Row=mysqli_fetch_array($Query);
           // $prop = $Row['propID'];
            //header('Location: multiupload.php?id='.$prop);

        }
        else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }
       // $Query=mysqli_query($conn,"SELECT propID FROM property WHERE Title='$title'");
       // $Row=mysqli_fetch_array($Query);
       // $_SESSION['property'] = $Row['propID'];
      //  $prop = $Row['propID'];

    }
}
?>

<body onload="initialize()">
<!-- banner -->
<div class="inside-banner">
    <div class="container">
        <span class="pull-right"><a href="#">Home</a> / Register</span>
        <h2>Register</h2>
    </div>
</div>
<!-- banner -->

<div class="container">
    <div class="spacer">
        <div class="row register">
            <div class="col-lg-6 col-lg-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 ">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                <h1>Event Details</h1>

               <div> <label>Event Title:</label><input type="text" class="form-control" placeholder="Give it a short descriptive name" name="title"/><span class="text-danger"><?php echo $titleError; ?></span></div>

                    <div><label>Event Type: </label><select name="event_type" id="event_type" class="form-control">
                    <option value="0">Select the type of event</option>
                    <option>Music</option>
                    <option>Clubbing</option>
                    <option>Party</option>
                    <option>House Party</option>
                    <option>Festival</option>
                    <option>Business</option>
                    <option>Dance</option>
                    <option>Performance/Concert</option>
                    <option>Charity</option>
                </select><span class="text-danger"><?php echo $typeError; ?></span></div>

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

                    <div> <div id="locationField">
                <label>Event Location/PostCode:</label><input id="autocomplete" type="text" class="form-control" placeholder="Location/Postcode" name="location" onfocus="geolocate()"/>
                 </div><span class="text-danger"><?php echo $locationError; ?></span></div>

            <div id="address">
                <label>Address Line 1</label><input type="text" name="addressline1" class="form-control" placeholder="Venue Name/House no." id="street_number" disabled="true"/>
                <label>Address Line 2</label><input type="text" name="addressline2" class="form-control" placeholder="Address Line 2" id="route" disabled="true"/>
                <div> <label>City:</label><input type="text" name="city" class="form-control" placeholder="City" id="locality" disabled="true"/><span class="text-danger"><?php echo $cityError; ?></span></div>
                <div><label>Post Code:</label><input type="text" name="postcode" class="form-control" placeholder="Post Code" id="postal_code" disabled="true"/><span class="text-danger"><?php echo $postCodeError; ?></span></div>
                <label>Country:</label><input type="text" name="country" class="form-control" placeholder="Country" id="country" disabled="true"/>
                <input type="hidden" name="lat" class="form-control" placeholder="Coordinates" id="cityLat" disabled="true"/>
                <input type="hidden" name="lng" class="form-control" placeholder="Coordinates" id="cityLng" disabled="true"/>

            </div>
                <div id="map-canvas"></div>


                <label>Start Date: </label>
                <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
                    <input class="form-control" type="text" name="start_date" readonly  />
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>

                <label>Start Time: </label><select name="start_time" id="starttime" class="form-control">
                    <option>17:00</option>
                    <option>17:30</option>
                    <option>18:00</option>
                    <option>18:30</option>
                    <option>19:00</option>
                    <option>19:30</option>
                    <option>20:00</option>
                    <option>20:30</option>
                    <option>21:00</option>
                    <option>21:30</option>
                    <option>22:00</option>
                    <option>22:30</option>
                    <option>23:00</option>
                    <option>23:30</option>
                    <option>00:00</option>
                    <option>00:30</option>
                    <option>01:00</option>
                    <option>01:30</option>
                    <option>02:00</option>
                    <option>02:30</option>
                    <option>03:00</option>
                    <option>03:30</option>
                    <option>04:00</option>
                    <option>04:30</option>
                    <option>05:00</option>
                    <option>05:30</option>
                    <option>06:00</option>
                    <option>06:30</option>
                    <option>07:00</option>
                    <option>07:30</option>
                    <option>08:00</option>
                    <option>08:30</option>
                    <option>09:00</option>
                    <option>09:30</option>
                    <option>10:00</option>
                    <option>10:30</option>
                    <option>11:00</option>
                    <option>11:30</option>
                    <option>12:00</option>
                    <option>12:30</option>
                    <option>13:00</option>
                    <option>13:30</option>
                    <option>14:00</option>
                    <option>14:30</option>
                    <option>15:00</option>
                    <option>15:30</option>
                    <option>16:00</option>
                    <option>16:30</option>
                </select>

                <label>End Date: </label>
                <div id="datepicker1" class="input-group date" data-date-format="yyyy-mm-dd">
                    <input class="form-control" type="text" name="end_date" readonly  />
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>


                <label>End Time: </label><select name="end_time" id="endtime" class="form-control">
                    <option>17:00</option>
                    <option>17:30</option>
                    <option>18:00</option>
                    <option>18:30</option>
                    <option>19:00</option>
                    <option>19:30</option>
                    <option>20:00</option>
                    <option>20:30</option>
                    <option>21:00</option>
                    <option>21:30</option>
                    <option>22:00</option>
                    <option>22:30</option>
                    <option>23:00</option>
                    <option>23:30</option>
                    <option>00:00</option>
                    <option>00:30</option>
                    <option>01:00</option>
                    <option>01:30</option>
                    <option>02:00</option>
                    <option>02:30</option>
                    <option>03:00</option>
                    <option>03:30</option>
                    <option>04:00</option>
                    <option>04:30</option>
                    <option>05:00</option>
                    <option>05:30</option>
                    <option>06:00</option>
                    <option>06:30</option>
                    <option>07:00</option>
                    <option>07:30</option>
                    <option>08:00</option>
                    <option>08:30</option>
                    <option>09:00</option>
                    <option>09:30</option>
                    <option>10:00</option>
                    <option>10:30</option>
                    <option>11:00</option>
                    <option>11:30</option>
                    <option>12:00</option>
                    <option>12:30</option>
                    <option>13:00</option>
                    <option>13:30</option>
                    <option>14:00</option>
                    <option>14:30</option>
                    <option>15:00</option>
                    <option>15:30</option>
                    <option>16:00</option>
                    <option>16:30</option>
                </select>

                    <div><div id="image-preview">
                    <label for="image-upload" id="image-label">Choose File</label>
                    <input type="file" name="file[]" id="image-upload" class="form-control" />
                </div><span class="text-danger"><?php echo $imageError; ?></span></div>

                    <div><textarea rows="10" class="form-control" placeholder="Event Description" name="form_desc"></textarea><span class="text-danger"><?php echo $descError; ?></span></div>

                <button type="submit" class="btn btn-success" name="btn-Submit" id="upload">Register</button>

                </form>
            </div>

        </div>

    </div>
</div>
</body>
<?php include ("footer.php") ?>
