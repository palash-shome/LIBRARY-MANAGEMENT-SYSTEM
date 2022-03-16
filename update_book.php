<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$rfid=$bid = $bname =$isbn = $price = $count="";
$rfid_err = $bid_err = $bname_err = $isbn_err = $price_err= $count_err="";
 
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
	// Validate isbn
    $input_isbn= trim($_POST["isbn"]);
    if(empty($input_isbn)){
        $isbn_err = "Please enter the ISBN.";     
    } 
     else{
        $isbn = $input_isbn;
    }
    
	// Validate price
    $input_price= trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price.";     
    } 
     else{
        $price = $input_price;
    }
	// Validate count
    $input_count= trim($_POST["count"]);
    if(empty($input_count)){
        $count_err = "Please enter the count.";     
    } 
     else{
        $count = $input_count;
    }
	
    // Check input errors before inserting in database
    if(empty($bid_err) && empty($bname_err)&& empty($isbn_err) && empty($price_err) &&empty($count_err) ){
        // Prepare an update statement
        $sql = "UPDATE book SET  bid=?, bname=?, isbn=?, price=?, count=?  WHERE rfid=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssiis", $param_bid, $param_bname,$param_isbn, $param_price,$param_count, $param_rfid);
            
            // Set parameters

            $param_bid = $bid;
			$param_bname = $bname;
		    $param_isbn = $isbn;
            $param_price = $price;
			$param_count = $count;
            $param_rfid = $rfid;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: booklist.php");
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
        $sql = "SELECT * FROM book WHERE rfid = ?";
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
                    
                    $bid = $row["bid"];
					$bname = $row["bname"];
					$isbn = $row["isbn"];
                    $price = $row["price"];
					$count= $row["count"];
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
    <title>Update BOOK Record</title>
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                       
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
						 <div class="form-group <?php echo (!empty($isbn_err)) ? 'has-error' : ''; ?>">
                            <label>ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="<?php echo $isbn; ?>">
                            <span class="help-block"><?php echo $isbn_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>"></input>
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>
						 <div class="form-group <?php echo (!empty($count_err)) ? 'has-error' : ''; ?>">
                            <label>Count</label>
                            <input tyoe="text" name="count" class="form-control" value="<?php echo $count; ?>"></input>
                            <span class="help-block"><?php echo $count_err;?></span>
                        </div>
                        <input type="hidden" name="rfid" value="<?php echo $rfid; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="book.php" class="btn btn-default">BACK</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>