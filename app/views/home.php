<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CLSD | Center for Lakes Sustainable Development</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: linear-gradient(135deg, #0b1f3a 0%, #081428 100%);
    color: white;
    overflow-x: hidden;
    min-height: 100vh;
}

/* ================= NAVBAR ================= */

.nav-wrapper {
    width: 100%;
    padding: 0 60px;
    position: fixed;
    top: 0;
    left: 0;
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(37, 99, 235, 0.2);
    z-index: 1000;
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from { transform: translateY(-100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.navbar {
    max-width: 1200px;
    margin: auto;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #2563eb;
}

.logo-text {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 1px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 40px;
}

.nav-links a {
    text-decoration: none;
    color: #cbd5e1;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.nav-links a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    transition: width 0.3s ease;
}

.nav-links a:hover {
    color: white;
}

.nav-links a:hover::after {
    width: 100%;
}

.login-btn {
    padding: 10px 24px;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    border-radius: 8px;
    color: white !important;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.5);
}

.login-btn::after {
    display: none;
}

/* ================= HERO ================= */

.hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 0 20px;
    position: relative;
    overflow: hidden;
}

/* Animated background elements */
.hero::before {
    content: "";
    position: absolute;
    width: 800px;
    height: 800px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.15), transparent 70%);
    top: -200px;
    right: -200px;
    filter: blur(100px);
    z-index: 0;
    animation: float 20s infinite ease-in-out;
}

.hero::after {
    content: "";
    position: absolute;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.1), transparent 70%);
    bottom: -150px;
    left: -150px;
    filter: blur(100px);
    z-index: 0;
    animation: float 15s infinite ease-in-out reverse;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(30px, 20px); }
}

.hero-content {
    position: relative;
    z-index: 1;
    max-width: 900px;
    animation: fadeInUp 1s ease;
}

@keyframes fadeInUp {
    from { 
        opacity: 0;
        transform: translateY(30px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

.hero h1 {
    font-size: 64px;
    font-weight: 700;
    margin-bottom: 25px;
    letter-spacing: -1px;
    line-height: 1.2;
    background: linear-gradient(135deg, #ffffff, #e2e8f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.hero h1 span {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero p {
    font-size: 20px;
    color: #94a3b8;
    margin-bottom: 50px;
    line-height: 1.8;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

/* Stats Section */
.stats-container {
    display: flex;
    justify-content: center;
    gap: 60px;
    margin-bottom: 50px;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 36px;
    font-weight: 700;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 5px;
}

.stat-label {
    color: #94a3b8;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Buttons */
.hero-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.primary-btn {
    padding: 16px 40px;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    border-radius: 12px;
    text-decoration: none;
    color: white;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}

.primary-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(37, 99, 235, 0.5);
}

.primary-btn i {
    font-size: 18px;
}

.secondary-btn {
    padding: 16px 40px;
    border: 2px solid rgba(37, 99, 235, 0.3);
    border-radius: 12px;
    text-decoration: none;
    color: #e2e8f0;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(5px);
}

.secondary-btn:hover {
    border-color: #2563eb;
    background: rgba(37, 99, 235, 0.1);
    transform: translateY(-2px);
}

.secondary-btn i {
    font-size: 18px;
}

/* Features Section */
.features {
    padding: 80px 20px;
    position: relative;
    z-index: 1;
}

.features-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    padding: 0 20px;
}

.feature-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(37, 99, 235, 0.2);
    border-radius: 20px;
    padding: 30px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    text-align: left;
}

.feature-card:hover {
    transform: translateY(-5px);
    border-color: #2563eb;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    background: rgba(37, 99, 235, 0.05);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #2563eb20 0%, #1e40af20 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.feature-icon i {
    font-size: 28px;
    color: #2563eb;
}

.feature-card h3 {
    font-size: 20px;
    margin-bottom: 15px;
    color: white;
}

.feature-card p {
    color: #94a3b8;
    line-height: 1.7;
    font-size: 15px;
}

/* Footer */
.footer {
    text-align: center;
    padding: 40px 20px;
    border-top: 1px solid rgba(37, 99, 235, 0.2);
    color: #64748b;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
    .nav-wrapper {
        padding: 0 20px;
    }

    .nav-links {
        gap: 20px;
    }

    .nav-links a:not(.login-btn) {
        display: none;
    }

    .hero h1 {
        font-size: 40px;
    }

    .hero p {
        font-size: 18px;
    }

    .stats-container {
        gap: 30px;
    }

    .stat-number {
        font-size: 28px;
    }

    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }

    .primary-btn, .secondary-btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .hero h1 {
        font-size: 32px;
    }

    .stats-container {
        flex-direction: column;
        gap: 20px;
    }

    .features-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>

<body>

<div class="nav-wrapper">
    <div class="navbar">
        <div class="logo-container">
            <img src="<?= BASE_URL ?>/assets/images/logo/LSD.png" alt="CLSD Logo" class="logo-img" onerror="this.src='https://via.placeholder.com/40?text=CLSD'">
            <span class="logo-text">CLSD</span>
        </div>

        <div class="nav-links">
            <a href="<?= BASE_URL ?>">Home</a>
            <a href="<?= BASE_URL ?>/login" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </div>
</div>

<div class="hero">
    <div class="hero-content">
        <h1>
            Center for <span>Lakes Sustainable</span><br>
            Development
        </h1>

        <p>
            A centralized data management platform dedicated to sustainable lake research,
            environmental monitoring, and institutional data governance.
        </p>

        <!-- Stats -->
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number">15+</div>
                <div class="stat-label">Research Projects</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Researchers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">10+</div>
                <div class="stat-label">Partner Institutions</div>
            </div>
        </div>

        <div class="hero-buttons">
            <a href="<?= BASE_URL ?>/login" class="primary-btn">
                <i class="fas fa-arrow-right"></i> Go to Website
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="features">
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-database"></i>
            </div>
            <h3>Centralized Data</h3>
            <p>All research data and publications in one secure location, accessible to authorized personnel.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Research Team</h3>
            <p>Connect with researchers and experts in lake sustainability and environmental science.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <h3>Publications</h3>
            <p>Access research papers, studies, and publications from CLSD and partner institutions.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3>Events & Projects</h3>
            <p>Stay updated with ongoing projects, events, and initiatives in lake conservation.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-microscope"></i>
            </div>
            <h3>Research Interest</h3>
            <p>Explore various research interests and expertise areas of our team members.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-globe"></i>
            </div>
            <h3>Environmental Impact</h3>
            <p>Track environmental monitoring data and sustainability metrics.</p>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>© <?= date('Y') ?> CLSD - Center for Lakes Sustainable Development. All rights reserved.</p>
</div>

</body>
</html>