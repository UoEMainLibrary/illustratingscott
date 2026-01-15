<?php
//$con=mysqli_connect("localhost","","","illustrations_development");
//mysqli_set_charset($con, 'utf8');
// Check connection
//if (mysqli_connect_errno($con))
//  {
//  echo "Failed to connect to MySQL: " . mysqli_connect_error();
//  }
?> 

<?php
$con = mysqli_connect("localhost","illsuser","sQxvayzSPM59Xf5a","illustrations_development");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* change character set to utf8 */
if (!mysqli_set_charset($con, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($con));
} else {
  //  printf("Current character set: %s\n", mysqli_character_set_name($con));
}

//mysqli_close($con);
?>
