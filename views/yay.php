<?php
// yay.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization and Donors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .organization-info, .donor-info {
            margin-bottom: 15px;
        }
        .organization-info h3, .donor-info h3 {
            margin-bottom: 5px;
        }
        .organization-info p, .donor-info p {
            margin: 5px 0;
        }
        .donor-list {
            margin-top: 20px;
        }
        .donor-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .donor-list th, .donor-list td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ccc;
        }
        .donor-list th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Organization and Donors Details</h2>

     


 


        <?php
        // Check if organization data is available
        if(isset($organization)){
        if ( !empty($organization)) {
            echo "<div class='organization-info'>";
            echo "<h3>Organization Name: " . htmlspecialchars($organization['name']) . "</h3>";
            echo "<p><strong>Date:</strong> " . htmlspecialchars($organization['created_at']) . "</p>";
            echo "<p><strong>ID:</strong> " . htmlspecialchars($organization['id']) . "</p>";
            echo "</div>";
        } else {
            echo "<p>No organization data available.</p>";
        }
    }

        // Check if donors data is available
      
    if(isset($donorsData)){
     if (!empty($donorsData)) {
        foreach (($donorsData) as $column){
            echo "<p><strong>id:</strong> " . htmlspecialchars($donorsData[0]['id']) . "</p>";
            echo "<p><strong>details:</strong> " . htmlspecialchars($donorsData[0]['donation_details']) . "</p>";
        }
        }
    }

    // if(isset($event)){
    //     if (!empty($event)) {
    //           echo "created successfully";
    //        }
    //        else{
    //         echo "oops, something went wrong";
    //        }
    //    }

    
         ?>
  
        <!-- Add a button to go back to the previous page or to the homepage -->
        <form action="index.php" method="get">
            <button type="submit">Back to Home</button>
        </form>
    </div>

</body>
</html>
