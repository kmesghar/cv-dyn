<?php
    session_name("my-dynamic-cv");
    session_start();

    include_once "inc/class/article.class.php";
    
    $articles = Article::loadAll();

    $page = "home";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1>Mon CV en ligne dynamique avec porte-folio !</h1>

        <p>
            <img src="ressources/img/pc-1660564_960_720.jpg" alt="" class="img-thumbnail rounded">
            Mon CV en ligne est dynamique et me permet de le mettre en jour facilement via une interface de gestion dédiée !
        </p>

        <p>
            <img src="ressources/img/wordpress-876983_960_720.jpg" alt="" class="img-thumbnail rounded">
            Agé de 43 ans, je suis un développeur web dynamique et blablabla ...
        </p>

        <p>
            <img src="ressources/img/wordpress-876983_960_720.jpg" alt="" class="img-thumbnail rounded">
            Agé de 43 ans, je suis un développeur web dynamique et blablabla ...
        </p>

        <p>
            <img src="ressources/img/document-5608903_960_720.jpg" alt="" class="img-thumbnail rounded">
            <a href="my-cv.php">Voir mon CV !</a> 
        </p>
    </main>

    <?php
        include_once "inc/parts/footer.php";
    ?>