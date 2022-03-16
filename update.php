<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$rfid= $name = $roll_number = $bid = $bname = "";
$rfid_err = $name_err = $roll_number_err = $bid_err = $bname_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["rfid"]) && !empty($_POST["rfid"])){
    // Get hidden input value
    $rfid = $_POST["rfid"];
    
	 // Validate rfid
    $input_rfid = trim($_POST["rfid"]);
    if(empty($input_rfid)){
        $rfid_err = "Please enter a rfid.";
    } elseif(!filter_var(trim($_POST["rfid"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9'-.\s ]+$/")))){
        $rfid_err = 'Please enter a valid rfid.';
    } else{
        $rfid = $input_rfid;
    }
	
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
    
    // Validate roll number
    $input_roll_number = trim($_POST["roll_number"]);
    if(empty($input_roll_number)){
        $roll_number_err = 'Please enter an roll number.';     
    } else{
        $roll_number = $input_roll_number;
    }
    
    // Validate bid
    $input_bid= trim($_POST["bid"]);
    if(empty($input_bid)){
        $bid_err = "Please enter the Book ID.";     
    } 
     else{
        $bid = $input_bid;
    }
    
	// Validate bname
    $input_bname= trim($_POST["bname"]);
    if(empty($input_bname)){
        $bname_err = "Please enter the Book ID.";     
    } 
     else{
        $bname = $input_bname;
    }
	
    // Check input errors before inserting in database
    if(empty($name_err) && empty($roll_number_err) && empty($bid_err) && empty($bname_err)){
        // Prepare an update statement
        $sql = "UPDATE library SET name=?, roll_number=?, bid=?, bname=? WHERE rfid=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_roll_number, $param_bid, $param_bname, $param_rfid);
            
            // Set parameters
            $param_name = $name;
            $param_roll_number = $roll_number;
            $param_bid = $bid;
			$param_bname = $bname;
            $param_rfid = $rfid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    
    
    // Close connection
    mysqli_close($link);
	}
}else{
    // Check existence of id parameter before processing further
    if(isset($_GET["rfid"]) && !empty(trim($_GET["rfid"]))){
        // Get URL parameter
        $rfid =  trim($_GET["rfid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM library WHERE rfid = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_rfid);
            
            // Set parameters
            $param_rfid = $rfid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $roll_number = $row["roll_number"];
                    $bid = $row["bid"];
					$bname = $row["bname"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($roll_number_err)) ? 'has-error' : ''; ?>">
                            <label>Roll Number</label>
                            <textarea name="roll_number" class="form-control"><?php echo $roll_number; ?></textarea>
                            <span class="help-block"><?php echo $roll_number_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($bid_err)) ? 'has-error' : ''; ?>">
                            <label>Book ID</label>
                            <input type="text" name="bid" class="form-control" value="<?php echo $bid; ?>">
                            <span class="help-block"><?php echo $bid_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($bname_err)) ? 'has-error' : ''; ?>">
                            <label>Book Name</label>
                            <input type="text" name="bname" class="form-control" value="<?php echo $bname; ?>">
                            <span class="help-block"><?php echo $bname_err;?></span>
                        </div>
                        <input type="hidden" name="rfid" value="<?php echo $rfid; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>