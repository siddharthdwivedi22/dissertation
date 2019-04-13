<?php include'header.php';?>
<?php
if( empty($_SESSION['user']) ){
    header("Location: login.php");
}
?>
<script type="text/javascript">
    function SaveEvent(eventid)
    {
        jQuery.ajax({
            type: "GET",
            url: "save-events.php",
            data: 'eventid='+eventid,
            cache: false,
            success: function(response)
            {
                alert("Event Saved!");
            }
        });
    }
</script>
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    <span class="pull-right"><a href="index.php">Home</a> / Buy, Sale & Rent</span>
    <h2>Buy, Sale & Rent</h2>
</div>
</div>
<!-- banner -->
<?php $userId = $_SESSION['user']; ?>
<?php $res = mysqli_query($conn,"SELECT * FROM `events` WHERE userID='$userId' ORDER BY startDate ASC"); ?>


<div class="container">
<div class="properties-listing spacer">

<div class="row">
<div class="col-lg-3 col-sm-4 ">

  <div class="search-form"><h4><span class="glyphicon glyphicon-search"></span> Search for</h4>
    <input type="text" class="form-control" placeholder="Search of Properties">
    <div class="row">
            <div class="col-lg-5">
              <select class="form-control">
                <option>Buy</option>
                <option>Rent</option>
                <option>Sale</option>
              </select>
            </div>
            <div class="col-lg-7">
              <select class="form-control">
                <option>Price</option>
                <option>$150,000 - $200,000</option>
                <option>$200,000 - $250,000</option>
                <option>$250,000 - $300,000</option>
                <option>$300,000 - above</option>
              </select>
            </div>
          </div>

          <div class="row">
          <div class="col-lg-12">
              <select class="form-control">
                <option>Property Type</option>
                <option>Apartment</option>
                <option>Building</option>
                <option>Office Space</option>
              </select>
              </div>
          </div>
          <button class="btn btn-primary">Find Now</button>

  </div>



<div class="hot-properties hidden-xs">
<h4>Hot Properties</h4>
<div class="row">
                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"></div>
                <div class="col-lg-8 col-sm-7">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p> </div>
              </div>
<div class="row">
                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"></div>
                <div class="col-lg-8 col-sm-7">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p> </div>
              </div>

<div class="row">
                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"></div>
                <div class="col-lg-8 col-sm-7">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p> </div>
              </div>

<div class="row">
                <div class="col-lg-4 col-sm-5"><img src="images/properties/1.jpg" class="img-responsive img-circle" alt="properties"></div>
                <div class="col-lg-8 col-sm-7">
                  <h5><a href="property-detail.php">Integer sed porta quam</a></h5>
                  <p class="price">$300,000</p> </div>
              </div>

</div>


</div>

<div class="col-lg-9 col-sm-8">
<div class="sortby clearfix">
<div class="pull-left result">Showing: 12 of 100 </div>
  <div class="pull-right">
  <select class="form-control">
  <option>Sort by</option>
  <option>Price: Low to High</option>
  <option>Price: High to Low</option>
</select></div>

</div>
<div class="row">

        <?php
        $per_page=5;
        if (isset($_GET['page'])) {

            $page = $_GET['page'];

        }

        else {

            $page=1;

        }

        // Page will start from 0 and Multiple by Per Page
        $start_from = ($page-1) * $per_page;

        //Selecting the data from table but with limit
        $query = "SELECT * FROM events WHERE userID='$userId' ORDER BY startDate LIMIT $start_from, $per_page";
        $result = mysqli_query($conn, $query);

        ?>



        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while($row = mysqli_fetch_assoc($result)){
                $_SESSION['eventId'] = $row['eventID'];
                ?>

        <!-- events -->
      <div class="col-lg-4 col-sm-6">
      <div class="properties">
        <div class="image-holder"><img src="<?php echo $row['imagePath'];?>" class="img-responsive" alt="properties">
        </div>
        <h4><a href="event-details.php?id=<?php echo $row['eventID']?>"><?php echo $row['title']; ?></a></h4>
        <p class="price">Uni:<?php echo $row['uni']; ?></p>
          <p class="price"><?php echo $row['startDate']; ?></p>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <?php $eventId = $row['eventID'] ?>
          <p class="price"><button type="button" class="btn btn-default btn-sm" name="btn-save" onclick="SaveEvent(<?php echo $eventId; ?>)">
                  <span class="glyphicon glyphicon-bookmark"></span> Save
              </button></p>
              </form>
        <a class="btn btn-primary" href="event-details.php">View Details</a>
      </div>
      </div>
      <!-- events -->
            <?php } ?>
        <?php } ?>

      <div class="center">
<ul class="pagination">
    <?php

    // Count the total records
    $total_records = mysqli_num_rows($res);

    //Using ceil function to divide the total records on per page
    $total_pages = ceil($total_records / $per_page);

    //Going to first page
    if($_GET['page'] != 1) {
        echo '<li><a href="myevents.php?page=1">First Page</a></li> ';
    }
    for ($i=1; $i<=$total_pages; $i++) {

        echo '<li><a href="myevents.php?page='.$i.'">'.$i.'</a></li>';
    }
    // Going to last page
    echo '<li><a href="myevents.php?page='.$total_pages.'">Last Page</a></li> ';
    ?>

</ul>
</div>

</div>
</div>
</div>
</div>
</div>

<?php include'footer.php';?>