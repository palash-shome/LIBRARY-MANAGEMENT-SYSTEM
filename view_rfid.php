
<html>
<head
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TAG </title>
	<link rel="icon" href="favicon.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 16px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}
	</style>
	</head>
<body>
<div class="header">
<div class="w3-top">
  <div class="w3-bar" id="myNavbar">
    
    <a href="index.php" class="w3-bar-item w3-button"><i class="fa fa-home"></i>HOME</a>&nbsp;
   
    <a href="portfoli.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> PORTFOLIO</a>&nbsp;
    <a href="contact.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-envelope"></i> CONTACT</a>&nbsp;
    </div>
    </div>
  </div>
<p align="right"><a href="tag_searchform.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-red" ><i class="fa fa-search" style="font-size:28px;color:black"></i></a></p>

<br>
<?php
                    // Include config file
                    require_once 'connection.php';
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM rfid ";
                    if($result = mysqli_query($con, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<center><table class='table table-bordered table-striped' border='solid' cellpadding='10px' cellspacing='20px'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th> ID </th>";
                                        echo "<th> RFID </th>";
                                        echo "<th> ENTRY TIME </th>";
                                        echo "<th> DELETE </th>";
										//echo "<th>Status</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['tag'] . "</td>";
                                        echo "<td>" . $row['in_at'] . "</td>";
										echo "<td>";
                                        echo "<a href='deletetag.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table></center>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
                    }
 
                    // Close connection
                    mysqli_close($con);
                    ?>
</body>
</html>