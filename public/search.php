<?php
// working but it rediert me on other page 
require_once "../config/dbconn.php";
require_once "../includes/auth.php";

$currentUserId = requireAuth();

if (isset($_POST['search'])) {
    $searchTerm = '%' . $_POST['search'] . '%'; // Added wildcards for LIKE search
    $stmt = $conn->prepare("SELECT * FROM contacts WHERE user_id = ? AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)");
    $stmt->bind_param("isss", $currentUserId, $searchTerm, $searchTerm, $searchTerm); // Changed "issi" to "isss" since phone is likely a string
    $stmt->execute();
    $result = $stmt->get_result();
?>
    <div class="contact-table">
        <?php
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td class='action-cell'>";
                echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-edit'><i class='fas fa-edit'></i></a>";
                echo "<a href='delete.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?')\" class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                echo "<a href='upcomming.php' class='btn btn-email'><i class='fa-solid fa-envelope'></i></a>";
                echo "<a href='upcomming.php' class='btn btn-phone'><i class='fa-solid fa-phone'></i></a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No contacts found.</p>";
        }
            
        $stmt->close();
        $conn->close();
        ?>
    </div>
<?php
}
?>