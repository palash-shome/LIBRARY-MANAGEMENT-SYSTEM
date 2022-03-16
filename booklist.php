
<html>
<head
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BOOK LIST</title>
	<link rel="icon" href="favicon.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>


<br>
<?php
                    // Include config file
                    require_once 'config.php';
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM book ";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<center><table class='table table-bordered table-striped' border='solid' cellpadding='10px' cellspacing='20px'>";
                                echo "<thead>";
                                    echo "<tr>";
									 echo "<th> RFID </th>";
                                        echo "<th> BOOK ID </th>";
                                        echo "<th> BOOK NAME </th>";
                                        echo "<th> ISBN </th>";
                                        echo "<th> PRICE </th>";
										echo "<th> COUNT </th>";
										echo "<th> UPDATE </th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
									 echo "<td>" . $row['rfid'] . "</td>";
                                        echo "<td>" . $row['bid'] . "</td>";
                                        echo "<td>" . $row['bname'] . "</td>";
                                        echo "<td>" . $row['isbn'] . "</td>";
										echo "<td>" . $row['price'] . "</td>";
										echo "<td>" . $row['count'] . "</td>";
										echo "<td>";
                                        echo "<a href='update_book.php?rfid=". $row['rfid'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
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
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
</body>
</html>