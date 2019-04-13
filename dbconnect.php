<?php

 error_reporting( ~E_DEPRECATED & ~E_NOTICE );
 
 define('DBHOST', '127.0.0.1');
 define('DBUSER', 'root');
 define('DBPASS', '');
 define('DBNAME', 'sd3396j');
 
 $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
 //$dbcon = mysql_select_db(DBNAME);
 
 if ( !$conn ) {
  die("Connection failed : " . mysqli_error());
     echo "No connection";
 }
?>
 