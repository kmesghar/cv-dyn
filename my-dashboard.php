<?php
    session_name("my-dynamic-cv");
    session_start();
    
    $page = "my-dashboard";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1>Mon CV en ligne dynamique avec porte-folio !</h1>

        <h2>Mon tableau de bord</h2>

        <nav  class="navbar navbar-light bg-light">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="?action='profile'" class="nav-link active">Mon profile</a>
                </li>
                <li class="nav-item">
                    <a href="?action='profile'" class="nav-link">Mes articles</a>
                </li>
                <li class="nav-item">
                    <a href="?action='profile'" class="nav-link">Mes compétences</a>
                </li>
                <li class="nav-item">
                    <a href="?action='profile'" class="nav-link">Mon expérience</a>
                </li>
                <li class="nav-item">
                    <a href="?action='profile'" class="nav-link">Ma formation</a>
                </li>
                <li class="nav-item">
                    <a href="?action='profile'" class="nav-link">Mes loisirs</a>
                </li>
            </ul>
        </nav>

        
    </main>

<?php
    include_once "inc/parts/footer.php";
?>