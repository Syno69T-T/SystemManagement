<?php include 'db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // manual id
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $umur = $_POST['umur'];
    $kelas = $_POST['kelas'];
    $grade = $_POST['grade'];

    $photo = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = time() . '_' . basename($_FILES['photo']['name']);
        $uploadFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $photo = $filename;
        } else {
            echo "Gagal memuat naik gambar.";
            exit;
        }
    }

    // Insert with grade, umur, kelas, manual id
    $stmt = $conn->prepare("INSERT INTO students (id, name, email, course, photo, umur, kelas, grade) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssisi", $id, $name, $email, $course, $photo, $umur, $kelas, $grade);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Ralat: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelajar</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
<h2>Tambah Pelajar Baru</h2>

<form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
    <label>ID (manual):</label><br>
    <input type="number" name="id" id="id" required><br>

    <label>Nama:</label><br>
    <input type="text" name="name" id="name" required><br>

    <label>Email:</label><br>
    <input type="email" name="email" id="email" required><br>

    <label>Kursus:</label><br>
    <input type="text" name="course" id="course" required><br>

    <label>Umur:</label><br>
    <input type="number" name="umur" id="umur" required><br>

    <label>Kelas:</label><br>
    <input type="text" name="kelas" id="kelas" required><br>

    <label>Markah:</label><br>
    <input type="number" name="grade" id="grade" min="0" max="100" step="0.01" required><br><br>

    <label>Foto Pelajar (optional):</label><br>
    <input type="file" name="photo" accept="image/*"><br><br>

    <button type="submit">Simpan</button>
</form>
<br>
<a href="index.php">Kembali</a>
</body>
</html>
2) Update your main page (index.php) with the swiper + student list + grade statistics chart
Add this below the swiper div (inside your .container), right after the students swiper:

php
Copy
Edit
<?php
// Fetch grades for statistics graph
$grades = [];
$result = $conn->query("SELECT grade FROM students WHERE grade IS NOT NULL");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $grades[] = (float)$row['grade'];
    }
}

// Bucket the grades (0-10, 11-20, ..., 91-100)
$buckets = array_fill(0, 10, 0);
foreach ($grades as $g) {
    $index = min(9, floor($g / 10));
    $buckets[$index]++;
}

$labels = [];
for ($i = 0; $i < 10; $i++) {
    $labels[] = ($i * 10) . '-' . (($i + 1) * 10);
}
?>

<h2>Statistik Markah Pelajar</h2>
<canvas id="gradeChart" width="700" height="350"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('gradeChart').getContext('2d');
const gradeChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Bilangan Pelajar',
            data: <?= json_encode($buckets) ?>,
            backgroundColor: '#FFAAAA',
            borderColor: '#FF9898',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1
            }
        },
        plugins: {
            legend: { display: true, position: 'top' },
            title: { display: true, text: 'Taburan Markah Pelajar (%)' }
        }
    }
});
</script>