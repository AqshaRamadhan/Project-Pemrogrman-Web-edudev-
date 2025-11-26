<?php
session_start();
include 'db_config.php';


if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'admin'; 
}

if (isset($_POST['add_course'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    $conn->query("INSERT INTO courses (judul, deskripsi) VALUES ('$judul', '$deskripsi')");
    header("Location: manage_courses.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM courses WHERE id = $id");
    header("Location: manage_courses.php");
    exit;
}

$editCourse = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editCourse = $conn->query("SELECT * FROM courses WHERE id = $id")->fetch_assoc();
}

if (isset($_POST['update_course'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    $conn->query("UPDATE courses 
                  SET judul='$judul', deskripsi='$deskripsi' 
                  WHERE id=$id");

    header("Location: manage_courses.php");
    exit;
}

$courses = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Kursus</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #4361ee;
            --secondary-color: #f0f3ff;
            --danger-color: #e63946;
            --success-color: #4CAF50;
            --text-color: #333;
        }

        body {
            font-family: 'Poppins';
            background-color: #f0f2f5;
            padding: 20px 40px;
            color: var(--text-color);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
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

        /* BUTTON NAVIGASI ATAS */
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

        input[type="text"], textarea {
            width: 95%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background: white;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: var(--primary-color);
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        button:hover {
            background-color: #2f4fd8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
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

        .action-btn {
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85em;
        }

        .edit-btn {
            color: white;
            background-color: var(--success-color);
            margin-right: 6px;
        }

        .edit-btn:hover {
            background-color: #3f8f42;
        }

        .delete-btn {
            color: white;
            background-color: var(--danger-color);
        }

        .delete-btn:hover {
            background-color: #c92830;
        }
    </style>
</head>

<body>

    <div class="header-container">
        <h2>Manajemen Kursus</h2>
        <div>
            <a href="manage_users.php" class="nav-btn">Manage Users</a>
            <a href="logout.php" class="btn-logout" onclick="return confirm('Yakin ingin logout?')">Logout</a>
        </div>
    </div>

    <div class="card">
        <h3>Tambah Kursus Baru</h3>
        <form method="POST">

            <div class="form-group">
                <label>Judul Kursus</label>
                <input type="text" name="judul" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" required></textarea>
            </div>

            <button type="submit" name="add_course">Tambah Kursus</button>
        </form>
    </div>

    <?php if ($editCourse): ?>
    <div class="card">
        <h3>Edit Kursus</h3>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $editCourse['id'] ?>">

            <div class="form-group">
                <label>Judul Kursus</label>
                <input type="text" name="judul" value="<?= $editCourse['judul'] ?>" required>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" required><?= $editCourse['deskripsi'] ?></textarea>
            </div>

            <button type="submit" name="update_course">Update Kursus</button>
        </form>
    </div>
    <?php endif; ?>

    <h3>Daftar Kursus</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>

        <?php while ($c = $courses->fetch_assoc()): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['judul'] ?></td>
            <td><?= $c['deskripsi'] ?></td>
            <td>
                <a href="manage_courses.php?edit=<?= $c['id'] ?>" class="action-btn edit-btn">Edit</a>
                <a href="manage_courses.php?delete=<?= $c['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Hapus kursus?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>