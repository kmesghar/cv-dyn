<?php
    session_name("my-dynamic-cv");
    session_start();

    include_once "inc/class/alert.class.php";
    include_once "inc/class/article.class.php";
    include_once "inc/class/competence.class.php";
    include_once "inc/class/experience.class.php";
    include_once "inc/class/formation.class.php";
    include_once "inc/class/loisir.class.php";
    include_once "inc/class/user.class.php";

    $user = new User();
    $user->get(1);
    $alert = new Alert();
    $erreur = false;

    if (!empty($_POST)) {
        if ($_POST["action"] == "update") {
            if (isset($_POST["nom"])) {
                $user-> setNom($_POST["nom"]);
            }
        } elseif ($_POST["action"] == "photo") {
            if ($_FILES["file"]["tmp_name"]) {
                $target_dir = "ressources/img/";
                $target_file = $target_dir . basename($_FILES["file"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["file"]["tmp_name"]);
                if($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".";
                    $erreur = false;
                } else {
                    $erreur = true;
                    $alert-> setType("alert-danger");
                    $alert-> setTitle("Désolé !");
                    $alert-> setContent("Le fichier envoyé n'est pas une image valide...");
                }
    
                // Check if file already exists
                if (file_exists($target_file)) {
                  $erreur = true;
                  $alert-> setType("alert-danger");
                  $alert-> setTitle("Désolé !");
                  $alert-> setContent("Le fichier de votre photo existe déjà sur le serveur...");
                }
                
                // Check file size
                if ($_FILES["file"]["size"] > 500000) {
                  $erreur = true;
                  $alert-> setType("alert-danger");
                  $alert-> setTitle("Désolé !");
                  $alert-> setContent("Le fichier de votre photo est trop volumineux...");
                }
                
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "webp" ) {
                  $erreur = true;
                  $alert-> setType("alert-danger");
                  $alert-> setTitle("Désolé !");
                  $alert-> setContent("Le fichier envoyé comme photo n'est pas autorisé...");
                  $alert-> setFooter("Seuls les fichiers JPG, JPEG, PNG, GIF et WEBP sont autorisés.");
                }
                
                // Check if no error occured
                if ($erreur) {
                //   $alert-> setType("alert-danger");
                //   $alert-> setTitle("Désolé !");
                //   $alert-> setContent("Une erreur s'est produite lors de l'envoi de votre photo...");
    
                // if everything is ok, try to upload file
                } else {
                  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    //echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                    
                    // supprimer le fichier de la photo courante...
                    unlink(realpath($user-> getPhoto()));
                    // puis mettre à jour l'utilisateur courant...
                    $user-> setPhoto($target_file);

                    $alert-> setType("alert-success");
                    $alert-> setTitle("Felicitations !");
                    $alert-> setContent("La photo de votre profile a bien été mise à jour...");
                  } else {
                    $alert-> setType("alert-danger");
                    $alert-> setTitle("Désolé !");
                    $alert-> setContent("Une erreur s'est produite lors de l'envoi de votre photo...");
                  }
                }
            } else {
                $erreur = true;
            }
        }

        if (!$erreur) {
            if ($user-> save()) {
                $alert-> setType("alert-success");
                $alert-> setTitle("Felicitations !");
                $alert-> setContent("Votre profile a bien été mis à jour...");
            } else {
                $alert-> setType("alert-danger");
                $alert-> setTitle("Désolé !");
                $alert-> setContent("Votre profile n'a pu être mis à jour...");
            } 
        }
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
            <?php if ($alert-> isset()): ?>
                <?= $alert; ?>
            <?php endif; ?>

            <?php // Administration des articles (page d'accueil)
                if ($action == "articles"): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>titre</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="px-2">1</th>
                                <td class="px-2 w-100">un titre...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-down"></i></i></button></td>
                                <td></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">2</th>
                                <td class="px-2 w-100">un titre...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-down"></i></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-up"></i></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">3</th>
                                <td class="px-2 w-100">un titre...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-up"></i></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
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
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-4 text-center">
                                <div class="row">
                                    <div class="col">
                                        <img src="<?= $user->getPhoto();?>" alt="<?=$user->getNom();?>" class="img-fluid rounded mx-auto mb-3 d-block">
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col pr-0">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="file" class="form-control w-100" name="file" id="file">
                                            <button class="btn btn-secondary my-2" name="action" value="photo">Modifier ma photo</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8">
                                <form action="" method="post">
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
                                        <button class="btn btn-secondary w-50" name="action" value="update"><i class="fas fa-user-edit"></i> Mettre à jour</button>
                                    </div>
                                </form>
                            </div>
                        </div>
            <?php endif; ?>
        </div>

    </main>

<?php
    include_once "inc/parts/footer.php";
?>