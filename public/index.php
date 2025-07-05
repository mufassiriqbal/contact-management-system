<?php


require_once "../config/dbconn.php";
require_once "../includes/auth.php";

$currentUserId = requireAuth();
// $stmt = $conn->prepare("SELECT * FROM contacts WHERE user_id = ?");
// $stmt->bind_param("i", $currentUserId);
// $stmt->execute();
// $result = $stmt->get_result();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/display.css">
   <link rel="stylesheet" href="css/search.css">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> 
   
    <title>Contact List</title>
</head>
<body>
    <div class="header">
       
        <h1> <i class="fa-solid fa-house-user" style = "margin-right: 15px;"></i>Contact List</h1>
          
        <div class="test">
             <div class="search ">
            <form action="#" method="POST">
                <input type="text" placeholder="Search contacts"
                       name="search">
                <button>
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
        <button id="addContactBtn" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Contact
        </button>
<a href="logout.php" class="btn btn-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
    </div>
</div>

    <div class="contact-table">
        <?php
        //for search  
        if (isset($_POST['search'])) {
    $searchTerm = '%' . $_POST['search'] . '%';
    $stmt = $conn->prepare("SELECT * FROM contacts WHERE user_id = ? AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)");
    $stmt->bind_param("isss", $currentUserId, $searchTerm, $searchTerm, $searchTerm); // Changed "issi" to "isss" since phone is likely a string
    $stmt->execute();
    $result = $stmt->get_result();}

        // Show all data from database 
        else{
        $result = $conn->query("SELECT * FROM contacts where user_id = '$currentUserId'");
        }
        if ($result->num_rows > 0) {
            echo "<table>";
            echo '"<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
           
  
            
        
            
            </tr>"';

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email']. "</td>";
                echo "<td>" . $row['phone'] . "</td>";
               echo "<td class='action-cell'>";
echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-edit'><i class='fas fa-edit'></i></a>";
echo "<a href='delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?')\" class='btn btn-danger'><i class='fas fa-trash'></i></a>";
echo "<a   href='upcomming.php'class='btn btn-phone'  class='btn btn-email' ><i class='fa-solid fa-envelope'></i></a>";
echo "<a href='upcomming.php' class='btn btn-phone' ><i class='fa-solid fa-phone'></i></a>";
echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No contacts found.</p>";
        }
            
        $conn->close();
        ?>
    </div>

    <!-- Add Contact Modal so it will show in same s -->
    <div id="addContactModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Contact</h2>
            <form action="insert.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="fName" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="cancelAdd">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Contact</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>