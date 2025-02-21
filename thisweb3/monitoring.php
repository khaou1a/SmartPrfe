<?php 
require_once 'includes/config.php';
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .dashboard {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .switch {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f0f0f0;
            padding: 8px 20px;
            border-radius: 25px;
        }

        .status-dot {
            width: 20px;
            height: 20px;
            background: #4cd7c0;
            border-radius: 50%;
        }

        .metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .metric {
            text-align: center;
        }

        .circle-progress {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            position: relative;
        }

        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-circle-bg {
            fill: none;
            stroke: rgba(76, 215, 192, 0.2);
            stroke-width: 8;
        }

        .progress-circle {
            fill: none;
            stroke: #4cd7c0;
            stroke-width: 8;
            transition: stroke-dashoffset 0.3s;
        }

        .circle-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .circle-value {
            font-size: 24px;
            font-weight: bold;
            display: block;
        }

        .circle-label {
            font-size: 14px;
            color: #666;
        }

        .info-boxes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-box {
            background: #e8f8f5;
            padding: 20px;
            border-radius: 10px;
        }

        .info-box h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .info-box p {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .alerts {
            background: #ffe5e5;
            padding: 20px;
            border-radius: 10px;
        }

        .alerts h2 {
            margin: 0 0 15px 0;
            color: #333;
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .alert:last-child {
            margin-bottom: 0;
        }

        .alert-icon {
            width: 20px;
            height: 20px;
        }
            .dashboard {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .switch {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f0f0f0;
            padding: 8px 20px;
            border-radius: 25px;
        }

        .status-dot {
            width: 20px;
            height: 20px;
            background: #4cd7c0;
            border-radius: 50%;
        }

        .metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .metric {
            text-align: center;
        }

        .circle-progress {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            position: relative;
        }

        .progress-ring {
            transform: rotate(-90deg);
        }

        .progress-circle-bg {
            fill: none;
            stroke: rgba(76, 215, 192, 0.2);
            stroke-width: 8;
        }

        .progress-circle {
            fill: none;
            stroke: #4cd7c0;
            stroke-width: 8;
            transition: stroke-dashoffset 0.3s;
        }

        .circle-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .circle-value {
            font-size: 24px;
            font-weight: bold;
            display: block;
        }

        .circle-label {
            font-size: 14px;
            color: #666;
        }

        .info-boxes {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-box {
            background: #e8f8f5;
            padding: 20px;
            border-radius: 10px;
        }

        .alerts {
            background: #ffe5e5;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }        /* Nouveaux styles pour les contrôles IoT */
        .iot-controls {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .control-section {
            margin-bottom: 20px;
        }

        .flow-control {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .flow-value {
            font-size: 24px;
            font-weight: bold;
            min-width: 100px;
            text-align: center;
        }

        .control-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .btn-adjust {
            background: #e8f8f5;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-adjust:hover {
            background: #d1f2eb;
        }

        .btn-primary {
            background: #4cd7c0;
            color: white;
        }

        .btn-primary:hover {
            background: #3bc1aa;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #d68910;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .control-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
    </style>

  
</head>
<body>
    <?php
    // Simuler les données (dans un vrai cas, ces données viendraient d'une base de données ou d'un système IoT)
    $data = [
        'debit' => 80,
        'niveau' => 60,
        'pression' => 45,
        'temps_restant' => '00:20:34',
        'type_liquide' => 'NaCl 0.9%'
    ];

    function createCircleProgress($value, $label, $unit = '%') {
        $circumference = 2 * pi() * 46;
        $offset = $circumference * (1 - $value / 100);
        
        return "
        <div class='metric'>
            <div class='circle-progress'>
                <svg width='150' height='150' class='progress-ring'>
                    <circle cx='75' cy='75' r='46' class='progress-circle-bg'/>
                    <circle cx='75' cy='75' r='46' class='progress-circle' 
                            style='stroke-dasharray: {$circumference}; stroke-dashoffset: {$offset}'/>
                </svg>
                <div class='circle-text'>
                    <span class='circle-value'>{$value}{$unit}</span>
                    <span class='circle-label'>{$label}</span>
                </div>
            </div>
        </div>";
    }
    ?>

    <div class="dashboard">
        <div class="header">
            <h1>État d'infusion</h1>
            <div class="switch">
                <div class="status-dot"></div>
                <span>Off</span>
            </div>
        </div>

        <div class="metrics">
            <?php
            echo createCircleProgress($data['debit'], 'Débit');
            echo createCircleProgress($data['niveau'], 'Niveau');
            echo createCircleProgress($data['pression'], 'Pression', ' mmHg');
            ?>
        </div>

        <div class="info-boxes">
            <div class="info-box">
                <h3>Temps restant</h3>
                <p><?php echo $data['temps_restant']; ?></p>
            </div>
            <div class="info-box">
                <h3>Type de liquide</h3>
                <p><?php echo $data['type_liquide']; ?></p>
            </div>
        </div>

        <div class="alerts">
            <h2>Alerte</h2>
            <div class="alert">
                <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <span>Perfusion presque terminée</span>
            </div>
            <div class="alert">
                <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/>
                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <span>Augmentation du débit</span>
            </div>
        </div>
    </div>

    <div class="dashboard">
        <!-- Code précédent... -->

        <!-- Nouvelle section de contrôle IoT -->
        <div class="iot-controls">
            <h2>Contrôle de l'appareil</h2>
            
            <div class="control-section">
                <h3>Débit d'écoulement</h3>
                <div class="flow-control">
                    <button class="control-btn btn-adjust" onclick="adjustFlow(-0.5)">-</button>
                    <div class="flow-value" id="flowRate">5.0 ml/h</div>
                    <button class="control-btn btn-adjust" onclick="adjustFlow(0.5)">+</button>
                </div>
            </div>

            <div class="control-buttons">
                <button class="control-btn btn-primary" id="startBtn" onclick="toggleDevice()">
                    <span class="material-icons">play_arrow</span>
                    Démarrer
                </button>
                
                <button class="control-btn btn-warning" id="pauseBtn" onclick="pauseDevice()">
                    <span class="material-icons">pause</span>
                    Pause
                </button>
                
                <button class="control-btn btn-danger" id="stopBtn" onclick="stopDevice()">
                    <span class="material-icons">stop</span>
                    Arrêter
                </button>
                
                <button class="control-btn btn-primary" onclick="purgeDevice()">
                    <span class="material-icons">refresh</span>
                    Purger
                </button>
            </div>
        </div>
    </div>

    <script>

let isRunning = false;
    let currentFlow = 5.0;
    
    function adjustFlow(change) {
        currentFlow = Math.max(0.5, Math.min(20, currentFlow + change));
        document.getElementById('flowRate').textContent = currentFlow.toFixed(1) + ' ml/h';
        
        // Envoyer au serveur IoT
        sendToIoTDevice('adjust_flow', { flow: currentFlow });
    }
    
    function toggleDevice() {
        isRunning = !isRunning;
        const startBtn = document.getElementById('startBtn');
        startBtn.innerHTML = isRunning ? 
            '<span class="material-icons">stop</span> Arrêter' : 
            '<span class="material-icons">play_arrow</span> Démarrer';
        
        // Envoyer au serveur IoT
        sendToIoTDevice('toggle', { status: isRunning });
    }
    
    function pauseDevice() {
        // Envoyer au serveur IoT
        sendToIoTDevice('pause', {});
    }
    
    function stopDevice() {
        if (confirm('Êtes-vous sûr de vouloir arrêter l\'appareil ?')) {
            isRunning = false;
            document.getElementById('startBtn').innerHTML = 
                '<span class="material-icons">play_arrow</span> Démarrer';
            
            // Envoyer au serveur IoT
            sendToIoTDevice('stop', {});
        }
    }
    
    function purgeDevice() {
        if (confirm('Confirmer la purge du système ?')) {
            // Envoyer au serveur IoT
            sendToIoTDevice('purge', {});
        }
    }
    
    function sendToIoTDevice(action, data) {
        // Simuler l'envoi à un serveur IoT
        console.log('Envoi au dispositif IoT:', action, data);
        
        // Dans un environnement réel, vous utiliseriez fetch ou WebSocket :
        /*
        fetch('/api/iot/device', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: action,
                data: data
            })
        });
        */
    }
    
    // Simulation de mise à jour des données en temps réel
    setInterval(() => {
        if (isRunning) {
            // Simuler la réception de données du serveur IoT
            const newData = {
                debit: Math.random() * 20 + 70,
                niveau: Math.random() * 10 + 50,
                pression: Math.random() * 10 + 40
            };
            
            // Mettre à jour l'interface
            // (Dans un cas réel, ces données viendraient du serveur IoT)
        }
    }, 5000);    </script>
</body>
</html>