<?php
// ===== Data Retrieval + Display =====
require_once 'db_connect.php';

$result = $conn->query("SELECT * FROM registrations ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>FitZone Gym - Registered Members</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>📋 Registered Members</h1>

<nav>
    <a href="index.html">Home</a>
    <a href="membership.html">Membership Plans</a>
    <a href="register.html">Register</a>
    <a href="contact.html">Contact Us</a>
    <a href="class.html">Classes</a>
    <a href="gallery.html">Gallery</a>
    <a href="view_registrations.php">View Registrations</a>
</nav>

<section>
    <h2>All Registrations (<?php echo $result->num_rows; ?>)</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Plan</th>
                <th>Goals</th>
                <th>Registered On</th>
            </tr>
            <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo $row['age'] !== null ? htmlspecialchars($row['age']) : '—'; ?></td>
                    <td><?php echo $row['gender'] !== '' ? htmlspecialchars($row['gender']) : '—'; ?></td>
                    <td><?php echo htmlspecialchars($row['plan']); ?></td>
                    <td><?php echo $row['goals'] !== '' ? htmlspecialchars($row['goals']) : '—'; ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="card">
            <p>No registrations yet. <a href="register.html">Be the first to join!</a></p>
        </div>
    <?php endif; ?>
</section>

<footer>
    <p>&copy; 2026 FitZone Gym. All Rights Reserved.</p>
</footer>

</body>
</html>
<?php $conn->close(); ?>