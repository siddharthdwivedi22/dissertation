<?php include'header.php';?>
<?php

$eventId = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM `events` WHERE eventID='$eventId' ORDER BY startDate");
$row = mysqli_fetch_assoc($res);
?>

<script type="text/javascript">
    var map;
    function initialize() {
        // Set map options
        map = new google.maps.Map(document.getElementById("map_canvas"));
        var newPos = new google.maps.LatLng(<?php echo $row['lat']; ?>, <?php echo $row['lng']; ?>);
        map.setOptions({
            center: newPos,
            zoom: 15
        });

        var marker = new google.maps.Marker({
            position: newPos,
            map: map,
            title: "New marker"
        });
    }


    </script>
<?php
$active = ' active';
$userId = $_SESSION['user'];
$eventId = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM `events` WHERE eventID='$eventId' ORDER BY startDate");
$row = mysqli_fetch_assoc($res);
$_SESSION['title'] = $row['title'];
$_SESSION['ui'] = $row['uni'];
$_SESSION['eventType'] = $row['eventType'];
$_SESSION['addressLine2'] = $row['addressline2'];
$_SESSION['city'] = $row['city'];
$_SESSION['pCode'] = $row['postcode'];
$_SESSION['country'] = $row['country'];
$_SESSION['startDate'] = $row['startDate'];
$_SESSION['startTime'] = $row['startTime'];
$_SESSION['endDate'] = $row['endDate'];
$_SESSION['endTime'] = $row['endTime'];
$_SESSION['imagePath'] = $row['imagePath'];
$_SESSION['description'] = $row['description'];

//$PROPID = $row['propID'];
//$select_path = mysqli_query($conn, "SELECT * FROM `images` WHERE propID='$propId' ORDER BY 'id' DESC");

//while($imagerow = mysqli_fetch_assoc($select_path)) {
//    echo '<pre>';
//    print_r($imagerow);
//    echo '</pre>';
//}
//die();

?>
<body onload="initialize()">
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="#">Home</a> / Event</span>
    <h2>Event</h2>
</div>
</div>
<!-- banner -->


<div class="container">
<div class="properties-listing spacer">

<div class="row">
<div class="col-lg-3 col-sm-4 hidden-xs">

<div class="hot-properties hidden-xs">
<h4>Hot Events</h4>
<div class="row">
                <div class="col-lg-4 col-sm-5"><img src="images/properties/4.jpg" class="img-responsive img-circle" alt="properties"/></div>
                <div class="col-lg-8 col-sm-7">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p> </div>
              </div>
<div class="row">
                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"/></div>
                <div class="col-lg-8 col-sm-7">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p> </div>
              </div>

<div class="row">
                <div class="col-lg-4 col-sm-5"><img src="images/properties/3.jpg" class="img-responsive img-circle" alt="properties"/></div>
                <div class="col-lg-8 col-sm-7">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p> </div>
              </div>

<div class="row">
                <div class="col-lg-4 col-sm-5"><img src="images/properties/2.jpg" class="img-responsive img-circle" alt="properties"/></div>
                <div class="col-lg-8 col-sm-7">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p> </div>
              </div>

</div>



<div class="advertisement">
  <h4>Advertisements</h4>
  <img src="images/advertisements.jpg" class="img-responsive" alt="advertisement">

</div>

</div>

<div class="col-lg-9 col-sm-8 ">

<h2><?php echo $_SESSION['title']; ?></h2>
<div class="row">
  <div class="col-lg-8">
  <div class="property-images">
    <!-- Slider Starts -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators hidden-xs">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
        <li data-target="#myCarousel" data-slide-to="3" class=""></li>
      </ol>
      <div class="carousel-inner">
        <!-- Item 1 -->
        <div class="item active">
          <img src="images/properties/4.jpg" class="properties" alt="properties" />
        </div>
        <!-- #Item 1 -->

        <!-- Item 2 -->
        <div class="item">
          <img src="images/properties/2.jpg" class="properties" alt="properties" />
         
        </div>
        <!-- #Item 2 -->

        <!-- Item 3 -->
         <div class="item">
          <img src="images/properties/1.jpg" class="properties" alt="properties" />
        </div>
        <!-- #Item 3 -->

        <!-- Item 4 -->
        <div class="item ">
          <img src="images/properties/3.jpg" class="properties" alt="properties" />
          
        </div>
        <!-- # Item 4 -->
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
<!-- #Slider Ends -->

  </div>
  



  <div class="spacer"><h4><span class="glyphicon glyphicon-th-list"></span>Event Details</h4>
      <p><?php echo $_SESSION['description']; ?></p>
  <p>Completely synergize resource sucking relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art customer service</p>

  </div>
  <div><h4><span class="glyphicon glyphicon-map-marker"></span> Location</h4>
      <div id="map_canvas" style="width:550px;height:400px;border:solid black 1px;"></div>  </div>

  </div>
  <div class="col-lg-4">
  <div class="col-lg-12  col-sm-6">
<div class="property-info">
<p class="price">Starts:<?php echo $_SESSION['startDate']; ?> - <?php echo $_SESSION['startTime']; ?></p>
    <p class="price">Ends:<?php echo $_SESSION['endDate']; ?> - <?php echo $_SESSION['endTime']; ?></p>
    <p class="area"><span class="glyphicon glyphicon-map-marker"></span><?php echo $_SESSION['addressLine1']; ?></p>
    <p class="area"><span class="glyphicon glyphicon-map-marker"></span><?php echo $_SESSION['addressLine2']; ?></p>
    <p class="area"><span class="glyphicon glyphicon-map-marker"></span><?php echo $_SESSION['city']; ?>,<?php echo $_SESSION['pCode']; ?></p>
    <p class="area"><span class="glyphicon glyphicon-map-marker"></span><?php echo $_SESSION['country']; ?></p>

    <div class="profile">
  <span class="glyphicon glyphicon-user"></span> Agent Details
  <p>John Parker<br>009 229 2929</p>
  </div>
</div>

    <h6><span class="glyphicon glyphicon-home"></span> Availabilty</h6>
    <div class="listing-detail">
    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Bed Room">5</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Living Room">2</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Parking">2</span> <span data-toggle="tooltip" data-placement="bottom" data-original-title="Kitchen">1</span> </div>

</div>
<div class="col-lg-12 col-sm-6 ">
<div class="enquiry">
  <h6><span class="glyphicon glyphicon-envelope"></span> Post Enquiry</h6>
  <form role="form">
                <input type="text" class="form-control" placeholder="Full Name"/>
                <input type="text" class="form-control" placeholder="you@yourdomain.com"/>
                <input type="text" class="form-control" placeholder="your number"/>
                <textarea rows="6" class="form-control" placeholder="Whats on your mind?"></textarea>
      <button type="submit" class="btn btn-primary" name="Submit">Send Message</button>
      </form>
 </div>         
</div>
  </div>
</div>
</div>
</div>
</div>
</div>
</body>
<?php include'footer.php';?>