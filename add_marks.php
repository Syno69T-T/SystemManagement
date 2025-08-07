<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = (int)$_POST['student_id'];
    $subject = $_POST['subject'];
    $score = (int)$_POST['score'];

    $stmt = $conn->prepare("INSERT INTO marks (student_id, subject, score) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $student_id, $subject, $score);

    if ($stmt->execute()) {
        echo "Markah berjaya ditambah.";
    } else {
        echo "Ralat: " . $stmt->error;
    }
}
?>

<h2>Tambah Markah Pelajar</h2>

<form method="POST">
    <label>ID Pelajar:</label><br>
    <input type="number" name="student_id" required><br>

    <label>Subjek:</label><br>
    <input type="text" name="subject" required><br>

    <label>Markah:</label><br>
    <input type="number" name="score" min="0" max="100" required><br><br>

    <button type="submit">Tambah Markah</button>
</form>
<br>
<a href="index.php">Kembali</a>