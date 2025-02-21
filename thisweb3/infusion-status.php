<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="css/infusion.css">

<section class="infusion-status">
    <h1>État d'infusion</h1>
    
    <div class="metrics-container">
        <!-- Débit Metric -->
        <div class="metric-box">
            <div class="progress-ring">
                <svg class="progress-circle">
                    <circle class="progress-background" cx="60" cy="60" r="54"></circle>
                    <circle class="progress-bar light-blue" cx="60" cy="60" r="54" data-percent="80"></circle>
                </svg>
                <div class="progress-text">
                    <span class="value">80%</span>
                    <span class="label">Débit</span>
                </div>
            </div>
        </div>

        <!-- Niveau Metric -->
        <div class="metric-box">
            <div class="progress-ring">
                <svg class="progress-circle">
                    <circle class="progress-background" cx="60" cy="60" r="54"></circle>
                    <circle class="progress-bar dark-blue" cx="60" cy="60" r="54" data-percent="60"></circle>
                </svg>
                <div class="progress-text">
                    <span class="value">60%</span>
                    <span class="label">Niveau</span>
                </div>
            </div>
        </div>

        <!-- Pression Metric -->
        <div class="metric-box">
            <div class="progress-ring">
                <svg class="progress-circle">
                    <circle class="progress-background" cx="60" cy="60" r="54"></circle>
                    <circle class="progress-bar red" cx="60" cy="60" r="54" data-percent="80"></circle>
                </svg>
                <div class="progress-text">
                    <span class="value">80%</span>
                    <span class="label">Pression</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <?php include 'includes/footer.php'; ?> -->