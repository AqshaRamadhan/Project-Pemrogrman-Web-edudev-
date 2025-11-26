<?php
session_start();
include 'db_config.php'; 


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$nama_lengkap = $_SESSION['nama_lengkap'];
$username_sess = $_SESSION['username'];


if (isset($_GET['action']) && isset($_GET['course_id'])) {
    $course_id = (int)$_GET['course_id'];
    if ($_GET['action'] === 'enroll') {
        $stmt = $conn->prepare("INSERT IGNORE INTO enrollments (user_id, course_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $course_id);
        $stmt->execute();
        $stmt->close();
    } elseif ($_GET['action'] === 'unenroll') {
        $stmt = $conn->prepare("DELETE FROM enrollments WHERE user_id = ? AND course_id = ?");
        $stmt->bind_param("ii", $user_id, $course_id);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: dashboard.php');
    exit;
}


$sql_all = "
    SELECT c.id, c.judul, c.deskripsi, e.user_id IS NOT NULL AS is_enrolled,
    (SELECT COUNT(id) FROM modules WHERE course_id = c.id) AS total_modules,
    (SELECT COUNT(up.module_id) FROM user_progress up JOIN modules m ON m.id = up.module_id WHERE m.course_id = c.id AND up.user_id = ? AND up.is_completed = 1) AS completed_modules
    FROM courses c LEFT JOIN enrollments e ON c.id = e.course_id AND e.user_id = ?
    ORDER BY is_enrolled DESC, c.id ASC";

$stmt = $conn->prepare($sql_all);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$all_courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$enrolled_courses = array_filter($all_courses, fn($c) => $c['is_enrolled']);
$available_courses = array_filter($all_courses, fn($c) => !$c['is_enrolled']);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - EduDev</title>
    
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        :root {
            --primary-color: #4361ee; --primary-dark: #2f45c5; --secondary-color: #f0f3ff;
            --text-color: #333; --success-color: #4CAF50; --danger-color: #f44336;
            --bg-color: #f0f2f5; --white: #ffffff;
        }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-color); color: var(--text-color); margin: 0; padding: 0; }

        .navbar {
            background-color: var(--white);
            padding: 15px 40px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: fixed; top: 0; width: 100%; box-sizing: border-box; z-index: 1000;
        }
        .nav-brand { font-size: 1.5rem; font-weight: 700; color: var(--primary-color); text-decoration: none; }

        .nav-right { display: flex; align-items: center; gap: 15px; }

        .btn-profile-nav {
            display: flex; align-items: center; gap: 8px;
            text-decoration: none; color: #555; font-weight: 600; font-size: 0.9rem;
            padding: 8px 15px; border-radius: 50px; transition: 0.3s;
            background-color: #f8f9fa;
        }
        .btn-profile-nav:hover { background-color: #e0e7ff; color: var(--primary-color); }

        .btn-logout-nav {
            text-decoration: none; color: var(--danger-color); font-weight: 600; font-size: 0.9rem;
            padding: 8px 20px; border: 1px solid var(--danger-color); border-radius: 50px;
            transition: 0.3s;
        }
        .btn-logout-nav:hover { background-color: var(--danger-color); color: white; }

        .container { padding: 20px 40px; margin-top: 90px; max-width: 1200px; margin-left: auto; margin-right: auto; }
        h1 { color: var(--primary-color); font-weight: 700; margin-bottom: 5px; }
        h2 { color: var(--primary-color); font-weight: 600; margin-top: 30px; margin-bottom: 20px;}
        hr { border: 0; height: 1px; background: #e0e0e0; margin: 30px 0; }
        
        .course-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; }
        
        .course-card { background-color: var(--white); border-radius: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); overflow: hidden; display: flex; flex-direction: column; transition: transform 0.3s, box-shadow 0.3s; border: 1px solid #f0f0f0; }
        .course-card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(67, 97, 238, 0.15); }
        .card-header { height: 100px; background-color: var(--primary-color); position: relative; }
        .card-header::after { content: ''; position: absolute; top:0; left:0; width:100%; height:100%; background-image: radial-gradient(rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 10px 10px; }
        
        .card-content { padding: 20px; flex-grow: 1; }
        .card-content h3 { margin-top: 0; font-size: 1.15em; font-weight: 700; color: #1B1F3B; margin-bottom: 10px; }
        .card-content p { font-size: 0.9em; color: #666; margin-bottom: 20px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        .progress-container { display: flex; align-items: center; margin-top: auto; }
        .progress-bar { background-color: #eee; border-radius: 50px; height: 8px; width: 100%; overflow: hidden; }
        .progress-bar-fill { background-color: var(--success-color); height: 100%; transition: width 0.6s ease; }
        .progress-text { font-size: 0.75em; font-weight: 700; color: #333; margin-left: 10px; min-width: 35px; }
        
        .card-actions { padding: 15px 20px; border-top: 1px solid #f5f5f5; display: flex; gap: 10px; }
        .btn { text-decoration: none; padding: 10px; border-radius: 8px; font-size: 0.9em; font-weight: 600; text-align: center; transition: 0.2s; display: block; }
        .btn-primary { background-color: var(--primary-color); color: white; flex: 1; }
        .btn-primary:hover { background-color: var(--primary-dark); }
        .btn-outline-danger { border: 1px solid var(--danger-color); color: var(--danger-color); background: transparent; padding: 9px; font-size: 0.85em; }
        .btn-outline-danger:hover { background-color: #fff5f5; }
        .btn-block { width: 100%; }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="dashboard.php" class="nav-brand">EduDev Dashboard</a>
        
        <div class="nav-right">
            
            <a href="profile.php" class="btn-profile-nav" title="Edit Profil">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <span><?php echo htmlspecialchars($nama_lengkap); ?></span>
            </a>

            <a href="logout.php" class="btn-logout-nav" onclick="return confirm('Yakin ingin keluar?');">
                Logout
            </a>
        </div>
    </nav>

    <div class="container">
        <h1>Halo, <?php echo htmlspecialchars($nama_lengkap); ?>! 👋</h1>
        <p style="color: #666; margin-top: -5px;">Semangat belajar hari ini. Berikut progress kursus kamu.</p>
        
        <hr>

        <h2>📚 Kursus Saya</h2>
        <?php if (empty($enrolled_courses)): ?>
            <div style="text-align:center; padding: 40px; background: white; border-radius: 12px; border: 1px dashed #ccc;">
                <p style="color: #888;">Kamu belum mengambil kursus apapun.</p>
                <a href="#available" style="color: var(--primary-color); font-weight:600;">Lihat Kursus Tersedia</a>
            </div>
        <?php else: ?>
            <div class="course-list">
                <?php foreach ($enrolled_courses as $course): 
                    $progress = ($course['total_modules'] > 0) ? round(($course['completed_modules'] / $course['total_modules']) * 100) : 0;
                    $header_bg = 'hsl(' . (($course['id'] * 65) % 360) . ', 70%, 55%)'; 
                ?>
                <div class="course-card">
                    <div class="card-header" style="background-color: <?php echo $header_bg; ?>;"></div>
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($course['judul']); ?></h3>
                        <p><?php echo htmlspecialchars($course['deskripsi']); ?></p>
                        <div class="progress-container">
                            <div class="progress-bar"><div class="progress-bar-fill" style="width: <?php echo $progress; ?>%;"></div></div>
                            <span class="progress-text"><?php echo $progress; ?>%</span>
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="course_detail.php?id=<?php echo $course['id']; ?>" class="btn btn-primary">Lanjutkan</a>
                        <a href="dashboard.php?action=unenroll&course_id=<?php echo $course['id']; ?>" onclick="return confirm('Yakin ingin berhenti?');" class="btn btn-outline-danger"><i class="fas fa-trash"></i> Batal</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <hr>

        <h2 id="available">✨ Kursus Tersedia Untukmu</h2>
        <?php if (empty($available_courses)): ?>
            <p style="color: #666;">Saat ini belum ada kursus baru.</p>
        <?php else: ?>
            <div class="course-list">
                <?php foreach ($available_courses as $course): $header_bg = 'hsl(' . (($course['id'] * 65) % 360) . ', 40%, 75%)'; ?>
                <div class="course-card">
                    <div class="card-header" style="background-color: <?php echo $header_bg; ?>;"></div>
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($course['judul']); ?></h3>
                        <p><?php echo htmlspecialchars($course['deskripsi']); ?></p>
                        <span style="font-size: 0.8rem; background:#f0f0f0; padding:4px 10px; border-radius:4px; color:#555;"><?php echo $course['total_modules']; ?> Modul</span>
                    </div>
                    <div class="card-actions">
                        <a href="dashboard.php?action=enroll&course_id=<?php echo $course['id']; ?>" class="btn btn-primary btn-block">+ Ambil Kursus</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div style="margin-bottom: 50px;"></div>
    </div>
</body>
</html>