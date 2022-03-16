
<?php

require_once 'config.php';
 //echo "jksdhhjk";

 
if(isset($_GET['roll_number'])){
    // Prepare a select statement
    $sql = "SELECT * FROM library WHERE roll_number = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_roll_number);
        
        // Set parameters
        $param_roll_number= $_GET['roll_number'];
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					echo "<p>" . $row["rfid"] . "</p>";
                    echo "<p>" . $row["name"] . "</p>";
					echo "<p>" . $row["bid"] . "</p>";
					echo "<p>" . $row["bname"] . "</p>";
                }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>