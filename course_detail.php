<?php

session_start();
include 'db_config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$course_id = $_GET['id'] ?? null;

if (!$course_id || !is_numeric($course_id)) {
    die("Error: ID Kursus tidak valid.");
}

if (isset($_GET['toggle_module'])) {
    $module_id = (int)$_GET['toggle_module'];
    $is_completed = (int)$_GET['status']; 
    
    if ($is_completed) {

        $stmt = $conn->prepare("INSERT INTO user_progress (user_id, module_id, is_completed, tgl_selesai) VALUES (?, ?, 1, NOW()) 
                                ON DUPLICATE KEY UPDATE is_completed = 1, tgl_selesai = NOW()");
    } else {

        $stmt = $conn->prepare("DELETE FROM user_progress WHERE user_id = ? AND module_id = ?");
    }
    
    $stmt->bind_param("ii", $user_id, $module_id);
    $stmt->execute();
    $stmt->close();

    header("Location: course_detail.php?id=$course_id");
    exit;
}

$sql = "
    SELECT 
        c.judul, c.deskripsi, m.id AS module_id, m.judul_modul, m.isi_materi, m.urutan,
        up.is_completed IS NOT NULL AS is_done
    FROM courses c
    JOIN modules m ON c.id = m.course_id
    LEFT JOIN user_progress up ON up.module_id = m.id AND up.user_id = ?
    WHERE c.id = ?
    ORDER BY m.urutan ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $course_id); 
$stmt->execute();
$result = $stmt->get_result();
$modules = $result->fetch_all(MYSQLI_ASSOC);

if (empty($modules)) {
    die("Error: Kursus tidak ditemukan atau Anda belum terdaftar.");
}

$course_title = $modules[0]['judul'];
$course_description = $modules[0]['deskripsi'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Kursus: <?php echo htmlspecialchars($course_title); ?></title>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        :root {
            --primary-color: #4361ee;
            --secondary-color: #f0f3ff;
            --text-color: #333;
            --success-color: #4CAF50;
            --danger-color: #f44336;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px 40px;
        }

        h1, h2 {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .back-link {
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .course-header {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        .course-header p {
            font-style: italic;
            color: #666;
            margin-top: 5px;
        }

        .module-list {
            margin-top: 20px;
        }
        .module-item {
            margin-bottom: 10px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }
        .module-header { 
            background-color: #fff; 
            padding: 15px; 
            border-left: 5px solid var(--primary-color);
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .module-header:hover {
            background-color: var(--secondary-color);
        }
        
        .status-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .status-badge {
            font-size: 0.8em;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none; 
            white-space: nowrap;
            cursor: pointer;
        }
        .status-done {
            background-color: var(--success-color);
            color: white;
        }
        .status-pending {
            background-color: #ccc;
            color: var(--text-color);
        }

        .module-content { 
            padding: 20px 25px; 
            border: 1px solid #eee; 
            border-top: none; 
            background-color: #fafafa;
            display: none; 
            line-height: 1.6;
        }
    </style>
    </head>
<body>
    <div class="container">
        <a href="dashboard.php" class="back-link">← Kembali ke Dashboard</a>
        
        <div class="course-header">
            <h1><?php echo htmlspecialchars($course_title); ?></h1>
            <p><?php echo htmlspecialchars($course_description); ?></p>
        </div>
        
        <h2>📦 Daftar Modul Pembelajaran</h2>
        
        <div class="module-list">
            <?php foreach ($modules as $modul): ?>
                <div class="module-item">
                    
                    <div class="module-header">
                        <div onclick="toggleMateri(<?php echo $modul['module_id']; ?>)" style="flex-grow: 1; cursor: pointer;">
                            [<?php echo $modul['urutan']; ?>] <?php echo htmlspecialchars($modul['judul_modul']); ?>
                        </div>
                        
                        <div class="status-area">
                            <?php 
                                $is_done = $modul['is_done'];
                                $next_status = $is_done ? 0 : 1; 
                                $badge_class = $is_done ? 'status-done' : 'status-pending';
                                $badge_text = $is_done ? '✔ Selesai' : 'Belum';
                            ?>
                            
                            <a href="course_detail.php?id=<?php echo $course_id; ?>&toggle_module=<?php echo $modul['module_id']; ?>&status=<?php echo $next_status; ?>" 
                               class="status-badge <?php echo $badge_class; ?>">
                                <?php echo $badge_text; ?>
                            </a>
                        </div>
                    </div>
                    
                    <div class="module-content" id="materi_<?php echo $modul['module_id']; ?>">
                        <h3>Materi: <?php echo htmlspecialchars($modul['judul_modul']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($modul['isi_materi'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>

    <script>
    function toggleMateri(moduleId) {
        var materi = document.getElementById('materi_' + moduleId);
        if (materi.style.display === "none" || materi.style.display === "") {
            materi.style.display = "block";
        } else {
            materi.style.display = "none";
        }
    }
    </script>
</body>
</html>