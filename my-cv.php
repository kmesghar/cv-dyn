<?php
    session_name("my-dynamic-cv");
    session_start();

    include_once "inc/class/competence.class.php";
    include_once "inc/class/experience.class.php";
    include_once "inc/class/formation.class.php";
    include_once "inc/class/loisir.class.php";
    include_once "inc/class/user.class.php";

    $user = new User();
    $user->get(1);
    $competences = Competence::loadAll();
    $experiences = Experience::loadAll();
    $formations = Formation::loadAll();
    $loisirs = Loisir::loadAll();
    
    $page = "my-cv";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <section id="presentation">
            <div class="row">
                <div class="col-4">
                    <img src="<?= $user->getPhoto();?>" alt="<?=$user->getNom();?>" class="img-fluid rounded mb-3">
                </div>
                <div class="col-8">
                    <div class="row">
                        <div class="col"><h3><?=$user->posteRecherche();?></h3></div>
                    </div>
                    <div class="row">
                        <div class="col"><h3><?=$user;?></h3></div>
                    </div>

                    <?php if ($user-> getAfficherDateNaissance()): ?>
                        <div class="row">
                            <div class="col"><i class="fas fa-birthday-cake"></i>
                                <?= $user-> getDateNaissance()-> format("d/m/Y"); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($user-> getAfficherAge()): ?>
                        <div class="row">
                            <div class="col"><i class="fas fa-running"></i>
                                <?php
                                    $age = date('Y') - date('Y', $user-> getDateNaissance()-> getTimestamp());
                                    if (date('md') < date('md', $user-> getDateNaissance()-> getTimestamp())) {
                                        $age = $age - 1;
                                    }

                                    echo "$age ans";
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col">
                            <div class="row">
                                    <div class="col-1 py-0 my-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col-11 py-0">
                                        <?=$user->getAdresse();?>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="col-1 py-0 my-0">
                                        <i class="fas fa-city"></i>
                                    </div>
                                    <div class="col-11 py-0">
                                        <?=$user->getCodePostal() . " " . $user->getVille();?>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pb-1">
                        <div class="col-12 col-md-6 align-self-center"><i class="fas fa-mobile-alt"></i> <?=$user->getTelephone();?></div>
                        <div class="col-12 col-md-6"><a href="tel:<?=$user->getTelephone();?>" class="btn btn-secondary w-100">M'appeller</a></div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6 align-self-center font-weight-bold"><i class="fas fa-at"></i> <?=$user->getEmail();?></div>
                        <div class="col-12 col-lg-6"><a href="contact.php" class="btn btn-secondary w-100">Me contacter</a></div>
                    </div>
                </div>
            </div>
        </section>

        <section id="competences">
            <h4>Compétences</h4>

            <div class="pl-2 border">
                <?php foreach ($competences as $item) : ?>
                    <?= $item; ?>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="experiences">
            <h4>Expérience</h4>

            <div class="pl-2 border">
                <?php foreach ($experiences as $item) : ?>
                    <?= $item; ?>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="formations">
            <h4>Formation</h4>

            <div class="pl-2 border">
                <?php foreach ($formations as $item) : ?>
                    <?= $item; ?>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="loisirs">
            <h4>Loisirs</h4>

            <div class="pl-2 border">
                <?php foreach ($loisirs as $item) : ?>
                    <?= $item; ?>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php
        include_once "inc/parts/footer.php";
    ?>