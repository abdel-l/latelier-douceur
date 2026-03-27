<nav class="navbar navbar-expand-lg shadow-none">
    <div class="container">
        <a class="navbar-brand" href="index.php">L'Atelier Douceur</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="recettes.php">Desserts</a>
                </li>
                <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Connexion</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <li class="nav-item">
                        <span class="nav-link" style="opacity:.65;">👤 <?php echo htmlspecialchars($_SESSION['LOGGED_USER']['username']); ?></span>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link btn btn-outline-light btn-sm px-3" href="recipes_create.php">+ Ajouter un dessert</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color:#c4847a;" href="logout.php">Déconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
