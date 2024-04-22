<nav>
    <div class="nav_logo">
        <img id="logoImage" src="./images/PalmHaven_Logo.webp" alt="Logo PalmHaven">
    </div>
    <ul class="nav__links">
        <li class="link"><a href="index.php">Accueil</a></li>
        <li class="link"><a href="Aide.php">Aide</a></li>
        <li class="link" id="profileLink"><a href="Profilmesreservtion.php">Profil</a></li>
    </ul>
</nav>

<script>
    document.getElementById('logoImage').addEventListener('click', function() {
        window.location.href = "index.php";
    });
</script>
