<?php
// Check existence of rfid parameter before processing further
if(isset($_GET["rfid"]) && !empty(trim($_GET["rfid"]))){
    // Include config file
    require_once 'config.php';
    
    // Prepare a select statement
    $sql = "SELECT * FROM book WHERE rfid = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_rfid);
        
        // Set parameters
        $param_rfid = trim($_GET["rfid"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $rfid=$row["rfid"];
				$bname = $row["bname"];
                $bid = $row["bid"];
                $isbn = $row["isbn"];
				$price=$row["price"];
				$count=$row["count"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="icon" href="favicon.png" type="image/gif" sizes="16x16">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
					<div class="form-group">
                        <label>RFID</label>
                        <p class="form-control-static"><?php echo $row["rfid"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>BOOK Name</label>
                        <p class="form-control-static"><?php echo $row["bname"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Book ID</label>
                        <p class="form-control-static"><?php echo $row["bid"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>ISBN</label>
                        <p class="form-control-static"><?php echo $row["isbn"]; ?></p>
                    </div>
					<div class="form-group">
                        <label>Price</label>
                        <p class="form-control-static"><?php echo $row["price"]; ?></p>
                    </div>
					<div class="form-group">
                        <label>Count</label>
                        <p class="form-control-static"><?php echo $row["count"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>