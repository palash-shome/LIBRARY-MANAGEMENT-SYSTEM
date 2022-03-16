<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
	<link rel="icon" href="favicon.png" type="image/gif" sizes="18x18">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        .wrapper{
            width: 800px;
            margin: 0 auto;
        }
        
        table tr td:last-child a{
            margin-right: 15px;
        }
		.align-right { text-align:right; }
		.w3-wide {letter-spacing: 10px;}
.w3-hover-opacity {cursor: pointer;}

.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: #EDCDC2;
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
div.sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 5;
    background-color: black;
    padding: 20px;
    font-size: 16px;
}
a.current {
  background:#cccccc;
  color:black;
}


    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
		
}
$(function(){
  $('a').each(function() {
    if ($(this).prop('href') == window.location.href) {
      $(this).addClass('current');
    }
  });
});
    </script>
	 
</head>
<body>
<div class="header">
<div class="w3-top">
<div class="sticky">
  <div class="w3-bar" id="myNavbar">
  
	  

	  
    
    <a href="index.php" class="current"><i class="fa fa-home"> HOME</i></a>&nbsp;&nbsp;&nbsp;
    <a href="book.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-book"></i> BOOKS </a>&nbsp;&nbsp;&nbsp;
    <a href="portfoli.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> PORTFOLIO</a>&nbsp;&nbsp;&nbsp;
	<a href="view_rfid.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-tag"></i> TAG DATA</a>&nbsp;&nbsp;&nbsp;
    <a href="student.php" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-graduation-cap"></i> STUDENT </a>&nbsp;
		
	<span style="align:right"><a href="search.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-red" ><i class="fa fa-search"></i></a></span>
	</div>
 </div>
 </div>
  

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
				
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Issue Details</h2>
                        <a href="create.php" class="btn btn-primary pull-right">Add New BOOK  <i class="fa fa-book"></i></a>
                    </div>
                    <?php
                    // Include config file
                    require_once 'config.php';
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM library";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>RFID</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>ROLL NUMBER</th>";
                                        echo "<th>BOOK ID</th>";
										echo "<th>BOOK NAME</th>";
                                        echo "<th>Action</th>";
										//echo "<th>Status</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['rfid'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['roll_number'] . "</td>";
                                        echo "<td>" . $row['bid'] . "</td>";
										echo "<td>" . $row['bname'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?rfid=". $row['rfid'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?rfid=". $row['rfid'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?rfid=". $row['rfid'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
				
            </div>        
        </div>
		
		<a href="logout.php" class="btn btn-danger pull-right">Sign Out</a>
		
    </div>
	<br>
	<br>
	
	<footer align="center">

 
    <i class="fa fa-facebook-official w3-hover-opacity"></i></a>&nbsp;
    <i class="fa fa-instagram w3-hover-opacity"></i>&nbsp;
    <i class="fa fa-snapchat w3-hover-opacity"></i>&nbsp;
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>&nbsp;
    <i class="fa fa-twitter w3-hover-opacity"></i>&nbsp;
    <i class="fa fa-linkedin w3-hover-opacity"></i>&nbsp;
  
  
 </footer>

</body>
</html>