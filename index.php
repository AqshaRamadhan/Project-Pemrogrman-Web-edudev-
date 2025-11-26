<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduDev - Jagonya Ngoding</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4361EE;
            --primary-dark: #2f45c5;
            --primary-light: #eef2ff;
            --secondary: #1B1F3B; 
            --text-dark: #121212; 
            --text-light: #6c757d; 
            --bg-light: #F5F7FA;
            --white: #ffffff;
            
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.05);
            --shadow-md: 0 8px 24px rgba(0,0,0,0.08);
            --radius: 12px;
            --radius-pill: 50px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html { 
            scroll-behavior: smooth; 
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--white);
            overflow-x: hidden;
        }

        a { text-decoration: none; color: inherit; transition: 0.3s; }
        ul { list-style: none; }
        img { max-width: 100%; display: block; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-padding { padding: 80px 0; }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: var(--radius-pill);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: var(--white);
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 10px;
        }

        .section-title p {
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        .badge {
            display: inline-block;
            padding: 5px 15px;
            background-color: var(--primary-light);
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            border-radius: var(--radius-pill);
            margin-bottom: 15px;
        }

        .hero {
            padding: 100px 0;
            background-color: var(--bg-light);
            position: relative;
            overflow: hidden;
        }

        .hero-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 50px;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            line-height: 1.2;
            color: var(--secondary);
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero-content h1 span { color: var(--primary); }

        .hero-content p {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 30px;
            max-width: 90%;
        }

        .hero-btns { display: flex; gap: 15px;}

        .hero-image img {
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .features { margin-top: -50px; position: relative; z-index: 10; }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .feature-card {
            background: var(--white);
            padding: 30px 20px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            text-align: center;
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.15);
        }

        .feature-icon {
            width: 60px; height: 60px;
            background-color: var(--primary-light);
            color: var(--primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 15px;
        }

        .feature-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--secondary);
        }

        .feature-card p { font-size: 0.9rem; color: var(--text-light); }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
        }

        .about-images {
            position: relative;
            height: 450px;
        }

        .about-img-1, .about-img-2 {
            position: absolute;
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            object-fit: cover;
        }

        .about-img-1 {
            width: 65%; height: 300px;
            top: 0; left: 0;
            z-index: 1;
        }

        .about-img-2 {
            width: 60%; height: 280px;
            bottom: 0; right: 0;
            border: 5px solid var(--white);
            z-index: 2;
        }

        .about-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .check-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            font-weight: 500;
            color: var(--secondary);
        }

        .check-list i { color: var(--primary); }

        .stats {
            background-color: var(--secondary);
            color: var(--white);
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary); 
            margin-bottom: 5px;
        }

        .stat-item p { font-size: 1.1rem; opacity: 0.9; }

        .courses { background-color: var(--bg-light); }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .course-card {
            background: var(--white);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: 0.3s;
            border: 1px solid #eee;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .course-thumb {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .course-content { padding: 20px; }

        .course-meta {
            display: flex; justify-content: space-between;
            margin-bottom: 10px; font-size: 0.85rem; color: var(--text-light);
        }

        .course-content h3 {
            font-size: 1.25rem;
            margin-bottom: 10px;
            font-weight: 700;
            color: var(--secondary);
        }

        .rating { color: #ffc107; font-size: 0.9rem; margin-bottom: 15px; }

        .course-footer {
            display: flex; justify-content: space-between; align-items: center;
            border-top: 1px solid #eee; padding-top: 15px;
        }

        .price { color: var(--primary); font-weight: 700; font-size: 1.1rem; }

        .btn-link { color: var(--secondary); font-weight: 600; font-size: 0.9rem; }
        .btn-link:hover { color: var(--primary); }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .testi-card {
            background: var(--white);
            padding: 40px 30px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid #f0f0f0;
            transition: all 0.4s ease; 
            position: relative;
            top: 0;
        }
        .testi-card:hover {
            top: -10px; 
            box-shadow: 0 15px 30px rgba(67, 97, 238, 0.15); 
            border-color: var(--primary-light);
        }

        .testi-card::before {
            content: '\f10d'; 
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 3rem;
            color: var(--primary-light);
            opacity: 0.5;
            transition: 0.3s;
        }

        .testi-card:hover::before {
            color: var(--primary); 
            opacity: 0.2;
        }

        .stars { color: #ffc107; margin-bottom: 20px; }
        .testi-text {
            font-style: italic;
            color: var(--text-light);
            margin-bottom: 25px;
            font-size: 0.95rem;
            line-height: 1.7;
        }
        .user-profile { display: flex; align-items: center; gap: 15px; }
        .user-img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid var(--white); box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .user-info h4 { font-size: 1rem; margin-bottom: 2px; color: var(--secondary); }
        .user-info span { font-size: 0.85rem; color: var(--text-light); }

        .instructors { background-color: var(--bg-light); }

        .inst-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .inst-card {
            background: var(--white);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            border: 1px solid transparent;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        
        .inst-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(67, 97, 238, 0.15);
            border-color: var(--primary-light);
        }

        .inst-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 4px;
            background: var(--primary);
            transform: scaleX(0); 
            transition: transform 0.4s ease;
            transform-origin: left;
        }

        .inst-card:hover::after {
            transform: scaleX(1); 
        }

        .inst-img-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 20px;
        }

        .inst-img {
            width: 100%; height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary-light);
            transition: all 0.4s ease;
        }
        
        .inst-card:hover .inst-img {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .inst-role {
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 700;
            display: block;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .inst-card h4 {
            font-size: 1.2rem;
            color: var(--secondary);
            margin-bottom: 15px;
        }

        .inst-socials {
            display: flex;
            justify-content: center;
            gap: 10px;
            opacity: 0; 
            transform: translateY(20px); 
            transition: all 0.4s ease 0.1s; 
        }

        .inst-card:hover .inst-socials {
            opacity: 1; 
            transform: translateY(0); 
        }

        .inst-socials a {
            width: 35px; height: 35px;
            background: var(--bg-light);
            color: var(--text-light);
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .inst-socials a:hover {
            background: var(--primary);
            color: var(--white);
            transform: rotate(360deg);}

        @media (max-width: 1024px) {
            .features-grid, .stats-grid, .inst-grid { grid-template-columns: repeat(2, 1fr); }
            .courses-grid, .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
            .hero h1 { font-size: 2.8rem; }
        }

        @media (max-width: 768px) {
            .mobile-toggle { display: block; }
            .hero-wrapper, .about-grid { grid-template-columns: 1fr; text-align: center; }
            .hero-btns { justify-content: center; }
            .about-images { display: none; } 
            .features-grid, .stats-grid, .courses-grid, .testimonials-grid, .inst-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; gap: 30px; }
        }
        
        @media (max-width: 992px) {
            .hero-wrapper, .about-grid { grid-template-columns: 1fr; text-align: center; }
            .features-grid, .stats-grid, .inst-grid { grid-template-columns: repeat(2, 1fr); }
            .courses-grid, .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
            .about-images { display: none; } 
        }

        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .mobile-toggle { display: block; }
            .features-grid, .stats-grid, .courses-grid, .testimonials-grid, .inst-grid, .footer-grid { grid-template-columns: 1fr; }
            .hero-content h1 { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

    <section id="home" class="hero">
        <div class="container hero-wrapper">
            <div class="hero-content">
                <span class="badge">Platform Kursus Online Programming Terbaik!!</span>
                <h1>Mulai Petualanganmu Bersama <span>EduDev</span></h1>
                <p>Kuasai HTML, CSS, Python, JavaScript, and Databases. Bangun proyek nyata kamu dan mulailah karier teknologi dengan kursus yang dipandu oleh para ahli kami.</p>
                <div class="hero-btns">
                    <a href="login.php" class="btn btn-primary">Mulai Kursus</a>
                    <a href="#courses" class="btn btn-outline">Cari Kursus</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Coding Student">
            </div>
        </div>
    </section>

    <div class="container features">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Scholarship Facility</h3>
                <p>Bantuan keuangan tersedia untuk siswa berbakat di seluruh Indonesia.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h3>Pengajar Ahli</h3>
                <p>Belajar langsung dari profesional industri dan senior.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-laptop-code"></i></div>
                <h3>Project Based</h3>
                <p>Bangun portofolio aplikasi nyata saat Anda belajar.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-wallet"></i></div>
                <h3>Harga Terjangkau</h3>
                <p>Kursus berkualitas premium dengan biaya yang jauh lebih murah.</p>
            </div>
        </div>
    </div>

    <section id="about" class="section-padding">
        <div class="container about-grid">
            <div class="about-images">
                <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Students" class="about-img-1">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Learning" class="about-img-2">
            </div>
            <div class="about-content">
                <span class="badge">Tentang Kami</span>
                <h2>Sistem Kursus Kami Memberikan Inspirasi Lebih.</h2>
                <p style="margin-bottom: 20px; color: var(--text-light);">EduDev berkomitmen untuk menyediakan pendidikan teknologi terkini. Kami menggabungkan teori dengan praktik langsung untuk memastikan Anda siap bekerja.</p>
                <ul class="check-list">
                    <li><i class="fas fa-check-circle"></i> Lingkungan Pemrograman yang Positif</li>
                    <li><i class="fas fa-check-circle"></i> Akses Seumur Hidup ke Materi Kursus</li>
                    <li><i class="fas fa-check-circle"></i> Bimbingan Karier & Pembuatan CV</li>
                </ul>
                <a href="login.php" class="btn btn-primary" style="margin-top: 25px;">Lihat Detail</a>
            </div>
        </div>
    </section>

    <section class="section-padding stats">
        <div class="container">
            <div class="mobile-toggle"></div>
            <div class="stats-grid">
                <div class="stat-item">
                    <h3 class="counter" data-target="100">0</h3>
                    <p>Total Kursus</p>
                </div>
                <div class="stat-item">
                    <h3 class="counter" data-target="1000">0</h3>
                    <p>Pelajar Active</p>
                </div>
                <div class="stat-item">
                    <h3 class="counter" data-target="50">0</h3>
                    <p>Pengajar Ahli</p>
                </div>
                <div class="stat-item">
                    <h3 class="counter" data-target="30">0</h3>
                    <p>Penghargaan yang Diperoleh</p>
                </div>
            </div>
        </div>
    </section>

    <section id="courses" class="section-padding courses">
        <div class="container">
            <div class="section-title">
                <span class="badge">Our Courses</span>
                <h2>Lihat Semua Kursus Kami</h2>
                <p>Jelajahi kursus pemrograman terbaik kami yang dirancang untuk semua tingkat keahlian.</p>
            </div>

            <div class="courses-grid">
                <div class="course-card">
                    <img src="https://images.unsplash.com/photo-1621839673705-6617adf9e890?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="HTML" class="course-thumb">
                    <div class="course-content">
                        <div class="course-meta">
                            <span><i class="far fa-clock"></i> 5 Jam</span>
                            <span>Pemula (Beginner)</span>
                        </div>
                        <h3>Dasar-dasar HTML5</h3>
                        <p class="rating"><i class="fas fa-star"></i> 4.8 (120 ulasan)</p>
                        <div class="course-footer">
                            <a href="login.php" class="btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <img src="https://images.unsplash.com/photo-1507721999472-8ed4421c4af2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="CSS" class="course-thumb">
                    <div class="course-content">
                        <div class="course-meta">
                            <span><i class="far fa-clock"></i> 8 Jam</span>
                            <span>Menengah (Intermediate)</span>
                        </div>
                        <h3>CSS3 Mastery & Grid</h3>
                        <p class="rating"><i class="fas fa-star"></i> 4.9 (95 ulasan)</p>
                        <div class="course-footer">
                            <a href="login.php" class="btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <img src="https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="JS" class="course-thumb">
                    <div class="course-content">
                        <div class="course-meta">
                            <span><i class="far fa-clock"></i> 12 Jam</span>
                            <span>All Levels</span>
                        </div>
                        <h3>JavaScript </h3>
                        <p class="rating"><i class="fas fa-star"></i> 4.7 (200 ulasan)</p>
                        <div class="course-footer">
                            <a href="login.php" class="btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <img src="https://images.unsplash.com/photo-1526379095098-d400fd0bf935?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Python" class="course-thumb">
                    <div class="course-content">
                        <div class="course-meta">
                            <span><i class="far fa-clock"></i> 15 jam</span>
                            <span>Pemula (Beginner)</span>
                        </div>
                        <h3>Python </h3>
                        <p class="rating"><i class="fas fa-star"></i> 4.9 (310 ulasan)</p>
                        <div class="course-footer">
                            <a href="login.php" class="btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <img src="https://images.unsplash.com/photo-1544383835-bda2bc66a55d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="SQL" class="course-thumb">
                    <div class="course-content">
                        <div class="course-meta">
                            <span><i class="far fa-clock"></i> 6 Jam</span>
                            <span>Menengah (Intermediate)</span>
                        </div>
                        <h3>SQL Database </h3>
                        <p class="rating"><i class="fas fa-star"></i> 4.6 (80 ulasan)</p>
                        <div class="course-footer">
                            <a href="login.php" class="btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="React" class="course-thumb">
                    <div class="course-content">
                        <div class="course-meta">
                            <span><i class="far fa-clock"></i> 10 Jam</span>
                            <span>Profesional (Advanced)</span>
                        </div>
                        <h3>React Development</h3>
                        <p class="rating"><i class="fas fa-star"></i> 4.9 (150 ulasan)</p>
                        <div class="course-footer">
                            <a href="login.php" class="btn-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="section-title">
                <span class="badge">Testimoni</span>
                <h2>Dari Pelajar untuk Kami</h2>
            </div>

            <div class="testimonials-grid">
                <div class="testi-card">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testi-text">"Honestly, I didn’t expect much from an online course. Most of them are… you know, pretty boring.
                    But EduDev is surprisingly decent. Penjelasannya jelas, materinya runtut, dan yang paling penting, nggak bikin pusing dengan hal-hal yang nggak penting.
                    Yeah… don’t get the wrong idea, I’m not ‘excited’ or anything.
                    It’s just… effective. And I like that."</p>
                    <div class="user-profile">
                        <img src="https://th.bing.com/th/id/OIP.fmFz4gCAVcmX7b1BfZDVlQHaEA?w=308&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3" alt="User" class="user-img">
                        <div class="user-info">
                            <h4>Kei Rendra Permana </h4>
                            <span>Web Developer</span>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="testi-text">"WAAAH!!! Belajar di EduDev tuh seruuuu banget!!
                    Aku pikir coding itu susah, tapi ternyata pas diajarin step by step… aku bisa!
                    “HTML?! CSS?! JAVASCRIPT?! I DID ITTT!!”
                    Instrukturnya juga ramah banget. Cara mereka jelasin itu nggak bikin bingung sama sekali.
                    Kalau aku bingung, mereka kasih contoh yang simple terus jadi paham
                    Aku jadi pengen belajar lebih banyak lagi—React, Database, Python… SEMUANYAAA!
                    Pokoknya EduDev bikin aku makin semangat ngejar mimpi! LET’S GOOO!!! 🔥🔥🔥"</p>
                    <div class="user-profile">
                        <img src="https://th.bing.com/th/id/OIP.WyLRiXUzXniJ64NnquGgUQHaHa?w=150&h=180&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3" alt="User" class="user-img">
                        <div class="user-info">
                            <h4>Hinata Surya Mahardika </h4>
                            <span>Mahasiswa Informatika semester 3</span>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="testi-text">"Aku suka hal yang jelas dan langsung ke point.
                    EduDev ngasih materi yang strukturnya rapi, gampang dipahami, dan nggak muter-muter.
                    Latihan kodenya juga bikin aku ngerti lebih cepat.
                    Kalau aku stuck, ada penjelasan tambahan yang detail.
                    I think it’s good.
                    Very good.
                    I want to be better, so… I’ll continue the course."</p>
                    <div class="user-profile">
                        <img src="https://th.bing.com/th/id/OIP.QniNt0OhJa53UDXGj8AyfwHaEK?w=329&h=187&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3" alt="User" class="user-img">
                        <div class="user-info">
                            <h4>Tobio Pratama Siregar</h4>
                            <span>Backend Developer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding instructors">
        <div class="container">
            <div class="section-title">
                <span class="badge">Pengajar</span>
                <h2>Meet With Our Expert Teachers</h2>
            </div>

            <div class="inst-grid">
                <div class="inst-card">
                    <div class="inst-img-wrapper">
                        <img src="https://tse3.mm.bing.net/th/id/OIP.kzD9qmOY6F65rfe3Isi-zAHaHa?w=187&h=187&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3" alt="Instructor" class="inst-img">
                    </div> <span class="inst-role">Fullstack Dev</span>
                    <h4>Akaashi Rama Adinata, S.Kom., M.Kom.</h4>
                    <div class="inst-socials">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="inst-card">
                    <div class="inst-img-wrapper">
                    <img src="https://tse3.mm.bing.net/th/id/OIP.BqjoW7GzWQmnKZxk-bpKIQHaJK?w=202&h=251&c=7&r=0&o=7&dpr=1.1&pid=1.7&rm=3" alt="Instructor" class="inst-img">
                    </div>
                    <span class="inst-role">Python Specialist</span>
                    <h4>Dr. Kenji Mahendra Putra, S.Kom., M.Kom</h4>
                    <div class="inst-socials">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="inst-card">
                    <div class="inst-img-wrapper">
                    <img src="https://tse1.mm.bing.net/th/id/OIP.iqOsjzYwt90DScUFbO-ctgAAAA?w=203&h=197&c=7&r=0&o=7&pid=1.7&rm=3" alt="Instructor" class="inst-img">
                    </div>
                    <span class="inst-role">Database Engineer</span>
                    <h4>Dr. Daichi Junaedi Firmansyah, S.Kom., M.Kom</h4>
                    <div class="inst-socials">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="inst-card">
                    <div class="inst-img-wrapper">
                    <img src="https://tse1.mm.bing.net/th/id/OIP.YOH59WJDhNpeFvclkvF1lQHaHa?w=175&h=180&c=7&r=0&o=7&pid=1.7&rm=3" alt="Instructor" class="inst-img">
                    </div>
                    <span class="inst-role">Frontend Lead</span>
                    <h4>Kuro Rangga Mahesa, S.Kom., M.Kom</h4>
                    <div class="inst-socials">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="inst-card">
                    <div class="inst-img-wrapper">
                    <img src="https://tse3.mm.bing.net/th/id/OIP.dhsBSJrHQS852dBSCo87TgHaHe?w=167&h=180&c=7&r=0&o=7&pid=1.7&rm=3" alt="Instructor" class="inst-img">
                    </div>
                    <span class="inst-role">Backend Developer</span>
                    <h4>Oikawa Kevin Dharmawan,S.Kom., M.Kom.</h4>
                    <div class="inst-socials">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        const toggle = document.querySelector('.mobile-toggle');

        const counters = document.querySelectorAll('.counter');
        const speed = 200; 

        const runAnimation = (counter) => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText.replace('+', ''); 

                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc); 
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target + "+"; 
                }
            };
            updateCount();
        };

        const sectionObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    runAnimation(counter);
                    observer.unobserve(counter);
                }
            });
        }, {
            threshold: 0.5 
        });
        
        counters.forEach(counter => {
            sectionObserver.observe(counter);
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const headerOffset = 80; 
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            });
        });
    </script>
</body>
</html>