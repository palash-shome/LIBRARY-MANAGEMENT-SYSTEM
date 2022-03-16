<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$rfid=$bid =$bname=$isbn=$price=$count="";
$rfid_err =$bid_err = $bname_err=$isbn_err=$price_err=$count_err="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate rfid
    $input_rfid = trim($_POST["rfid"]);
    if(empty($input_rfid)){
        $rfid_err = "Please enter a rfid assigned.";
    } elseif(!filter_var(trim($_POST["rfid"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9'-.\s ]+$/")))){
        $rfid_err = 'Please enter a valid rfid.';
    } else{
        $rfid = $input_rfid;
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
	// Validate isbn
    $input_isbn = trim($_POST["isbn"]);
    if(empty($input_isbn)){
        $isbn_err = "Please enter the ISBN.";
	}		
     else{
        $isbn = $input_isbn;
    }
	// Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price.";
	}		
     else{
        $price = $input_price;
    }
	// Validate count
    $input_count = trim($_POST["count"]);
    if(empty($input_count)){
        $count_err = "Please enter the count.";
	}		
     else{
        $count = $input_count;
    }
    // Check input errors before inserting in database
    if(empty($rfid_err) && empty ($bid_err) && empty($bname_err) &&empty($isbn_err) &&empty($price_err) &&empty($count_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO book (rfid,bid,bname,isbn,price,count) VALUES (?, ?, ?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssii", $param_rfid,$param_bid,$param_bname,$param_isbn,$param_price,$param_count);
            
            // Set parameters
			$param_rfid=$rfid;
            $param_bid = $bid;
			$param_bname=$bname;
			$param_isbn=$isbn;
			$param_price=$price;
			$param_count=$count;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
				echo "Record successfully inserted";
                // Records created successfully. Redirect to landing page
                header("location: booklist.php");
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
    <title>New Book Record</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="icon" href="favicon.png" type="image/gif" sizes="16x16">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
		.btn1 {
    background-color: #33cc33; /* Blue background */
    border: none; /* Remove borders */
    color: white; /* White text */
    padding: 12px 16px; /* Some padding */
    font-size: 16px; /* Set a font size */
    cursor: pointer; /* Mouse pointer on hover */
}

/* Darker background on mouse-over */
.btn1:hover {
    background-color: RoyalBlue;
}
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>New Book Record</h2>
                    </div>
			
                    <p>Please fill this form and submit to add new book to the database.</p>
							<p align="right"><a href="bookserarchform.php" class="w3-bar-item w3-button w3-hide-small w3-right w3-hover-red" ><button class="btn1" ><i class="fa fa-search"></i> Search Book</button></a></p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<table>
					    <div class="form-group <?php echo (!empty($rfid_err)) ? 'has-error' : ''; ?>">
                            <label>RFID</label>
                            <input type="text" name="rfid" class="form-control" value="<?php echo $rfid; ?>">
                            <span class="help-block"><?php echo $rfid_err;?></span>
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
						<div class="form-group <?php echo (!empty($isbn_err)) ? 'has-error' : ''; ?>">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="<?php echo $isbn; ?>">
                            <span class="help-block"><?php echo $isbn_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>PRICE</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($count_err)) ? 'has-error' : ''; ?>">
                            <label>COUNT</label>
                            <input type="text" name="count" class="form-control" value="<?php echo $count; ?>">
                            <span class="help-block"><?php echo $count_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="booklist.php" class="btn btn-danger">Update</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="index.php" class="btn btn-default">Cancel</a>
						</table>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>