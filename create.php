<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$rfid =$name = $roll_number = $bid =$bname = "";
$rfid_err =$name_err = $roll_number_err = $bid_err = $bname_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
    $input_name= trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = 'Please enter an name.';     
    } else{
        $name = $input_name;
    }
    
	// Validate roll number
    $input_roll_number = trim($_POST["roll_number"]);
    if(empty($input_roll_number)){
        $roll_number_err = "Please enter a Roll Number.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9'-.\s ]+$/")))){
        $roll_number_err = 'Please enter a valid roll number.';
    } else{
        $roll_number = $input_roll_number;
    }
    // Validate bid
    $input_bid = trim($_POST["bid"]);
    if(empty($input_bid)){
        $bid_err = "Please enter the bid.";
	}		
     else{
        $bid = $input_bid;
    }
    
	// Validate bname
    $input_bname = trim($_POST["bname"]);
    if(empty($input_bname)){
        $bid_err = "Please enter the bname.";
	}		
     else{
        $bname = $input_bname;
    }
	
    // Check input errors before inserting in database
    if(empty($rfid_err) && empty($name_err) && empty($roll_number_err) && empty ($bid_err) && empty($bname_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO library (rfid,name,roll_number,bid,bname) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_rfid,$param_name, $param_roll_number, $param_bid,$param_bname);
            
            // Set parameters
			$param_rfid=$rfid;
            $param_name = $name;
            $param_roll_number = $roll_number;
            $param_bid = $bid;
			$param_bname=$bname;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				echo "Record successfully inserted";
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add BOOK record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<table>
					    <div class="form-group <?php echo (!empty($rfid_err)) ? 'has-error' : ''; ?>">
                            <label>RFID</label>
                            <input type="text" name="rfid" class="form-control" value="<?php echo $rfid; ?>">
                            <span class="help-block"><?php echo $rfid_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Roll Number</label>
                            <input typr="text" name="roll_number" class="form-control" value="<?php echo $roll_number; ?>">
                            <span class="help-block"><?php echo $roll_number_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($bid_err)) ? 'has-error' : ''; ?>">
                            <label>BOOK ID</label>
                            <input type="text" name="bid" class="form-control" value="<?php echo $bid; ?>">
                            <span class="help-block"><?php echo $bid_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($bname_err)) ? 'has-error' : ''; ?>">
                            <label>BOOK NAME</label>
                            <input type="text" name="bname" class="form-control" value="<?php echo $bname; ?>">
                            <span class="help-block"><?php echo $bname_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="index.php" class="btn btn-default">Cancel</a>
						</table>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>