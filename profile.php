<?php
session_start();
include 'db_config.php'; // Sesuaikan nama file config db kamu

// Cek Login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$msg = "";

// 1. PROSES UPDATE DATA JIKA TOMBOL DITEKAN
if (isset($_POST['update_profile'])) {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_nama     = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $new_pass     = $_POST['password']; // Password mentah

    // Cek apakah username sudah dipakai orang lain (selain diri sendiri)
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$new_username' AND id != $user_id");
    if (mysqli_num_rows($check) > 0) {
        $msg = "<div class='alert error'>Username sudah digunakan user lain!</div>";
    } else {
        // Logic Update Password
        if (!empty($new_pass)) {
            // Jika password diisi, hash password baru
            $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $query = "UPDATE users SET username='$new_username', nama_lengkap='$new_nama', password='$hashed_pass' WHERE id=$user_id";
        } else {
            // Jika password kosong, jangan ubah password
            $query = "UPDATE users SET username='$new_username', nama_lengkap='$new_nama' WHERE id=$user_id";
        }

        if (mysqli_query($conn, $query)) {
            // Update Session Data agar nama di navbar berubah realtime
            $_SESSION['username'] = $new_username;
            $_SESSION['nama_lengkap'] = $new_nama;
            $msg = "<div class='alert success'>Data profil berhasil diperbarui!</div>";
        } else {
            $msg = "<div class='alert error'>Gagal update: " . mysqli_error($conn) . "</div>";
        }
    }
}

// 2. AMBIL DATA USER SAAT INI UNTUK DITAMPILKAN DI FORM
$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$data   = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4361ee; --bg: #f0f2f5; --white: #fff; }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        
        .profile-card {
            background: var(--white);
            width: 100%; max-width: 500px;
            padding: 40px; border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        
        h2 { color: var(--primary); margin-top: 0; text-align: center; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .form-group input { 
            width: 100%; padding: 12px; border: 1px solid #ddd; 
            border-radius: 8px; box-sizing: border-box; font-family: inherit;
        }
        .form-group input:focus { border-color: var(--primary); outline: none; }
        
        .hint { font-size: 0.8rem; color: #888; margin-top: 5px; }

        .btn-save {
            width: 100%; padding: 12px; border: none; border-radius: 50px;
            background-color: var(--primary); color: white; font-weight: 600;
            cursor: pointer; transition: 0.3s;
        }
        .btn-save:hover { background-color: #2f45c5; }

        .btn-back {
            display: block; text-align: center; margin-top: 20px;
            color: #666; text-decoration: none; font-size: 0.9rem;
        }
        .btn-back:hover { color: var(--primary); }

        .alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; }
        .alert.success { background-color: #e8f5e9; color: #2e7d32; }
        .alert.error { background-color: #ffebee; color: #c62828; }
    </style>
</head>
<body>

    <div class="profile-card">
        <h2>Edit Profile</h2>
        
        <?php echo $msg; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?php echo htmlspecialchars($data['nama_lengkap']); ?>" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($data['username']); ?>" required>
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                <div class="hint">*Hanya isi jika ingin mengganti password login.</div>
            </div>

            <div class="form-group">
                <label>Role Akun</label>
                <input type="text" value="<?php echo strtoupper($data['role']); ?>" disabled style="background-color: #f9f9f9; color: #888;">
            </div>

            <button type="submit" name="update_profile" class="btn-save">Simpan Perubahan</button>
        </form>

        <a href="dashboard.php" class="btn-back">< Kembali ke Dashboard</a>
    </div>

</body>
</html>