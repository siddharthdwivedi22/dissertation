<?php
ob_start();
session_start();
require_once 'dbconnect.php'

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Uni Events </title>
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/style.css"/>
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.js"></script>
    <script src="assets/script.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAx_ZYuivsfVrnyEDZ4XCG1hVedQBvCHmk&libraries=places"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet" type="text/css"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css" rel="stylesheet" type="text/css"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.uploadPreview.min.js"></script>
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image-label"
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $("#datepicker").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());;
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $("#datepicker1").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());;
        });
    </script>
    <script>

        var placeSearch, autocomplete;
        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            country: 'long_name',
            postal_code: 'short_name'
        };

        function initialize() {
            var mapOptions = {
                center: new google.maps.LatLng(51.481383, -0.109863),
                zoom: 10
            };
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')), {types: ['geocode']});
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                // Get the place details from the autocomplete object.
                var place = autocomplete.getPlace();

                for (var component in componentForm) {
                    document.getElementById(component).value = '';
                    document.getElementById(component).disabled = false;
                    document.getElementById('cityLat').value = place.geometry.location.lat();
                    document.getElementById('cityLng').value = place.geometry.location.lng();
                }
                var newPos = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                map.setOptions({
                    center: newPos,
                    zoom: 15
                });

                //add a marker
                var marker = new google.maps.Marker({
                    position: newPos,
                    map: map,
                    title: "New marker"
                });

                // Get each component of the address from the place details
                // and fill the corresponding field on the form.
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];
                    if (componentForm[addressType]) {
                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById(addressType).value = val;
                    }
                }
            });
        }

    </script>
    <!-- Owl stylesheet -->
    <link rel="stylesheet" href="assets/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/owl-carousel/owl.theme.css">
    <script src="assets/owl-carousel/owl.carousel.js"></script>
    <!-- Owl stylesheet -->

<!-- slitslider -->
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/custom.css" />
    <script type="text/javascript" src="assets/slitslider/js/modernizr.custom.79639.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.ba-cond.min.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.slitslider.js"></script>
<!-- slitslider -->

</head>

<body>


<!-- Header Starts -->
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="home.php">UniEvents</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
            <li><a href="events.php">Create Event</a></li>
            <li><a href="create_group.php">Create Group</a></li>
            <?php if(!empty($_SESSION['user'])) { ?>
            <li><a href="myevents.php">My Events</a></li>
            <?php } ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if(empty($_SESSION['user'])) { ?>
            <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php } ?>
            <?php if(!empty($_SESSION['user'])) { ?>
            <li><a href="userprofile.php" ><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username']; ?></a></li>
            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a>  </li>
            <?php } ?>
        </ul>
    </div>
</nav>

<!-- #Header Starts -->





<div class="container">

<!-- Header Starts -->
<div class="header">
<a href="home.php"><img src="images/logo.png" alt="Uni-Events" height="100px"></a>

              <ul class="pull-right">
                <li><a href="buysalerent.php">Buy</a></li>
                <li><a href="buysalerent.php">Sale</a></li>         
                <li><a href="buysalerent.php">Rent</a></li>
              </ul>
</div>
<!-- #Header Starts -->
</div>