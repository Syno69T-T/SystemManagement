<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8" />
    <title>Sistem Pengurusan Pelajar</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        /* Your CSS (mixed in) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(to right, #DEE791, #A3DC9A);
            background-attachment: fixed;
            color: black;
            padding: 40px;
            line-height: 1.6;
            position: relative;
        }

        /* Tambahan: corak geometri latar belakang */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 1px 1px, #a3dc9a 1px, transparent 0);
            background-size: 20px 20px;
            z-index: -1;
            opacity: 0.4;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #FFF9BD;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 700;
            border-left: 6px solid #A3DC9A;
            padding-left: 15px;
            color: #FFAAAA;
        }

        /* Button styles */
        .btn {
            display: inline-block;
            background-color: white;
            color: #A3DC9A; /* changed from #FAFFCA for readability */
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .btn:hover {
            background-color: #A3DC9A;
            color: white;
            transform: translateY(-2px);
        }

        /* Swiper slider container */
        .swiper {
            width: 100%;
            max-width: 700px;
            padding-bottom: 40px;
        }

        /* Each slide */
        .swiper-slide {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            user-select: none;
        }

        .student-photo {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
            border: 2px solid #ddd;
        }

        .student-info {
            font-size: 16px;
            margin-bottom: 10px;
            color: #18230F;
        }

        .delete-link {
            display: inline-block;
            margin-top: 10px;
            color: #e74c3c;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .delete-link:hover {
            text-decoration: underline;
            color: #c0392b;
        }

        /* Responsive tweaks */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Senarai Pelajar</h2>

        <a href="add_student.php" class="btn">+ Tambah Pelajar</a>

        <div class="swiper">
            <div class="swiper-wrapper">
                <?php
                $result = $conn->query("SELECT * FROM students");

                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        $photoPath = !empty($row['photo']) ? "uploads/" . htmlspecialchars($row['photo']) : "default.png";
                ?>
                    <div class="swiper-slide">
                        <img class="student-photo" src="<?= $photoPath ?>" alt="Foto Pelajar">
                        <div class="student-info"><strong>ID:</strong> <?= htmlspecialchars($row['id']) ?></div>
                        <div class="student-info"><strong>Nama:</strong> <?= htmlspecialchars($row['name']) ?></div>
                        <div class="student-info"><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></div>
                        <div class="student-info"><strong>Kursus:</strong> <?= htmlspecialchars($row['course']) ?></div>
                        <div class="student-info"><strong>Umur:</strong> <?= htmlspecialchars($row['umur']) ?></div>
                        <div class="student-info"><strong>Kelas:</strong> <?= htmlspecialchars($row['kelas']) ?></div>
                        <a class="delete-link" href="delete_student.php?id=<?= urlencode($row['id']) ?>" onclick="return confirm('Padam pelajar ini?')">Padam</a>
                    </div>
                <?php
                    endwhile;
                else:
                ?>
                    <div class="swiper-slide">Tiada pelajar ditemui.</div>
                <?php endif; ?>
            </div>

            <!-- Swiper navigation and pagination -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper('.swiper', {
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            spaceBetween: 20,
        });
    </script>

</body>
</html>