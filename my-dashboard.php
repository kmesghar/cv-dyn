<?php
    session_name("my-dynamic-cv");
    session_start();

    include_once "inc/class/article.class.php";
    include_once "inc/class/competence.class.php";
    include_once "inc/class/experience.class.php";
    include_once "inc/class/formation.class.php";
    include_once "inc/class/loisir.class.php";
    include_once "inc/class/user.class.php";

    $user = new User();
    $user->get(1);

    if (!empty($_POST)) {
        if (isset($_POST["nom"])) {
            $user-> setNom($_POST["nom"]);
        }

        $user-> save();
    }

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
                    <a href="?action=profile" class="nav-link <?php if ($action == "profile") echo "active"; ?>"><i class="fas fa-user"></i> Mon profile</a>
                </li>
                <li class="nav-item">
                    <a href="?action=articles" class="nav-link <?php if ($action == "articles") echo "active"; ?>"><i class="far fa-newspaper"></i> Mes articles</a>
                </li>
                <li class="nav-item">
                    <a href="?action=competences" class="nav-link <?php if ($action == "competences") echo "active"; ?>"><i class="fas fa-puzzle-piece"></i> Mes compétences</a>
                </li>
                <li class="nav-item">
                    <a href="?action=experiences" class="nav-link <?php if ($action == "experiences") echo "active"; ?>"><i class="fas fa-building"></i> Mon expérience</a>
                </li>
                <li class="nav-item">
                    <a href="?action=formations" class="nav-link <?php if ($action == "formatiosn") echo "active"; ?>"><i class="fas fa-user-graduate"></i> Ma formation</a>
                </li>
                <li class="nav-item">
                    <a href="?action=loisirs" class="nav-link <?php if ($action == "loisirs") echo "active"; ?>"><i class="fas fa-gamepad"></i> Mes loisirs</a>
                </li>
            </ul>
        </nav>

        <div class="border-left border-bottom pl-2 py-2 mb-3">
            <?php // Administration des articles (page d'accueil)
                if ($action == "articles"): ?>
            <?php // Administration des compétences
                elseif ($action == "competences"): ?>
            <?php // Administration des expériences
                elseif ($action == "experiences"): ?>
            <?php // Administration des formations
                elseif ($action == "formations"): ?>
            <?php // Administration des loisirs
                elseif ($action == "loisirs"): ?>
            <?php // Administration du profile (par défaut)
                else: ?>
                    <form action="" method="post">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-4 text-center">
                                <div class="row">
                                    <div class="col">
                                        <img src="<?= $user->getPhoto();?>" alt="<?=$user->getNom();?>" class="img-fluid rounded mx-auto mb-3 d-block">
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col">
                                        <a href="" class="btn btn-secondary">Modifier ma photo</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="form-group">
                                    <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom" value="<?=$user-> getNom();?>" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Prénom" value="<?=$user-> getPrenom();?>" >
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?=$user-> getEmail();?>" >
                                </div>

                                <div class="form-group">
                                    <input type="tel" name="telphone" id="telephone" class="form-control" placeholder="Téléphone" value="<?=$user-> getTelephone();?>" >
                                </div>

                                <div class="form-group">
                                    <input type="text" name="poste" id="poste" class="form-control" placeholder="Poste recherché" value="<?=$user-> posteRecherche();?>" >
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-3 col-xl-3">
                                            <label for="datenaissance">Date de naissance</label>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                            <input type="date" name="datenaissance" id="datenaissance" class="form-control" value="<?=$user-> getDateNaissance()->format('Y-m-d');?>" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" name="adresse1" id="adresse1" class="form-control mb-2" placeholder="Adresse" value="<?=$user-> getAdresse1();?>">
                                    <input type="text" name="adresse2" id="adresse2" class="form-control" placeholder="Adresse" value="<?=$user-> getAdresse2();?>">
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" name="codepostal" id="codepostal" class="form-control" placeholder="Code postal" value="<?=$user-> getCodePostal();?>" required>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" name="ville" id="ville" class="form-control" placeholder="Ville" value="<?=$user-> getVille();?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button class="btn btn-secondary w-50"><i class="fas fa-user-edit"></i> Mettre à jour</button>
                                </div>
                            </div>
                        </div>
                    </form>
            <?php endif; ?>
        </div>

    </main>

<?php
    include_once "inc/parts/footer.php";
?>