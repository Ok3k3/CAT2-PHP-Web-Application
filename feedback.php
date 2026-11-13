<?php
require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $feedback = trim($_POST["feedback"]);

    $stmt = $conn->prepare(
        "INSERT INTO feedback (name, feedback) VALUES (?, ?)"
    );
    $stmt->bind_param("ss", $name, $feedback);

    if ($stmt->execute()) {
        $message = "Feedback submitted successfully!";
    } else {
        $message = "Error submitting feedback.";
    }

    $stmt->close();
}

$result = $conn->query(
    "SELECT id, name, feedback, submitted_at FROM feedback ORDER BY submitted_at DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CAT2 - Student Feedback</title>
</head>
<body>

    <h2>Student Feedback Form</h2>

    <?php if ($message != ""): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Your Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Your Feedback:</label><br>
        <textarea name="feedback" rows="4" cols="40" required></textarea><br><br>

        <button type="submit">Submit Feedback</button>
    </form>

    <h3>Submitted Feedback</h3>

    <?php while ($row = $result->fetch_assoc()): ?>
        <p>
            <strong><?php echo htmlspecialchars($row["name"]); ?>:</strong>
            <?php echo htmlspecialchars($row["feedback"]); ?>
        </p>
    <?php endwhile; ?>

    <p><a href="index.php">Back to Home</a></p>

</body>
</html>

<?php $conn->close(); ?>
