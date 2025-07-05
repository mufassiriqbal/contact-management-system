 <?php
//require_once "dbconn.php"; -->

// // Get the contact ID from URL parameter
// $id = $_GET['id'];

// // Fetch the contact data from database
// $query = "SELECT * FROM contacts WHERE id = ?";
// $stmt = $conn->prepare($query);
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $result = $stmt->get_result();
// $data = $result->fetch_assoc();

// // Close statement and connection
// $stmt->close();
// $conn->close();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/display.css">
    <title>Edit Contact</title>
</head>
<body>
    <div class="header">
        <h1>Edit Contact</h1>
    </div>

    <div class="edit-form">
        <form method="POST" action="update.php">
            <input type="hidden" name="id">
            
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email"required>
            </div>
            
            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone"  required>
            </div>
            
            <div class="form-footer">
                <a href="index.php" class="btn btn-back"><i class="fas fa-arrow-left"></i> Back</a>
                <button class="btn btn-primary" type="submit">Update Contact</button>
            </div>
        </form>
    </div>
</body>
</html>