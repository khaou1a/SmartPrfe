<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Récupérer l'ID du service depuis l'URL
$service_id = isset($_GET['service']) ? intval($_GET['service']) : 0;

// Vérifier si le service existe
$service_name = "";
if ($service_id > 0) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }
    
    // Traitement de la suppression d'une chambre
    if (isset($_GET['delete_room']) && is_numeric($_GET['delete_room'])) {
        $room_id = intval($_GET['delete_room']);
        
        // Vérifier que la chambre appartient bien au service actuel
        $check_stmt = $conn->prepare("SELECT id FROM rooms WHERE id = ? AND service_id = ?");
        $check_stmt->bind_param("ii", $room_id, $service_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            // Supprimer la chambre
            $delete_stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
            $delete_stmt->bind_param("i", $room_id);
            
            if ($delete_stmt->execute()) {
                $success_message = "Chambre supprimée avec succès!";
            } else {
                $error_message = "Erreur lors de la suppression de la chambre: " . $conn->error;
            }
        }
    }
    
    // Récupérer le nom du service
    $stmt = $conn->prepare("SELECT name FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $service_name = $row['name'];
    } else {
        // Rediriger si le service n'existe pas
        header("Location: index.php");
        exit;
    }
    
    // Traiter l'ajout de chambre
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
        $room_number = $_POST['room_number'];
        $room_name = $_POST['room_name'];
        
        // Vérifier si la chambre existe déjà
        $check_stmt = $conn->prepare("SELECT id FROM rooms WHERE service_id = ? AND room_number = ?");
        $check_stmt->bind_param("ii", $service_id, $room_number);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error_message = "Erreur: La chambre n° " . htmlspecialchars($room_number) . " existe déjà dans ce service!";
        } else {
            // Insérer la nouvelle chambre
            $stmt = $conn->prepare("INSERT INTO rooms (service_id, room_number, name) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $service_id, $room_number, $room_name);
            
            if ($stmt->execute()) {
                $success_message = "Chambre ajoutée avec succès!";
                // Réinitialiser les valeurs du formulaire après succès
                $room_number = '';
                $room_name = '';
            } else {
                $error_message = "Erreur lors de l'ajout de la chambre: " . $conn->error;
            }
        }
    }
    
    // Récupérer les chambres du service
    $rooms = [];
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE service_id = ? ORDER BY room_number");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }
    
    $conn->close();
} else {
    // Rediriger si aucun service n'est spécifié
    header("Location: index.php");
    exit;
}
?>
<link rel="stylesheet" href="css/chambre.css">
<style>
/* Styles améliorés pour la page des chambres */
:root {
    --main-color: #00C4CC;
    --main-hover-color: #00adb5;
    --dark-text: #2c3e50;
    --light-bg: #f9f9f9;
}

.rooms-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Roboto', sans-serif;
}

.service-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--main-color);
}

.service-header h1 {
    color: var(--dark-text);
    font-size: 28px;
    margin: 0;
}

.main-btn {
    background-color: var(--main-color);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.main-btn:hover {
    background-color: var(--main-hover-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.secondary-btn {
    background-color: #ecf0f1;
    color: #34495e;
    border: 1px solid #bdc3c7;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.secondary-btn:hover {
    background-color: #bdc3c7;
}

.delete-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    text-decoration: none;
    display: inline-block;
}

.delete-btn:hover {
    background-color: #c0392b;
}

/* Style du formulaire */
.add-room-form {
    background-color: var(--light-bg);
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.add-room-form h2 {
    color: var(--dark-text);
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 22px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #34495e;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    transition: border 0.3s;
}

.form-group input:focus {
    border-color: var(--main-color);
    outline: none;
    box-shadow: 0 0 0 2px rgba(0, 196, 204, 0.2);
}

.form-buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

/* Alertes */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    animation: slideIn 0.5s ease;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

.success {
    background-color: #d4f8f9;
    color: #00878d;
    border-left: 4px solid var(--main-color);
}

.error {
    background-color: #f2dede;
    color: #a94442;
    border-left: 4px solid #d9534f;
}

/* Grille de chambres */
.rooms-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.room-card {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    border-top: 5px solid var(--main-color);
}

.room-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.15);
}

.room-info {
    padding: 20px;
    flex-grow: 1;
}

.room-info h3 {
    color: var(--dark-text);
    margin-top: 0;
    font-size: 18px;
    display: flex;
    align-items: center;
}

.room-info h3:before {
    content: '🛏️';
    margin-right: 10px;
    font-size: 22px;
}

.room-info p {
    color: #7f8c8d;
    margin-bottom: 0;
}

.room-actions {
    display: flex;
    border-top: 1px solid #eee;
}

.room-actions a {
    flex: 1;
    text-align: center;
    padding: 12px 5px;
    text-decoration: none;
}

.view-btn {
    background-color: var(--main-color);
    color: white;
}

.view-btn:hover {
    background-color: var(--main-hover-color);
}

/* Message de confirmation de suppression */
.delete-confirmation {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    animation: fadeIn 0.3s ease;
}

.delete-confirmation-content {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    max-width: 500px;
    width: 90%;
    text-align: center;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
}

.delete-confirmation h3 {
    margin-top: 0;
    color: var(--dark-text);
}

.delete-confirmation p {
    margin-bottom: 25px;
    color: #666;
}

.confirmation-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

/* Message "pas de chambres" */
.no-rooms {
    grid-column: 1 / -1;
    background-color: #f7f7f7;
    padding: 40px;
    text-align: center;
    border-radius: 8px;
    color: #7f8c8d;
}

.no-rooms p {
    margin: 0;
    font-size: 18px;
}

.no-rooms p:before {
    content: "😊";
    display: block;
    font-size: 40px;
    margin-bottom: 15px;
}

/* Responsive */
@media (max-width: 768px) {
    .service-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .rooms-container {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="rooms-page">
    <div class="service-header" style="padding-top: 15%;">
        <h1>Chambres - <?php echo htmlspecialchars($service_name); ?></h1>
        <button id="addRoomBtn" class="main-btn">+ Ajouter une chambre</button>
    </div>
    
    <?php if (isset($success_message)): ?>
        <div class="alert success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <div class="alert error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <!-- Formulaire d'ajout de chambre (caché par défaut) -->
    <div id="addRoomForm" class="add-room-form" style="display: none;">
        <h2>Ajouter une nouvelle chambre</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="room_number">Numéro de chambre:</label>
                <input type="number" id="room_number" name="room_number" required min="1" value="<?php echo isset($room_number) ? htmlspecialchars($room_number) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="room_name">Nom/Description de la chambre:</label>
                <input type="text" id="room_name" name="room_name" required value="<?php echo isset($room_name) ? htmlspecialchars($room_name) : ''; ?>">
            </div>
            <div class="form-buttons">
                <button type="submit" name="add_room" class="main-btn">Enregistrer</button>
                <button type="button" id="cancelAddRoom" class="secondary-btn">Annuler</button>
            </div>
        </form>
    </div>
    
    <!-- Liste des chambres -->
    <div class="rooms-container">
        <?php if (empty($rooms)): ?>
            <div class="no-rooms">
                <p>Aucune chambre n'est encore enregistrée pour ce service.</p>
                <p>Cliquez sur "Ajouter une chambre" pour commencer.</p>
            </div>
        <?php else: ?>
            <?php foreach ($rooms as $room): ?>
                <div class="room-card">
                    <div class="room-info">
                        <h3>Chambre <?php echo htmlspecialchars($room['room_number']); ?></h3>
                        <p><?php echo htmlspecialchars($room['name']); ?></p>
                    </div>
                    <div class="room-actions">
                        <a href="monitoring.php?room_id=<?php echo $room['id']; ?>" class="view-btn">Voir monitoring</a>
                        <a href="#" class="delete-btn" data-room-id="<?php echo $room['id']; ?>" data-room-number="<?php echo htmlspecialchars($room['room_number']); ?>">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Modal de confirmation de suppression (caché par défaut) -->
    <div id="deleteConfirmation" class="delete-confirmation" style="display: none;">
        <div class="delete-confirmation-content">
            <h3>Confirmer la suppression</h3>
            <p>Êtes-vous sûr de vouloir supprimer la chambre <span id="roomToDelete"></span>?</p>
            <div class="confirmation-buttons">
                <a href="#" id="confirmDelete" class="delete-btn">Supprimer</a>
                <button id="cancelDelete" class="secondary-btn">Annuler</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addRoomBtn = document.getElementById('addRoomBtn');
    const addRoomForm = document.getElementById('addRoomForm');
    const cancelAddRoom = document.getElementById('cancelAddRoom');
    const deleteConfirmation = document.getElementById('deleteConfirmation');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const roomToDelete = document.getElementById('roomToDelete');
    
    // Si un message d'erreur est présent, afficher automatiquement le formulaire
    <?php if (isset($error_message) && !isset($_GET['delete_room'])): ?>
    addRoomForm.style.display = 'block';
    <?php endif; ?>
    
    // Bouton d'ajout de chambre
    addRoomBtn.addEventListener('click', function() {
        addRoomForm.style.display = 'block';
        // Focus sur le premier champ
        document.getElementById('room_number').focus();
    });
    
    cancelAddRoom.addEventListener('click', function() {
        addRoomForm.style.display = 'none';
    });
    
    // Gestion de la suppression
    const deleteButtons = document.querySelectorAll('.delete-btn[data-room-id]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const roomId = this.getAttribute('data-room-id');
            const roomNumber = this.getAttribute('data-room-number');
            
            // Afficher le modal de confirmation
            roomToDelete.textContent = roomNumber;
            confirmDelete.href = `?service=<?php echo $service_id; ?>&delete_room=${roomId}`;
            deleteConfirmation.style.display = 'flex';
        });
    });
    
    // Fermer le modal de confirmation
    cancelDelete.addEventListener('click', function() {
        deleteConfirmation.style.display = 'none';
    });
    
    // Fermer le modal si on clique en dehors
    deleteConfirmation.addEventListener('click', function(e) {
        if (e.target === deleteConfirmation) {
            deleteConfirmation.style.display = 'none';
        }
    });
    
    // Ajouter une animation aux cartes de chambre
    const roomCards = document.querySelectorAll('.room-card');
    roomCards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
        card.style.animation = 'fadeIn 0.5s ease backwards';
    });
    
    // Ajouter une animation aux alertes
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
            });
        }, 5000);
    }
});
</script>

<!-- <?php include 'includes/footer.php'; ?> -->