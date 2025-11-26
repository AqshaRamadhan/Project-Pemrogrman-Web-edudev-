<?php
session_start();

include 'db_config.php'; 

$message = '';
$is_login_page = !isset($_GET['action']) || $_GET['action'] == 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $nama_lengkap = $_POST['nama_lengkap'] ?? '';

    if (!$is_login_page) {
        if (empty($username) || empty($password) || empty($nama_lengkap)) {
             $message = '<p style="color:red;">Semua field wajib diisi!</p>';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $default_role = 'user';
            
            $stmt = $conn->prepare("INSERT INTO users (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
            
            if ($stmt) {
                $stmt->bind_param("ssss", $username, $hashed_password, $nama_lengkap, $default_role);
                if ($stmt->execute()) {
        
                    header('Location: login.php?registered=1');
                    exit;
                } else {
                    if ($conn->errno == 1062) {
                        $message = '<p style="color:red;">Username sudah digunakan. Pilih username lain.</p>';
                    } else {
                        $message = '<p style="color:red;">Pendaftaran gagal: ' . $stmt->error . '</p>';
                    }
                }
                $stmt->close();
            } else {
                $message = '<p style="color:red;">Error Prepared Statement: ' . $conn->error . '</p>';
            }
        }
    } 
    // --- LOGIKA LOGIN ---
    else {
        // 1. CEK HARDCODED ADMIN (Sesuai request awal: admin/admin123)
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = 'Administrator';
            $_SESSION['role'] = 'admin';
            $_SESSION['nama_lengkap'] = 'Super Admin';
            
            header('Location: manage_courses.php');
            exit;
        }

        // 2. CEK USER DI DATABASE
        // Kita ambil kolom 'role' juga dari database
        $stmt = $conn->prepare("SELECT id, password, nama_lengkap, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['username'] = $username;
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role']; // Simpan role di session

                $stmt->close();
                $conn->close();

                // LOGIKA REDIRECT BERDASARKAN ROLE
                if ($user['role'] === 'admin') {
                    header('Location: manage_courses.php');
                } else {
                    header('Location: dashboard.php');
                }
                exit;
            }
        }
        $message = '<p style="color:red;">Username atau Password salah!</p>';
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $is_login_page ? 'Halaman Login' : 'Halaman Pendaftaran'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan style yang senada dengan index.php */
        body { font-family: 'Poppins', sans-serif; background-color: #F5F7FA; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; width: 400px; padding: 40px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #1B1F3B; margin-bottom: 20px; }
        label { font-weight: 500; color: #1B1F3B; display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { background-color: #4361EE; color: white; padding: 12px; border: none; border-radius: 50px; cursor: pointer; width: 100%; font-weight: 600; font-size: 1rem; transition: 0.3s; }
        button:hover { background-color: #2f45c5; }
        .link-switch { text-align: center; margin-top: 15px; font-size: 0.9rem; color: #6c757d; }
        a { color: #4361EE; text-decoration: none; font-weight: 600; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="container">
        <h2><?php echo $is_login_page ? 'Masuk Akun' : 'Daftar Baru'; ?></h2>
        
        <?php 
        if (isset($_GET['registered'])) {
            echo '<p style="color:green; text-align:center;">Pendaftaran berhasil! Silakan login.</p>';
        }
        echo $message; 
        ?>

        <form method="POST">
            <?php if (!$is_login_page): ?>
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required>
            <?php endif; ?>
            
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit"><?php echo $is_login_page ? 'Login Sekarang' : 'Daftar Akun'; ?></button>
        </form>
        
        <div class="link-switch">
        <?php if ($is_login_page): ?>
            Belum punya akun? <a href="login.php?action=register">Daftar Sekarang</a>
        <?php else: ?>
            Sudah punya akun? <a href="login.php">Kembali ke Login</a>
        <?php endif; ?>
        </div>
    </div>
</body>
</html>