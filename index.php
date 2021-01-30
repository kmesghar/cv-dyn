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

        <div class="row mt-5">
            <div class="col-3">
                <img src="ressources/img/pc-1660564_960_720.jpg" alt="" class="img-thumbnail rounded">
            </div>
            <div class="col-9">
                <h3>Malin !</h3>
                Mon CV en ligne est dynamique et me permet de le mettre en jour facilement via une interface de gestion dédiée !
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-3">
                <img src="ressources/img/wordpress-876983_960_720.jpg" alt="" class="img-thumbnail rounded">
            </div>
            <div class="col-9">
                <h3>Développeur !</h3>
                Agé de 43 ans, je suis un développeur web dynamique et blablabla ...
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-3">
                <img src="ressources/img/wordpress-876983_960_720.jpg" alt="" class="img-thumbnail rounded">
            </div>
            <div class="col-9">
                <h3>Dynamique !</h3>
                Agé de 43 ans, je suis un développeur web dynamique et blablabla ...
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-3">
            <img src="ressources/img/document-5608903_960_720.jpg" alt="" class="img-thumbnail rounded">
            </div>
            <div class="col-9">
                <h3>Mon CV !</h3>
                <a href="my-cv.php">Voir mon CV !</a> 
            </div>
        </div>
    </main>

    <?php
        include_once "inc/parts/footer.php";
    ?>