<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Perf</title>
    <link rel="stylesheet" href="css/style.css"/>
    <style>
/* Sidebar fixe */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 200px;
    height: 100%;
    background-color:  #00C4CC;;
    color: white;
    padding-top: 20px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
}

/* Logo */
.sidebar .logo {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar .logo img {
    max-width: 80%;
}

/* Menu */
.menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu li {
    padding: 10px 20px;
}

.menu a {
    color: white;
    text-decoration: none;
    display: block;
    font-size: 16px;
}

.menu a:hover {
    background-color: #575757;
}

/* Sous-menu */
.submenu {
    display: none;
    list-style: none;
    padding-left: 15px;
}

.menu-item:hover .submenu {
    display: block;
    /* Sidebar */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 10%;
    height: 100%;
    background-color: #333;
    color: white;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Permet de positionner le support en bas */
}

/* Logo */
.sidebar .logo {
    text-align: center;
    margin-bottom: 20px;
}

.sidebar .logo img {
    max-width: 80%;
}

/* Menu */
.menu {
    list-style: none;
    padding: 0;
    margin: 0;
    flex-grow: 1; /* Permet d'occuper l'espace restant */
}

.menu li {
    padding: 10px 20px;
}

.menu a {
    color: white;
    text-decoration: none;
    display: block;
    font-size: 16px;
}

.menu a:hover {
    background-color: #575757;
}

/* Sous-menu */
.submenu {
    display: none;
    list-style: none;
    /* padding-left: 80%; */
}

.menu-item:hover .submenu {
    display: block;
}

/* Contacter le support technique (fixé en bas) */
/* .support {
    padding: 15px;
    text-align: center;
    margin-top: auto;
} */


}

/* Contenu principal (pour éviter qu'il soit caché sous la sidebar) */
body {
    margin-left: 15%; /* Ajuster selon la largeur de la sidebar */
    font-family: Arial, sans-serif;
}

    </style>
</head>
<body>
<header class="main">
    <aside class="sidebar"  style="width: 15%;">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo1.png" alt="Smart Perf Logo" style="height: 50px; width: auto;"/>
            </a>
        </div>

        <ul class="menu">
            <li class="menu-item" >
                <a href="#"style="align:left ">Services ▼</a>
                <ul class="submenu">
                    <li><a href="gestion-chambre.php?service=1">Urgences et Réanimation</a></li>
                    <li><a href="gestion-chambre.php?service=2">Chirurgie</a></li>
                    <li><a href="gestion-chambre.php?service=3">Médecine Interne</a></li>
                </ul>
            </li>
        </ul>
        <div class="menu"  style="margin-left:4px ;">
            <a href="index.php#contact">Support Technique</a>
        </div>
        
        <!-- Contacter le support en bas -->
    </aside>
</header>


<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>
