<?php
    session_name("my-dynamic-cv");
    session_start();
    
    include_once "inc/class/alert.class.php";
    $alert = new Alert();
    $realisations = array();

    $page = "my-portefolio";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1>Mon CV en ligne dynamique avec porte-folio !</h1>

        <h3>Voici une petite galerie (non exhaustive) de mes réalisations !</h3>

        <?php if ($alert-> isset()): ?>
            <?= $alert; ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION["user"])): ?>
            <h6>Ajouter une nouvelle réalisation</h6>
            <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre du projet">
                </div>

                <div class="form-group">
                    <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
                </div>
                <div class="form-group">
                    <input type="text" name="lien" id="lien" class="form-control" placeholder="Lien vers la réalisation: https://">
                </div>

                <div class="form-group text-right">
                    <button class="btn btn-secondary">Ajouter la nouvelle réalisation</button>
                </div>
            </form>
        <?php endif; ?>

        <?php foreach($realisations as $realisation): ?>
        <div class="row my-5">
            <div class="col-3">

            </div>
        </div>                        
        <?php endforeach; ?>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 px-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+1" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+2" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+3" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+4" alt="Première réalisation">
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 px-2 px-xl-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+5" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px-2 px-xl-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+6" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px px-xl-2 -2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+7" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px-2 px-xl-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+8" alt="Première réalisation">
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 px-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+9" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+10" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+11" alt="Première réalisation">
            </div>
            <div class="col-12 col-md-6 col-lg-3 px-2 my-5">
                <img src="https://via.placeholder.com/250x150?text=Mon+projet+12" alt="Première réalisation">
            </div>
        </div>

    </main>

    <?php
        include_once "inc/parts/footer.php";
    ?>