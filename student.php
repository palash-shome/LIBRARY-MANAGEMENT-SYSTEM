<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $roll_number = $branch =$contact = "";
$name_err = $roll_number_err = $branch_err = $contact_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
      
	
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
    // Validate branch
    $input_branch = trim($_POST["branch"]);
    if(empty($input_branch)){
        $branch_err = "Please enter the branch.";
	}		
     else{
        $branch = $input_branch;
    }
    
	// Validate contact
    $input_contact = trim($_POST["contact"]);
    if(empty($input_contact)){
        $contact_err = "Please enter the contact.";
	}		
     else{
        $contact = $input_contact;
    }
	
    // Check input errors before inserting in database
    if( empty($name_err) && empty($roll_number_err) && empty ($branch_err) && empty($contact_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO student (name,roll_number,branch,contact) VALUES ( ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss",$param_name, $param_roll_number, $param_branch,$param_contact);
            
            // Set parameters
			
            $param_name =$name;
            $param_roll_number =$roll_number;
            $param_branch =$branch;
			$param_contact=$contact;
            
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
    <title>Create Student Record</title>
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
                        <h2>Create Student Record</h2>
                    </div>
                    <p>Please fill this form and submit to add student record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<table>
					   
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($roll_number_err)) ? 'has-error' : ''; ?>">
                            <label>Roll Number</label>
                            <input typr="text" name="roll_number" class="form-control" value="<?php echo $roll_number; ?>">
                            <span class="help-block"><?php echo $roll_number_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($branch_err)) ? 'has-error' : ''; ?>">
                            <label>Brach</label>
                            <input type="text" name="branch" class="form-control" value="<?php echo $branch; ?>">
                            <span class="help-block"><?php echo $branch_err;?></span>
                        </div>
						<div class="form-group <?php echo (!empty($contact_err)) ? 'has-error' : ''; ?>">
                            <label>Contact</label>
                            <input type="text" name="contact" class="form-control" value="<?php echo $contact; ?>">
                            <span class="help-block"><?php echo $contact_err;?></span>
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