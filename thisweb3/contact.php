<?php
// Inclure la configuration de la base de données
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sécuriser les entrées
    $nom = htmlspecialchars(trim($_POST['user']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Vérifier que tous les champs sont remplis
    if (!empty($nom) && !empty($email) && !empty($message)) {
        // Vérifier que l'email est valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Email invalide.");
        }

        try {
            // Insérer les données dans la base
            $sql = "INSERT INTO contact_messages (name, email, message, created_at) VALUES (:name, :email, :message, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $nom,
                ':email' => $email,
                ':message' => $message
            ]);

            // Redirection après soumission
            header("Location: contact-success.php");
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de l'envoi du message: " . $e->getMessage());
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Méthode invalide.";
}
?>

<?php include 'includes/header.php'; ?>

<footer class="contact" id="contact">
    <div class="contact-heading">
        <h1>Contactez-nous</h1>
        <p>Si vous avez un problème technique ou souhaitez vous renseigner, contactez-nous ou envoyez-nous un message.</p>
        <p>N°Téléphone: 0540 30 30 65 43</p>
    </div>
    <form action="contact-handler.php" method="post">
        <input type="text" name="user" placeholder="Votre Nom" required>
        <input type="email" name="email" placeholder="Votre E-Mail" required>
        <textarea name="message" placeholder="Votre Message..." required></textarea>
        <button class="main-btn contact-btn" type="submit">Envoyer</button>
    </form>
</footer>

<?php include 'includes/footer.php'; ?>
