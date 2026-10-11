<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CareerConnect</title>
  
  <!-- Google Fonts & Font Awesome Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #ffffff;
      color: #0f2b5c;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow-x: hidden;
    }

    /* Background: center.jpg full screen transparent overlay */
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('public/images/center.jpg');
      background-repeat: no-repeat;
      background-position: center center;
      background-size: cover;
      opacity: 0.14; /* Transparent watermark effect */
      pointer-events: none;
      z-index: 0;
    }

    /* Main Container */
    .page-wrapper {
      position: relative;
      z-index: 1;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 24px 6% 30px;
    }

    /* Top Floating Row: Login & Sign Up (Right side) */
    .top-action-bar {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      width: 100%;
    }

    .auth-buttons {
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .btn-login {
      text-decoration: none;
      color: #0f2b5c;
      font-weight: 600;
      font-size: 15px;
      padding: 9px 24px;
      border-radius: 9px;
      border: 1.8px solid #0f2b5c;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(6px);
      transition: all 0.25s ease;
    }

    .btn-login:hover {
      background: #0f2b5c;
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(15, 43, 92, 0.2);
    }

    .btn-signup {
      text-decoration: none;
      color: #ffffff;
      background: #0284c7;
      font-weight: 600;
      font-size: 15px;
      padding: 10px 26px;
      border-radius: 9px;
      transition: all 0.25s ease;
      box-shadow: 0 4px 16px rgba(2, 132, 199, 0.28);
    }

    .btn-signup:hover {
      background: #0369a1;
      box-shadow: 0 6px 20px rgba(2, 132, 199, 0.38);
    }

    /* Centered Hero Area */
    .hero-center {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      max-width: 860px;
      margin: 10px auto 30px;
      width: 100%;
    }

    /* Extra Zoom / Loku karapu Logo */
    .hero-center-logo {
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .hero-center-logo img {
      height: 180px; /* Logo eka thawa loku karala thiyenne */
      width: auto;
      object-fit: contain;
      display: block;
      transform: scale(1.15);
      transition: transform 0.25s ease;
    }

    .hero-center-logo img:hover {
      transform: scale(1.2);
    }

    .pre-tag {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 6px 18px;
      background: rgba(224, 242, 254, 0.85);
      border: 1px solid #bae6fd;
      color: #0284c7;
      font-size: 13px;
      font-weight: 600;
      border-radius: 20px;
      margin-bottom: 16px;
      letter-spacing: 0.5px;
    }

    .hero-center h1 {
      font-size: 46px;
      font-weight: 700;
      line-height: 1.25;
      color: #0f2b5c;
      margin-bottom: 14px;
    }

    .hero-center h1 span {
      color: #0284c7;
    }

    .hero-subtitle {
      font-size: 16px;
      color: #475569;
      margin-bottom: 30px;
      max-width: 620px;
      line-height: 1.6;
    }

    /* Center Search Box Card */
    .search-card {
      background: rgba(255, 255, 255, 0.95);
      border: 1px solid rgba(226, 232, 240, 0.9);
      padding: 8px 12px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      box-shadow: 0 16px 45px rgba(15, 43, 92, 0.1);
      backdrop-filter: blur(10px);
      width: 100%;
      max-width: 680px;
      gap: 10px;
    }

    .search-input-group {
      flex: 1;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 14px;
    }

    .search-input-group i {
      color: #94a3b8;
      font-size: 17px;
    }

    .search-input-group input {
      border: none;
      outline: none;
      width: 100%;
      font-size: 15px;
      color: #1e293b;
      background: transparent;
    }

    .search-input-group input::placeholder {
      color: #94a3b8;
    }

    .search-divider {
      width: 1px;
      height: 32px;
      background: #e2e8f0;
    }

    .btn-find-jobs {
      background: #0284c7;
      color: #ffffff;
      border: none;
      padding: 13px 30px;
      border-radius: 9px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s ease;
      white-space: nowrap;
    }

    .btn-find-jobs:hover {
      background: #0369a1;
    }

    /* Bottom Features Strip (Icons + Texts matching down.png) */
    .bottom-features-container {
      width: 100%;
      max-width: 1100px;
      margin: 15px auto 0;
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 16px;
      align-items: flex-start;
    }

    .feature-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 10px;
      padding: 12px 6px;
      border-radius: 12px;
      transition: all 0.25s ease;
      cursor: pointer;
    }

    .feature-card:hover {
      transform: translateY(-4px);
      background: rgba(255, 255, 255, 0.6);
    }

    .feature-icon-wrapper {
      width: 58px;
      height: 58px;
      border-radius: 50%;
      background: rgba(240, 249, 255, 0.9);
      border: 1.5px solid #e0f2fe;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #0284c7;
      font-size: 24px;
      transition: all 0.25s ease;
      box-shadow: 0 4px 12px rgba(2, 132, 199, 0.08);
    }

    .feature-card:hover .feature-icon-wrapper {
      background: #0284c7;
      color: #ffffff;
      border-color: #0284c7;
      box-shadow: 0 6px 18px rgba(2, 132, 199, 0.25);
    }

    .feature-title {
      font-size: 12.5px;
      font-weight: 600;
      color: #1e3a8a;
      line-height: 1.3;
    }

    /* Mobile Responsive */
    @media (max-width: 900px) {
      .bottom-features-container {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    @media (max-width: 768px) {
      .page-wrapper {
        padding: 20px 5%;
      }
      .hero-center-logo img {
        height: 90px;
        transform: scale(1.0);
      }
      .hero-center h1 {
        font-size: 30px;
      }
      .search-card {
        flex-direction: column;
        padding: 14px;
      }
      .search-divider {
        display: none;
      }
      .btn-find-jobs {
        width: 100%;
        justify-content: center;
      }
      .bottom-features-container {
        grid-template-columns: repeat(2, 1fr);
      }
    }
  </style>
</head>
<body>

  <div class="page-wrapper">
    
    <!-- Top Action Bar: Login & Sign Up (Right corner) -->
    <div class="top-action-bar">
      <div class="auth-buttons">
        <div class="auth-buttons">
    <a href="index.php?action=login" class="btn-login">Login</a>
    <a href="index.php?action=register" class="btn-signup">Sign Up</a>
</div>
      </div>
    </div>

    <!-- Center Hero Section -->
    <div class="hero-center">
      
      <!-- Loku karapu Center Logo -->
      <div class="hero-center-logo">
        <a href="#">
          <img src="public/images/logo2.png" alt="CareerConnect Logo">
        </a>
      </div>

      <!--<div class="pre-tag">
        <i class="fa-solid fa-sparkles"></i> All-in-One Career Platform
</div>-->
<br><br>

      <h1>All-in-One Platform for Your <br><span>Career Growth</span></h1>
      <p class="hero-subtitle">
        Find jobs, match your skill sets, connect with top companies, and build your future.
      </p>

      <!-- Center Search Box -->
      <div class="search-card">
        <div class="search-input-group">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" placeholder="Job Title, Skills">
        </div>
        <div class="search-divider"></div>
        <div class="search-input-group">
          <i class="fa-solid fa-location-dot"></i>
          <input type="text" placeholder="Location">
        </div>
        <button class="btn-find-jobs">Find Jobs</button>
      </div>
    </div>

    <!-- Bottom Features Strip: Images/Icons with 7 labels matching down image -->
    <div class="bottom-features-container">
      
      <!-- 1. Job Matching -->
      <div class="feature-card">
        <div class="feature-icon-wrapper">
          <i class="fa-solid fa-user-check"></i>
        </div>
        <span class="feature-title">Job Matching</span>
      </div>

      <!-- 2. Career Matching -->
      <div class="feature-card">
        <div class="feature-icon-wrapper">
          <i class="fa-solid fa-route"></i>
        </div>
        <span class="feature-title">Career Matching</span>
      </div>

      <!-- 3. Position Matching -->
      <div class="feature-card">
        <div class="feature-icon-wrapper">
          <i class="fa-solid fa-briefcase"></i>
        </div>
        <span class="feature-title">Position Matching</span>
      </div>

      <!-- 4. Employment Matching -->
      <div class="feature-card">
        <div class="feature-icon-wrapper">
          <i class="fa-solid fa-file-signature"></i>
        </div>
        <span class="feature-title">Employment Matching</span>
      </div>

      <!-- 5. Talent Matching -->
      <div class="feature-card">
        <div class="feature-icon-wrapper">
          <i class="fa-solid fa-star"></i>
        </div>
        <span class="feature-title">Talent Matching</span>
      </div>

      <!-- 6. Job Search -->
      <div class="feature-card">
        <div class="feature-icon-wrapper">
          <i class="fa-solid fa-magnifying-glass-chart"></i>
        </div>
        <span class="feature-title">Job Search</span>
      </div>

      <!-- 7. Candidate Search -->
      <div class="feature-card">
        <div class="feature-icon-wrapper">
          <i class="fa-solid fa-id-card-clip"></i>
        </div>
        <span class="feature-title">Candidate Search</span>
      </div>

    </div>

  </div>

</body>
</html>