<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Viendez tous sur mon super site !!">
        
        <title>Mon CV en ligne dynamique</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <header class="container-fluid bg-secondary py-1">
            <div class="row">
                <div class="col-3 text-white align-self-center">
                    <i class="fas fa-lg fa-laptop-code"></i> Mon CV Dynamique
                </div>
                <div class="col-6">
                    <nav>
                        <ul class="nav justify-content-center" id="navbar">
                            <li class="nav-item">
                                <a href="./" class="nav-link <?php if ($page == "home") echo "active"; ?>">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a href="./my-cv.php" class="nav-link <?php if ($page == "my-cv") echo "active"; ?>">Mon CV</a>
                            </li>
                            <li class="nav-item">
                                <a href="./my-porte-folio.php" class="nav-link <?php if ($page == "my-portefolio") echo "active"; ?>">Mon Porte-Folio</a>
                            </li>

                            <?php if (isset($_SESSION["user"])): ?>
                            <li class="nav-item">
                                <a href="./my-dashboard.php" class="nav-link <?php if ($page == "my-dashboard") echo "active"; ?>">Mon tableau de bord</a>
                            </li>
                            <li class="nav-item">
                                <a href="./my-inbox.php" class="nav-link <?php if ($page == "my-inbox") echo "active"; ?>">Ma messagerie <span class="badge badge-info" id="unread">1</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="./logout.php" class="nav-link">Me déconnecter</a>
                            </li>

                            <?php else: ?>
                            <li class="nav-item">
                                <a href="./contact.php" class="nav-link <?php if ($page == "contact") echo "active"; ?>">Me contacter</a>
                            </li>
                            <li class="nav-item">
                                <a href="./login.php" class="nav-link <?php if ($page == "login") echo "active"; ?>">Me connecter</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-3">
                </div>
            </div>
        </header>
