<?php 
require_once 'includes/config.php';
include 'includes/header.php'; 
?>

<!-- Section Hero avec l'image Smart Perf -->
<section class="hero-banner">
    <div class="hero-content">
        <!-- <div class="smart-perf-image">
            <!-- <img src="images/b.png" alt="Smart Perf Logo"  
        </div> -->
    </div>
</section>
<!-- <h1 class="text">Smart Perf</h1> -->

<!-- Section Services -->
<section  style="padding-top:0;" class="features"  id="features">
    <!-- <p class="paragraph">Monitoring intelligent des perfusions médicales</p> -->
    <div class="section-title">
        <h2>Les Services de L'hopitale </h2>
    </div>
    <div class="feature-container">
        <div class="feature-box">
            <div class="f-img">
                <img src="images/urgence.jpg" alt="Urgences" />
            </div>
            <div class="f-text">
                <h3>Urgences</h3>
                <a href="gestion-chambre.php?service=1" class="main-btn">Voir les chambres</a>
            </div>
        </div>

        <div class="feature-box">
            <div class="f-img">
                <img src="images/Chirurgie.png" alt="Chirurgie" />
            </div>
            <div class="f-text">
                <h3>Chirurgie</h3>
                <a href="gestion-chambre.php?service=2" class="main-btn">Voir les chambres</a>
            </div>
        </div>

        <div class="feature-box">
            <div class="f-img">
                <img src="images/Interne.png" alt="Médecine Interne " />
            </div>
            <div class="f-text">
                <h3>Médecine Interne</h3>
                <a href="gestion-chambre.php?service=3" class="main-btn">Voir les chambres</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>