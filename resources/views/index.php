<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PT. Gesang Sukses Makmur — Sistem Manajemen & Permesinan Presisi</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --navy-dark: #0A192F;
    --navy-main: #0F2B5C;
    --navy-light: #1E3E7A;
    --blue-accent: #3066BE;
    --blue-glow: #64DFDF;
    --cream: #F4F6F9;
    --cream-dark: #E1E6F0;
    --ink: #0F172A;
    --ink-mid: #334155;
    --ink-muted: #64748B;
    --white: #FFFFFF;
    --border: rgba(15, 43, 92, 0.1);
    --border-strong: rgba(15, 43, 92, 0.25);
  }

  html { scroll-behavior: smooth; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--ink);
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* ── NAV ── */
  nav {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 5vw;
    height: 70px;
    background: rgba(10, 25, 47, 0.95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .nav-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }

  .nav-logo {
    width: 38px;
    height: 38px;
    background: var(--blue-accent);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .nav-logo svg { width: 22px; height: 22px; fill: white; }

  .nav-brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.1;
  }

  .nav-brand-top {
    font-family: 'Playfair Display', serif;
    font-size: 16px;
    font-weight: 700;
    color: var(--white);
    letter-spacing: 0.02em;
  }

  .nav-brand-sub {
    font-size: 10px;
    font-weight: 400;
    color: var(--blue-glow);
    letter-spacing: 0.06em;
    text-transform: uppercase;
  }

  .nav-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 22px;
    background: var(--blue-accent);
    color: white;
    font-family: 'DM Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 500;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    letter-spacing: 0.02em;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 4px 12px rgba(48, 102, 190, 0.2);
  }

  .nav-btn:hover { background: var(--blue-glow); color: var(--navy-dark); transform: translateY(-1px); }

  /* ── HERO ── */
  .hero {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    padding: 70px 5vw 0;
    gap: 4rem;
    position: relative;
    background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-main) 100%);
    color: var(--white);
    overflow: hidden;
  }

  .hero::before {
    content: '';
    position: absolute;
    top: -80px; right: -120px;
    width: 600px; height: 600px;
    background: radial-gradient(ellipse at center, rgba(100, 223, 223, 0.1) 0%, transparent 70%);
    pointer-events: none;
  }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px 5px 8px;
    background: rgba(100, 223, 223, 0.1);
    border: 1px solid rgba(100, 223, 223, 0.25);
    border-radius: 100px;
    font-size: 12px;
    font-weight: 500;
    color: var(--blue-glow);
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin-bottom: 1.6rem;
  }

  .hero-badge-dot {
    width: 6px; height: 6px;
    background: var(--blue-glow);
    border-radius: 50%;
    flex-shrink: 0;
  }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.4rem, 4vw, 3.6rem);
    font-weight: 700;
    line-height: 1.15;
    color: var(--white);
    margin-bottom: 1.4rem;
  }

  .hero-title em {
    font-style: normal;
    color: var(--blue-glow);
  }

  .hero-desc {
    font-size: 16px;
    font-weight: 300;
    line-height: 1.75;
    color: rgba(255, 255, 255, 0.75);
    max-width: 480px;
    margin-bottom: 2.4rem;
  }

  .hero-cta {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
  }

  .btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 32px;
    background: var(--blue-accent);
    color: white;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    border-radius: 7px;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    box-shadow: 0 4px 18px rgba(48, 102, 190, 0.4);
  }

  .btn-primary:hover {
    background: var(--blue-glow);
    color: var(--navy-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(100, 223, 223, 0.4);
  }

  .btn-primary svg { width: 16px; height: 16px; }

  .btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 14px 24px;
    background: transparent;
    color: var(--white);
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 400;
    border-radius: 7px;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: border-color 0.2s, background 0.2s;
  }

  .btn-ghost:hover {
    border-color: var(--white);
    background: rgba(255, 255, 255, 0.05);
  }

  /* ── HERO VISUAL (DASHBOARD PREVIEW CARD) ── */
  .hero-visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .hero-card-stack {
    position: relative;
    width: 100%;
    max-width: 440px;
  }

  .hcard {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    padding: 24px;
    position: relative;
  }

  .hcard-main {
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    z-index: 3;
  }

  .hcard-behind {
    position: absolute;
    top: -14px; left: 20px; right: 20px;
    background: rgba(15, 43, 92, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 14px;
    height: 60px;
    z-index: 2;
  }

  .hcard-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--blue-glow);
    margin-bottom: 12px;
  }

  .hcard-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
  }

  .hcard-name {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 600;
    color: var(--white);
  }

  .hcard-status {
    padding: 4px 10px;
    background: rgba(100, 223, 223, 0.15);
    border: 1px solid var(--blue-glow);
    border-radius: 100px;
    font-size: 11px;
    font-weight: 500;
    color: var(--blue-glow);
  }

  .hcard-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.1);
    margin: 14px 0;
  }

  .hcard-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }

  .hcard-stat-item {
    text-align: left;
    padding: 12px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.05);
  }

  .hcard-stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 15px;
    font-weight: 600;
    color: var(--white);
    display: block;
    margin-bottom: 4px;
  }

  .hcard-stat-label {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.6);
    line-height: 1.4;
    display: block;
  }

  /* ── STATS STRIP ── */
  .stats-strip {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background: var(--border-strong);
    border-top: 1px solid var(--border-strong);
    border-bottom: 1px solid var(--border-strong);
  }

  .stat-item {
    background: var(--white);
    padding: 2.4rem 2rem;
    text-align: center;
  }

  .stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--navy-main);
    display: block;
    margin-bottom: 4px;
  }

  .stat-label {
    font-size: 12px;
    font-weight: 500;
    color: var(--ink-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  /* ── SECTIONS GENERAL ── */
  .section {
    padding: 6rem 5vw;
  }

  .section-header {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 4rem;
  }

  .section-tag {
    display: inline-block;
    padding: 4px 14px;
    background: rgba(15, 43, 92, 0.06);
    border: 1px solid var(--border-strong);
    border-radius: 100px;
    font-size: 11.5px;
    font-weight: 600;
    color: var(--navy-main);
    letter-spacing: 0.07em;
    text-transform: uppercase;
    margin-bottom: 1rem;
  }

  .section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 3vw, 2.6rem);
    font-weight: 700;
    color: var(--navy-dark);
    line-height: 1.2;
    margin-bottom: 1rem;
  }

  .section-desc {
    font-size: 15.5px;
    font-weight: 300;
    line-height: 1.75;
    color: var(--ink-muted);
  }

  /* ── SEJARAH & PROFIL ── */
  .profile-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
  }
  
  .profile-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: var(--navy-main);
    margin-bottom: 1rem;
  }

  .profile-content p {
    font-size: 15px;
    line-height: 1.75;
    color: var(--ink-mid);
    margin-bottom: 1.2rem;
    text-align: justify;
  }

  .visimisi-box {
    background: var(--navy-dark);
    color: var(--white);
    padding: 2.5rem;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(10,25,47,0.1);
  }

  .visimisi-item {
    margin-bottom: 1.5rem;
  }

  .visimisi-item:last-child { margin-bottom: 0; }

  .visimisi-item h4 {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    color: var(--blue-glow);
    margin-bottom: 0.5rem;
  }

  .visimisi-item p, .visimisi-item ol {
    font-size: 14.5px;
    color: rgba(255,255,255,0.8);
    line-height: 1.6;
    padding-left: 1.2rem;
  }

  /* ── LAYANAN / FITUR ── */
  .features-bg { background: var(--white); }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
  }

  .feature-card {
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 2rem;
    transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
  }

  .feature-card:hover {
    border-color: var(--blue-accent);
    transform: translateY(-4px);
    box-shadow: 0 10px 32px rgba(15, 43, 92, 0.08);
  }

  .feature-icon {
    width: 48px; height: 48px;
    background: rgba(15, 43, 92, 0.06);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.2rem;
  }

  .feature-icon svg {
    width: 24px; height: 24px;
    stroke: var(--navy-main);
    fill: none;
    stroke-width: 1.5;
  }

  .feature-title {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 600;
    color: var(--navy-dark);
    margin-bottom: 8px;
  }

  .feature-desc {
    font-size: 14px;
    font-weight: 300;
    line-height: 1.7;
    color: var(--ink-mid);
  }

  /* ── FLOW ── */
  .flow-bg { background: var(--cream-dark); }

  .flow-steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px;
    background: rgba(15, 43, 92, 0.1);
  }

  .flow-step {
    background: var(--cream);
    padding: 2.5rem 1.6rem;
    text-align: center;
  }

  .flow-num {
    width: 40px; height: 40px;
    background: var(--navy-main);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 16px;
    font-weight: 700;
    color: var(--white);
    margin: 0 auto 1.2rem;
  }

  .flow-step-title {
    font-weight: 600;
    font-size: 16px;
    color: var(--navy-dark);
    margin-bottom: 6px;
  }

  .flow-step-desc {
    font-size: 13.5px;
    font-weight: 300;
    color: var(--ink-mid);
    line-height: 1.6;
  }

  /* ── CTA BANNER (EXCLUSIVE TO DASHBOARD LOGIN) ── */
  .cta-banner {
    background: var(--navy-dark);
    padding: 6rem 5vw;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-top: 3px solid var(--blue-accent);
  }

  .cta-banner::before {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 600px; height: 300px;
    background: radial-gradient(ellipse, rgba(48, 102, 190, 0.2) 0%, transparent 70%);
    pointer-events: none;
  }

  .cta-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 700;
    color: var(--white);
    margin-bottom: 1rem;
    position: relative;
  }

  .cta-title em { font-style: normal; color: var(--blue-glow); }

  .cta-subtitle {
    font-size: 16px;
    font-weight: 300;
    color: rgba(255,255,255,0.75);
    margin-bottom: 2.4rem;
    position: relative;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }

  .cta-actions {
    display: flex;
    justify-content: center;
    gap: 14px;
    flex-wrap: wrap;
    position: relative;
  }

  /* ── FOOTER ── */
  footer {
    background: #060F1E;
    padding: 3rem 5vw;
    color: rgba(255,255,255,0.6);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
  }

  .footer-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 2rem;
    margin-bottom: 2rem;
  }

  .footer-info h4 {
    color: var(--white);
    font-family: 'Playfair Display', serif;
    margin-bottom: 0.5rem;
  }

  .footer-info p {
    font-size: 13.5px;
    line-height: 1.6;
    max-width: 400px;
  }

  .footer-links {
    display: flex;
    gap: 40px;
  }

  .footer-group h5 {
    color: var(--blue-glow);
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.05em;
    margin-bottom: 0.8rem;
  }

  .footer-group ul {
    list-style: none;
  }

  .footer-group ul li {
    margin-bottom: 0.5rem;
  }

  .footer-group a {
    font-size: 13px;
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    transition: color 0.2s;
  }

  .footer-group a:hover { color: var(--white); }

  .footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid rgba(255,255,255,0.05);
    padding-top: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 12.5px;
  }

  /* ── RESPONSIVE ── */
  @media (max-width: 900px) {
    .hero { grid-template-columns: 1fr; padding-top: 100px; min-height: auto; padding-bottom: 4rem; }
    .hero-visual { display: none; }
    .profile-container { grid-template-columns: 1fr; gap: 2rem; }
    .features-grid { grid-template-columns: 1fr 1fr; }
    .flow-steps { grid-template-columns: 1fr; }
    .stats-strip { grid-template-columns: 1fr 1fr; }
  }

  @media (max-width: 560px) {
    .features-grid { grid-template-columns: 1fr; }
    .stats-strip { grid-template-columns: 1fr; }
  }
</style>
</head>
<body>

<nav>
  <a href="#" class="nav-brand">
    <div class="nav-logo">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="white" stroke-width="2" fill="none"/>
      </svg>
    </div>
    <div class="nav-brand-text">
      <span class="nav-brand-top">PT. Gesang Sukses Makmur</span>
      <span class="nav-brand-sub">Sistem internal Terintegrasi</span>
    </div>
  </a>
  <a href="/login" class="nav-btn">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
    </svg>
    Masuk ke Dashboard
  </a>
</nav>

<section class="hero">
  <div class="hero-content">
    <div class="hero-badge">
      <span class="hero-badge-dot"></span>
      Enterprise Resource Planning & Manufacturing
    </div>
    <h1 class="hero-title">Kelola Operasional Produksi dalam <em>Satu Dashboard</em></h1>
    <p class="hero-desc">
      Sistem manajemen internal terpusat untuk memantau alur manufaktur presisi, penjadwalan mesin bubut/milling, kendali mutu (QC), hingga pelacakan logistik komponen secara real-time.
    </p>
    <div class="hero-cta">
      <a href="/login" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
        </svg>
        Buka Dashboard Sistem
      </a>
      <a href="#profil" class="btn-ghost">Profil Perusahaan</a>
    </div>
  </div>

  <div class="hero-visual">
    <div class="hero-card-stack">
      <div class="hcard-behind"></div>
      <div class="hcard hcard-main">
        <p class="hcard-label">Ringkasan Sistem Internal</p>
        <div class="hcard-row">
          <span class="hcard-name">Fasilitas Manufaktur</span>
          <span class="hcard-status">Sistem Aktif</span>
        </div>
        <div class="hcard-divider"></div>
        <div class="hcard-stats">
          <div class="hcard-stat-item">
            <span class="hcard-stat-num">Modul Bubut & Frais</span>
            <span class="hcard-stat-label">Pantau antrean komponen silindris & blok presisi.</span>
          </div>
          <div class="hcard-stat-item">
            <span class="hcard-stat-num">Quality Control</span>
            <span class="hcard-stat-label">Integrasi data kalibrasi alat ukur & log inspeksi mikro.</span>
          </div>
        </div>
        <div class="hcard-divider"></div>
        <div style="display:flex; justify-content:space-between; align-items:center;">
          <span style="font-size:11px; color:rgba(255,255,255,0.5);">Akses Terenkripsi</span>
          <span style="font-size:12px; font-weight:500; color:var(--blue-glow);">Khusus Karyawan & Mitra</span>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="stats-strip">
  <div class="stat-item">
    <span class="stat-num">Cloud-Based</span>
    <span class="stat-label">Akses Aman Kapan Saja</span>
  </div>
  <div class="stat-item">
    <span class="stat-num">Real-Time</span>
    <span class="stat-label">Pelacakan Status Job Desk</span>
  </div>
  <div class="stat-item">
    <span class="stat-num">Terintegrasi</span>
    <span class="stat-label">Modul Mesin & Logistik</span>
  </div>
  <div class="stat-item">
    <span class="stat-num">Presisi</span>
    <span class="stat-label">Metrik Toleransi Digital</span>
  </div>
</div>

<section class="section" id="profil">
  <div class="section-header">
    <span class="section-tag">Profil Perusahaan</span>
    <h2 class="section-title">Berdedikasi untuk Kebutuhan Manufaktur Indonesia</h2>
  </div>

  <div class="profile-container">
    <div class="profile-content">
      <h3>Sejarah & Perkembangan</h3>
      <p>
        PT. Gesang Sukses Makmur adalah perusahaan swasta nasional yang bergerak di bidang manufaktur komponen presisi, sub-assembly, serta fabrikasi logam. Berawal dari workshop skala kecil, perusahaan secara konsisten berinvestasi pada peningkatan keahlian SDM dan pembaruan permesinan konvensional maupun modern.
      </p>
      <p>
        Melalui komitmen kuat terhadap ketepatan dimensi dan efisiensi waktu pengerjaan, PT. Gesang Sukses Makmur kini didukung oleh infrastruktur digital internal terpadu guna memastikan transparansi proses manufaktur suku cadang, pembuatan mold & die, serta custom part terikat spesifikasi teknis ketat.
      </p>
    </div>
    
    <div class="visimisi-box">
      <div class="visimisi-item">
        <h4>Visi Perusahaan</h4>
        <p>Menjadi perusahaan manufaktur komponen presisi yang unggul, terpercaya, dan berdaya saing global dengan mengutamakan kualitas, inovasi teknologi, serta kepuasan pelanggan secara berkelanjutan.</p>
      </div>
      <div class="visimisi-item">
        <h4>Misi Perusahaan</h4>
        <ol>
          <li>Menyediakan produk permesinan dengan tingkat akurasi tinggi sesuai standar kebutuhan industri spesifik.</li>
          <li>Mengembangkan kompetensi teknis dan profesionalisme tenaga kerja lokal.</li>
          <li>Menerapkan manajemen berbasis data digital terpadu untuk efisiensi produksi yang maksimal.</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="section features-bg" id="layanan">
  <div class="section-header">
    <span class="section-tag">Kapabilitas Modul</span>
    <h2 class="section-title">Pusat Kendali Operasional Permesinan</h2>
    <p class="section-desc">Dashboard mengintegrasikan seluruh lini produksi permesinan utama guna meminimalisir kesalahan fabrikasi di workshop.</p>
  </div>

  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor" width="24" height="24"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 2v20M2 12h20" stroke-width="1.5"/></svg>
      </div>
      <h3 class="feature-title">Manajemen Bubut (Turning)</h3>
      <p class="feature-desc">Pantau parameter potong material silindris untuk pembuatan poros, ulir, dan bentuk tirus simetris putar langsung lewat lembar monitor digital.</p>
    </div>

    <div class="feature-card">
      <div class="feature-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor" width="24" height="24"><rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/><path d="M9 3v18M15 3v18M3 9h18M3 15h18" stroke-width="1.5"/></svg>
      </div>
      <h3 class="feature-title">Penjadwalan Frais (Milling)</h3>
      <p class="feature-desc">Atur antrean pengerjaan blok tiga dimensi, alur pasak, dan roda gigi straight/helical pada mesin frais demi optimalisasi penggunaan waktu kerja alat.</p>
    </div>

    <div class="feature-card">
      <div class="feature-icon">
        <svg viewBox="0 0 24 24" stroke="currentColor" width="24" height="24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <h3 class="feature-title">Validasi Mutu & Ukuran</h3>
      <p class="feature-desc">Input dan verifikasi data hasil ukur mikro komponen untuk menjamin deviasi dimensi tetap berada di dalam batas toleransi cetak biru yang diminta.</p>
    </div>
  </div>
</section>

<section class="section flow-bg">
  <div class="section-header">
    <span class="section-tag">Alur Transparansi</span>
    <h2 class="section-title">Siklus Pemrosesan Data di Sistem</h2>
    <p class="section-desc">Bagaimana alur instruksi kerja ditransmisikan dari dashboard pusat ke mesin-mesin di lantai produksi.</p>
  </div>

  <div class="flow-steps">
    <div class="flow-step">
      <div class="flow-num">1</div>
      <p class="flow-step-title">Unggah Gambar & Blueprint</p>
      <p class="flow-step-desc">Spesifikasi teknis, toleransi ukuran mikro, dan jenis material diunggah ke sistem untuk dianalisis kebutuhan alat potongnya.</p>
    </div>
    <div class="flow-step">
      <div class="flow-num">2</div>
      <p class="flow-step-title">Eksekusi Lantai Produksi</p>
      <p class="flow-step-desc">Operator mesin bubut atau frais menjalankan perintah manufaktur berdasarkan lembar instruksi digital yang terbit di dashboard.</p>
    </div>
    <div class="flow-step">
      <div class="flow-num">3</div>
      <p class="flow-step-title">Verifikasi QC & Logistik</p>
      <p class="flow-step-desc">Hasil akhir divalidasi silang oleh bagian kendali mutu, datanya dikunci di sistem, dan status part diubah siap untuk dikemas.</p>
    </div>
  </div>
</section>

<section class="cta-banner" id="kontak">
  <h2 class="cta-title">Siap Mengelola Proyek <em>Manufaktur</em> Hari Ini?</h2>
  <p class="cta-subtitle">Otorisasi akun Anda diperlukan untuk mengakses modul pengerjaan komponen presisi, log permesinan, dan laporan inventaris material.</p>
  <div class="cta-actions">
    <a href="/login" class="btn-primary">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;">
        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3"/>
      </svg>
      Otorisasi Akun & Masuk Sistem
    </a>
  </div>
</section>

<footer>
  <div class="footer-container">
    <div class="footer-info">
      <h4>PT. Gesang Sukses Makmur</h4>
      <p>Sistem ERP Internal untuk integrasi penuh workshop permesinan bubut, frais, kendali mutu, dan manajemen rantai pasok komponen presisi.</p>
    </div>
    <div class="footer-links">
      <div class="footer-group">
        <h5>Modul Sistem</h5>
        <ul>
          <li><a href="/login">Antrean Bubut / Turning</a></li>
          <li><a href="/login">Antrean Frais / Milling</a></li>
          <li><a href="/login">Log Alat Ukur & QC</a></li>
        </ul>
      </div>
      <div class="footer-group">
        <h5>Akses</h5>
        <ul>
          <li><a href="/login">Portal Karyawan</a></li>
          <li><a href="/login">Portal Vendor</a></li>
          <li><a href="#profil">Kebijakan Keamanan</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p class="footer-copy">&copy; 2026 <strong>PT. Gesang Sukses Makmur</strong>. Seluruh Hak Cipta Dilindungi.</p>
    <p>Sistem Informasi Internal — V2.0</p>
  </div>
</footer>

</body>
</html>