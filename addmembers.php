<?php include'header.php';?>
<?php
if( empty($_SESSION['user']) ){
    header("Location: login.php");
}
$groupId = $_GET['groupId'];
?>
    <script type="text/javascript">
        function AddUser(userid,groupid)
        {
            jQuery.ajax({
                type: "GET",
                url: "adduser.php",
                data: 'userid='+userid + '&groupid='+groupid,
                cache: false,
                success: function(response)
                {
                    alert("Member Added!");
                }
            });
        }
    </script>
    <script type="text/javascript">

            $("#btn-add").toggle(function() {
                $(this).text("Added");
            });
    </script>
    <!-- banner -->
    <div class="inside-banner">
        <div class="container">
            <span class="pull-right"><a href="index.php">Home</a> / Add Members/Friends</span>
            <h2>Add Members To The Group</h2>
        </div>
    </div>
    <!-- banner -->
<?php $userId = $_SESSION['user']; ?>

    <div class="container">
        <h2>Add members</h2>
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label for="username">Search By Friend's Name:</label>
                <input type="text" class="form-control" id="username" placeholder="Enter Your Friend's name">
            </div>
            <button type="submit" class="btn btn-default" name="btn-submit" >Search</button>
        </form>
        <?php

    $username = $_POST['username'];
    $resQuery = 'SELECT * FROM users WHERE firstName LIKE "%' . $username . '%"  ORDER BY firstName';
    $result = mysqli_query($conn, $resQuery);

        ?>

        <?php if (mysqli_num_rows($result) > 0) { ?>
        <?php while($userRow = mysqli_fetch_assoc($result)){ ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $userRow['firstName']; ?></td>
                <td><?php echo $userRow['lastName']; ?></td>
                <td><?php echo $userRow['email']; ?></td>
                <td><?php echo $groupId; ?></td>
                <td><?php echo $userRow['userID']; ?></td>
                <td><button type="button" class="btn btn-default btn-sm" id="add" name="btn-add" onclick="AddUser(<?php echo $userRow['userID']; ?>,<?php echo $groupId; ?>)">
                        <span class="glyphicon glyphicon-bookmark"></span> Add
                    </button></td>
            </tr>
            </tbody>
        </table>
            <?php } ?>
        <?php } ?>

    </div>

<?php include'footer.php';?>