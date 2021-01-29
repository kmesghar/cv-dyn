<?php
    session_name("my-dynamic-cv");
    session_start();

    $action = "profile";
    if (isset($_GET["action"]))
        $action = $_GET["action"];
    
    $page = "my-dashboard";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1>Mon CV en ligne dynamique avec porte-folio !</h1>

        <h2>Mon tableau de bord</h2>

        <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="?action=profile" class="nav-link <?php if ($action == "profile") echo "active"; ?>">Mon profile</a>
                </li>
                <li class="nav-item">
                    <a href="?action=articles" class="nav-link <?php if ($action == "articles") echo "active"; ?>">Mes articles</a>
                </li>
                <li class="nav-item">
                    <a href="?action=competences" class="nav-link <?php if ($action == "competences") echo "active"; ?>">Mes compétences</a>
                </li>
                <li class="nav-item">
                    <a href="?action=experiences" class="nav-link <?php if ($action == "experiences") echo "active"; ?>">Mon expérience</a>
                </li>
                <li class="nav-item">
                    <a href="?action=formation" class="nav-link <?php if ($action == "formation") echo "active"; ?>">Ma formation</a>
                </li>
                <li class="nav-item">
                    <a href="?action=loisirs" class="nav-link <?php if ($action == "loisirs") echo "active"; ?>">Mes loisirs</a>
                </li>
            </ul>
        </nav>

        <div class="border-left border-bottom pl-2 mb-3">
        </div>

    </main>

<?php
    include_once "inc/parts/footer.php";
?>