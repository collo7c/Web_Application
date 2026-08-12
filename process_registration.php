<?php
// ===== PHP Form Processing + MySQLi Insert =====

require_once 'db_connect.php';

$errors = [];
$success = false;

// Only process on POST (demonstrates POST method handling)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ---- 1. Receive & sanitize the submitted form data ----
    $fullName = trim($_POST['fullName'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $age      = trim($_POST['age'] ?? '');
    $gender   = trim($_POST['gender'] ?? '');
    $plan     = trim($_POST['plan'] ?? '');
    $goals    = isset($_POST['goals']) ? implode(', ', array_map('trim', $_POST['goals'])) : '';
    $comments = trim($_POST['comments'] ?? '');

    // ---- 2. Server-side validation ----
    if ($fullName === '') {
        $errors[] = 'Full Name is required.';
    }

    if ($email === '') {
        $errors[] = 'Email Address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($phone === '') {
        $errors[] = 'Phone Number is required.';
    } elseif (strlen(preg_replace('/\D/', '', $phone)) < 10) {
        $errors[] = 'Phone Number must be at least 10 digits.';
    }

    if ($plan === '') {
        $errors[] = 'Please select a Membership Plan.';
    }

    if ($age !== '' && (!is_numeric($age) || $age < 10 || $age > 100)) {
        $errors[] = 'Age must be a number between 10 and 100.';
    }

    // ---- 3. Insert into the database if valid ----
    if (empty($errors)) {
        $stmt = $conn->prepare(
            "INSERT INTO registrations (full_name, email, phone, age, gender, plan, goals, comments)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $ageValue = ($age === '') ? null : (int) $age;

        $stmt->bind_param(
            'sssissss',
            $fullName,
            $email,
            $phone,
            $ageValue,
            $gender,
            $plan,
            $goals,
            $comments
        );

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = 'Something went wrong saving your registration: ' . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
} else {
    $errors[] = 'This page can only be reached by submitting the registration form.';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FitZone Gym - Registration Result</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1><?php echo $success ? '✅ Registration Received' : '📝 Registration'; ?></h1>

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
    <?php if ($success): ?>
        <div class="card" style="border-left-color:#27ae60;">
            <h2 style="border:none;padding:0;margin:0 0 10px 0;">Thank you, <?php echo htmlspecialchars($fullName); ?>! 💪</h2>
            <p>Your registration has been saved. Here's what we received:</p>
        </div>

        <table>
            <tr><th>Field</th><th>Value</th></tr>
            <tr><td>Full Name</td><td><?php echo htmlspecialchars($fullName); ?></td></tr>
            <tr><td>Email</td><td><?php echo htmlspecialchars($email); ?></td></tr>
            <tr><td>Phone</td><td><?php echo htmlspecialchars($phone); ?></td></tr>
            <tr><td>Age</td><td><?php echo $age !== '' ? htmlspecialchars($age) : '—'; ?></td></tr>
            <tr><td>Gender</td><td><?php echo $gender !== '' ? htmlspecialchars($gender) : '—'; ?></td></tr>
            <tr><td>Plan</td><td><?php echo htmlspecialchars($plan); ?></td></tr>
            <tr><td>Fitness Goals</td><td><?php echo $goals !== '' ? htmlspecialchars($goals) : '—'; ?></td></tr>
            <tr><td>Comments</td><td><?php echo $comments !== '' ? htmlspecialchars($comments) : '—'; ?></td></tr>
        </table>

        <div style="text-align:center;margin-top:30px;">
            <a href="view_registrations.php" class="btn">View All Registrations</a>
            <a href="index.html" class="btn btn-secondary">Back to Home</a>
        </div>

    <?php else: ?>
        <div class="card" style="border-left-color:#c0392b;">
            <h2 style="border:none;padding:0;margin:0 0 10px 0; color:#c0392b;">We couldn't save your registration</h2>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div style="text-align:center;margin-top:30px;">
            <a href="register.html" class="btn">Back to Registration Form</a>
        </div>
    <?php endif; ?>
</section>

<footer>
    <p>&copy; 2026 FitZone Gym. All Rights Reserved.</p>
</footer>

</body>
</html>