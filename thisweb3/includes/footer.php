<footer class="contact" id="contact">
        <div class="contact-heading">
            <h1>Contactez-nous</h1>
            <p>Si vous avez un problème technique ou souhaitez vous renseigner, contactez-nous ou envoyez-nous un message.</p>
            <p>N°Télephone:0540 30 30 65 43</p>
        </div>
        <form action="contact-handler.php" method="post">
            <input type="text" name="user" placeholder="Votre Nom" required>
            <input type="email" name="email" placeholder="Votre E-Mail" required>
            <textarea name="message" placeholder="Votre Message..." required></textarea>
            <button class="main-btn contact-btn" type="submit">Envoyer</button>
        </form>
    </footer>
</body>
</html>