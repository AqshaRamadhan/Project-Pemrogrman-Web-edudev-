<?php
session_start();
include 'db_config.php';

// Cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak. Halaman ini hanya untuk admin.";
    exit;
}

/* ================================
   RESET PASSWORD USER
================================ */
if (isset($_GET['reset'])) {
    $id = $_GET['reset'];

    $new_pass_plain = "passwordbaru123";
    $new_pass_hash = password_hash($new_pass_plain, PASSWORD_BCRYPT);

    $conn->query("UPDATE users SET password = '$new_pass_hash' WHERE id = $id");

    echo "<script>
            alert('Password berhasil direset! Password baru: $new_pass_plain');
            window.location='manage_users.php';
          </script>";
    exit;
}

// CREATE user
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn->query("INSERT INTO users (username, password, nama_lengkap, role)
                  VALUES ('$username', '$password', '$nama_lengkap', '$role')");
    header("Location: manage_users.php");
    exit;
}

// DELETE user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: manage_users.php");
    exit;
}

// Ambil data user untuk EDIT
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();
}

// UPDATE user
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $role = $_POST['role'];

    $conn->query("UPDATE users SET 
                    username='$username',
                    nama_lengkap='$nama_lengkap',
                    role='$role'
                  WHERE id=$id");

    header("Location: manage_users.php");
    exit;
}

// Ambil semua user
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Pengguna</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #4361ee;
            --text-color: #333;
            --danger-color: #e63946;
            --success-color: #4CAF50;
        }

        body {
            font-family: 'Poppins';
            background: #f4f6f9;
            padding: 20px;
        }

        /* HEADER STYLE BARU */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 0 10px;
        }

        h2 {
            color: var(--primary-color);
            font-weight: 600;
            margin: 0;
        }

        h3 {
            color: var(--primary-color);
            font-weight: 600;
        }

        .container {
            padding: 20px 40px;
        }

        /* CARD */
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
            display: block;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        /* INPUT */
        input[type="text"], 
        input[type="password"],
        select,
        textarea {
            width: 95%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border 0.2s;
            background: white;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--primary-color);
        }

        button {
            background: var(--primary-color);
            padding: 10px 18px;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #304ad9;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        th {
            background: var(--primary-color);
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:hover td {
            background-color: #f6f8ff;
        }

        /* NAV & ACTION BUTTONS */
        .nav-btn {
            background: var(--primary-color);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-left: 10px;
            font-size: 0.9em;
        }

        .nav-btn:hover { background: #2f4fd8; }

        .btn-logout {
            background: var(--danger-color);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-left: 10px;
            font-size: 0.9em;
        }

        .btn-logout:hover { background: #c92830; }

        .action-btn {
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-right: 8px;
            display: inline-block;
        }

        .edit-btn { background: var(--success-color); color: white; }
        .delete-btn { background: var(--danger-color); color: white; }
        .reset-btn { background: #ffb703; color: black; }

        .edit-btn:hover { background: #3f8f42; }
        .delete-btn:hover { background: #c92830; }
        .reset-btn:hover { background: #e09a02; }
    </style>
</head>

<body>

<div class="header-container">
    <h2>Manajemen Pengguna</h2>
    <div>
        <a href="manage_courses.php" class="nav-btn">Manage Courses</a>
        <a href="logout.php" class="btn-logout" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </div>
</div>

<div class="card">
    <h3>Tambah Pengguna Baru</h3>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <button type="submit" name="add_user">Tambah User</button>
    </form>
</div>

<?php if ($editData): ?>
<div class="card">
    <h3>Edit Pengguna</h3>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $editData['id'] ?>">

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= $editData['username'] ?>" required>
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= $editData['nama_lengkap'] ?>">
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="mahasiswa" <?= $editData['role']=="mahasiswa"?"selected":"" ?>>Mahasiswa</option>
                <option value="dosen" <?= $editData['role']=="dosen"?"selected":"" ?>>Dosen</option>
                <option value="admin" <?= $editData['role']=="admin"?"selected":"" ?>>Admin</option>
            </select>
        </div>

        <button type="submit" name="update_user">Update User</button>
    </form>
</div>
<?php endif; ?>

<h3>Daftar Pengguna</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Nama Lengkap</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = $users->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['nama_lengkap'] ?></td>
        <td><?= $row['role'] ?></td>
        <td>
            <a class="action-btn edit-btn" href="manage_users.php?edit=<?= $row['id'] ?>">Edit</a>
            <a class="action-btn delete-btn" href="manage_users.php?delete=<?= $row['id'] ?>" onclick="return confirm('Hapus user?')">Delete</a>
            <a class="action-btn reset-btn" href="manage_users.php?reset=<?= $row['id'] ?>" onclick="return confirm('Reset password user ini?')">Reset</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>