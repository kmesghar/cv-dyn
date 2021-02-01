<?php
    session_name("my-dynamic-cv");
    session_start();

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
    
    if (!isset($_SESSION["user"]))
        header("Location: ./");

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

    $manage = "profile";
    if (isset($_GET["manage"]))
        $manage = $_GET["manage"];

    if (!empty($_POST)) {
        if ($manage == "profile") {
            if ($_POST["action"] == "update") {
                if (isset($_POST["nom"])) {
                    $user-> setNom($_POST["nom"]);
                }
                if (isset($_POST["prenom"])) {
                    $user-> setPrenom($_POST["prenom"]);
                }
                if (isset($_POST["email"])) {
                    $user-> setEmail($_POST["email"]);
                }
                if (isset($_POST["telephone"])) {
                    $user-> setTelephone($_POST["telephone"]);
                }
                if (isset($_POST["poste"])) {
                    $user-> setPosteRecherche($_POST["poste"]);
                }
                if (isset($_POST["datenaissance"])) {
                    $user-> setDateNaissance($_POST["datenaissance"]);
                }
                if (isset($_POST["afficherdate"])) {
                    $user-> setAfficherDateNaissance(true);
                } else {
                    $user-> setAfficherDateNaissance(false);
                }
                if (isset($_POST["afficherage"])) {
                    $user-> setAfficherAge(true);
                } else {
                    $user-> setAfficherAge(false);
                }
                if (isset($_POST["adresse1"])) {
                    $user-> setAdresse1($_POST["adresse1"]);
                }
                if (isset($_POST["adresse2"])) {
                    $user-> setAdresse2($_POST["adresse2"]);
                }
                if (isset($_POST["codepostal"])) {
                    $user-> setCodePostal($_POST["codepostal"]);
                }
                if (isset($_POST["ville"])) {
                    $user-> setVille($_POST["ville"]);
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
        } else if ($manage == "articles") {
            if ($_POST["action"] == "create") {
            } else if ($_POST["action"] == "update") {
            } else if ($_POST["action"] == "delete") {
            }

            $article = new Article();

            $image = "";
            $keywords = str_replace(",", " ", $_POST["keywords"]);
            $keywords = str_replace(";", " ", $_POST["keywords"]);
            $keywords = trim(str_replace(".", " ", $_POST["keywords"]));

            $article-> setTitle($_POST["titre"]);
            $article-> setAbstract($_POST["abstract"]);
            $article-> setHeader($_POST["header"]);
            $article-> setContent($_POST["content"]);
            $article-> setFooter($_POST["footer"]);
            $article-> setImage($image);
            $article-> setKeywordsArray(explode(" ", $keywords));

            if ($article-> save()) {
                $alert-> setType("alert-success");
                $alert-> setTitle("Felicitations !");
                $alert-> setContent("Votre nouvel article a bien été ajouté...");
            } else {
                $alert-> setType("alert-danger");
                $alert-> setTitle("Désolé !");
                $alert-> setContent("Votre nouvel article n'a pu être ajouté...");
            } 
        } else if ($manage == "competences") {

        } else if ($mange == "experiences") {
            
        } else if ($mange == "formations") {
            
        } else if ($mange == "loisirs") {
            
        }
    }

    // Chargement des données à gérer:
    if ($manage == "profile") {
        // Rien à faire, utilisateur déjà chargé !
    } if ($manage == "articles") {
        $articles = Article::loadAll();
    } else if ($manage == "competences") {
        $competences = Competence::loadAll();
    } else if ($manage == "experiences") {
        $experiences = Experience::loadAll();
    } else if ($manage == "formations") {
        $formations = Formation::loadAll();
    } else if ($manage == "loisirs") {
        $loisirs = Loisir::loadAll();
    }
    
    $page = "my-dashboard";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1>Mon CV en ligne dynamique avec porte-folio !</h1>

        <h2>Mon tableau de bord</h2>

        <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="?manage=profile" class="nav-link <?php if ($manage == "profile") echo "active"; ?>"><i class="fas fa-user"></i> Mon profile</a>
                </li>
                <li class="nav-item">
                    <a href="?manage=articles" class="nav-link <?php if ($manage == "articles") echo "active"; ?>"><i class="far fa-newspaper"></i> Mes articles</a>
                </li>
                <li class="nav-item">
                    <a href="?manage=competences" class="nav-link <?php if ($manage == "competences") echo "active"; ?>"><i class="fas fa-puzzle-piece"></i> Mes compétences</a>
                </li>
                <li class="nav-item">
                    <a href="?manage=experiences" class="nav-link <?php if ($manage == "experiences") echo "active"; ?>"><i class="fas fa-building"></i> Mon expérience</a>
                </li>
                <li class="nav-item">
                    <a href="?manage=formations" class="nav-link <?php if ($manage == "formations") echo "active"; ?>"><i class="fas fa-user-graduate"></i> Ma formation</a>
                </li>
                <li class="nav-item">
                    <a href="?manage=loisirs" class="nav-link <?php if ($manage == "loisirs") echo "active"; ?>"><i class="fas fa-gamepad"></i> Mes loisirs</a>
                </li>
            </ul>
        </nav>

        <div class="border-left border-bottom pl-2 py-2 mb-3">
            <?php if ($alert-> isset()): ?>
                <?= $alert; ?>
            <?php endif; ?>

            <?php // Administration des articles (page d'accueil)
                if ($manage == "articles"): ?>
                    <form action="" method="post">
                        <input type="hidden" name="action" id="action" value="create">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-2">
                                    <input type="file" class="form-control w-100" name="file" id="file">
                                </div>
                                <div class="col-12 col-lg-8 mb-2">
                                    <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre" required>
                                </div>
                            </div>

                            <div class="row mb-2 hidden" id="row-abstract">
                                <div class="col-12">
                                    <textarea name="abstract" id="abstract" class="form-control" placeholder="Extrait (facultatif)"></textarea>
                                </div>
                            </div>

                            <div class="row mb-2 hidden" id="row-header">
                                <div class="col-12">
                                    <textarea name="header" id="header" class="form-control" placeholder="En-tête (facultatif)"></textarea>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <textarea name="content" id="content" class="form-control" placeholder="Contenu" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-2 hidden" id="row-footer">
                                <div class="col-12">
                                    <textarea name="footer" id="footer" class="form-control" placeholder="Pied de page (facultatif)"></textarea>
                                </div>
                            </div>

                            <div class="row mb-2 hidden" id="row-keywords">
                                <div class="col-12">
                                    <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Mots-clés, séparés par des espaces (facultatifs)">
                                </div>
                            </div>

                            <div class="row justify-content-end" id="btn-overlay">
                                <div class="col-12 col-lg-8 align-self-end mb-2">
                                    <a class="btn btn-sm btn-secondary" id="btn-abstract">Ajouter un extrait</a>
                                    <a class="btn btn-sm btn-secondary" id="btn-header">Ajouter un en-tête</a>
                                    <a class="btn btn-sm btn-secondary" id="btn-footer">Ajouter un pied de page</a>
                                    <a class="btn btn-sm btn-secondary" id="btn-keywords">Ajouter des mots-clés</a>
                                </div>
                                <div class="col-12 col-lg-4 text-right mb-2">
                                    <button class="btn btn-secondary w-100">Ajouter un nouvel article</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <h4>Mes articles</h4>
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
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-down"></i></i></button>
                                    </form>
                                </td>
                                <td></td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">2</th>
                                <td class="px-2 w-100">un titre...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-down"></i></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-up"></i></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">3</th>
                                <td class="px-2 w-100">un titre...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td></td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-up"></i></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="">
                                        <input type="hidden" name="article">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            <?php // Administration des compétences
                elseif ($manage == "competences"): ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-2">
                                <input type="text" name="icon" id="icon" class="form-control" placeholder="Icone (Font Awesome par exemple)">
                                </div>
                                <div class="col-12 col-lg-8 mb-2">
                                    <input type="text" name="loisir" id="loisir" class="form-control" placeholder="Nouvelle compétence">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <textarea name="description" id="description" class="form-control" placeholder="Description (facultative)"></textarea>
                                </div>
                            </div>

                            <div class="row justify-content-end mb-2">
                                <div class="col-12 col-lg-4 text-right">
                                    <button class="btn btn-secondary w-100">Ajouter une nouvelle compétence</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <h4>Mes compétences</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>FA</th>
                                <th>Compétence</th>
                                <th>Description</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="px-2">1</th>
                                <td class="px-2 text-nowrap"><i class="fab fa-2x fa-html5"></i></td>
                                <td class="px-2 text-nowrap">HTML 5</td>
                                <td class="px-2 w-100">Sa description...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">2</th>
                                <td class="px-2 text-nowrap"><i class="fab fa-2x fa-css3-alt"></i></td>
                                <td class="px-2 text-nowrap">CSS3</td>
                                <td class="px-2 w-100">Sa description...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">3</th>
                                <td class="px-2 text-nowrap"><i class="fab fa-2x fa-js-square"></i></td>
                                <td class="px-2 text-nowrap">Javascript ES6</td>
                                <td class="px-2 w-100">Sa description...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">4</th>
                                <td class="px-2 text-nowrap"><i class="fab fa-2x fa-php"></i></td>
                                <td class="px-2 text-nowrap">PHP 7.4</td>
                                <td class="px-2 w-100">Sa description...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
            <?php // Administration des expériences
                elseif ($manage == "experiences"): ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6 col-lg-3 align-self-center mb-2 form-inline">
                                    <label for="datenaissance">Du :</label>
                                    <input type="date" name="dateformation" id="dateformation" class="form-control px-1 ml-2" required>
                                </div>
                                <div class="col-6 col-lg-3 mb-2 form-inline">
                                    <label for="datenaissance">au :</label>
                                    <input type="date" name="dateformation" id="dateformation" class="form-control px-1 ml-2">
                                </div>
                                <div class="col-10 col-lg-5 mb-2">
                                    <input type="text" name="formation" id="formation" class="form-control" placeholder="Poste occupé">
                                </div>
                                <div class="col-1 align-self-center mb-2 py-0 my-0">
                                    <input type="checkbox" class="form-check-input" id="experienceenposte" name="experienceenposte">
                                    <label class="form-check-label" for="experienceenposte">en poste</label>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-8">
                                    <input type="text" name="employeur" id="employeur" class="form-control" placeholder="Employeur">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="ville" id="ville" class="form-control" placeholder="Ville (départ.)">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <textarea name="description" id="description" class="form-control" placeholder="Description (facultative)"></textarea>
                                </div>
                            </div>

                            <div class="row justify-content-end mb-2">
                                <div class="col-12 col-lg-4 text-right">
                                    <button class="btn btn-secondary w-100">Ajouter une nouvelle expérience</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <h4>Mes expériences</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Entreprise</th>
                                <th>Poste occupé</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="px-2">1</th>
                                <td class="px-2 text-nowrap">01/01/1970</td>
                                <td class="px-2 text-nowrap">01/01/1980</td>
                                <td class="px-2 text-nowrap">IBM</td>
                                <td class="px-2 w-100">Développeur</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">2</th>
                                <td class="px-2 text-nowrap">01/01/1980</td>
                                <td class="px-2 text-nowrap">01/01/1990</td>
                                <td class="px-2 text-nowrap">Apple</td>
                                <td class="px-2 w-100">Développeur</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">3</th>
                                <td class="px-2 text-nowrap">01/01/2000</td>
                                <td class="px-2 text-nowrap">01/01/2010</td>
                                <td class="px-2 text-nowrap">Microsoft</td>
                                <td class="px-2 w-100">Développeur</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
            <?php // Administration des formations
                elseif ($manage == "formations"): ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 col-lg-1 align-self-center mb-2">
                                    <label for="dateformation">Date :</label>
                                </div>
                                <div class="col-4 col-lg-3 px-0 mb-2">
                                    <input type="month" name="dateformation" id="dateformation" class="form-control px-1" required>
                                </div>
                                <div class="col-10 col-lg-7 mb-2">
                                    <input type="text" name="formation" id="formation" class="form-control" placeholder="Diplôme ou titre">
                                </div>
                                <div class="col-2 col-lg-1 align-self-center mb-2">
                                    <input type="checkbox" class="form-check-input" id="formationobtenue" name="formationobtenue">
                                    <label class="form-check-label" for="formationobtenue">obtenue</label>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-8">
                                    <input type="text" name="organisme" id="organisme" class="form-control" placeholder="Organisme">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="ville" id="ville" class="form-control" placeholder="Ville (départ.)">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <textarea name="description" id="description" class="form-control" placeholder="Description (facultative)"></textarea>
                                </div>
                            </div>

                            <div class="row justify-content-end mb-2">
                                <div class="col-12 col-lg-4 text-right">
                                    <button class="btn btn-secondary w-100">Ajouter une nouvelle formation</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <h4>Mes formations</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th class="text-nowrap">Diplôme / Titre</th>
                                <th>Organisme</th>
                                <th class="text-nowrap">Ville (départ.)</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="px-2">1</th>
                                <td class="px-2 text-nowrap">01/01/1970</td>
                                <td class="px-2 w-100">Animateur e-commerce</td>
                                <td class="px-2 text-nowrap">Avenir 84</td>
                                <td class="px-2 text-nowrap">Avignon (84)</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">2</th>
                                <td class="px-2 text-nowrap">01/01/1980</td>
                                <td class="px-2 w-100">Développeur web</td>
                                <td class="px-2 text-nowrap">Avenir 84</td>
                                <td class="px-2 text-nowrap">Avignon (84)</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">3</th>
                                <td class="px-2 text-nowrap">01/01/2000</td>
                                <td class="px-2 w-100">Développeur Java EE</td>
                                <td class="px-2 text-nowrap">Avenir 84</td>
                                <td class="px-2 w-100">Avignon (84)</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
            <?php // Administration des loisirs
                elseif ($manage == "loisirs"): ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-2">
                                <input type="text" name="icon" id="icon" class="form-control" placeholder="Icone (Font Awesome par exemple)">
                                </div>
                                <div class="col-12 col-lg-8 mb-2">
                                    <input type="text" name="loisir" id="loisir" class="form-control" placeholder="Nouveau loisir">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <textarea name="description" id="description" class="form-control" placeholder="Description (facultative)"></textarea>
                                </div>
                            </div>

                            <div class="row justify-content-end mb-2">
                                <div class="col-12 col-lg-4 text-right">
                                    <button class="btn btn-secondary w-100">Ajouter un nouveau loisir</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <h4>Mes loisirs</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>FA</th>
                                <th>Loisir</th>
                                <th>Description</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="px-2">1</th>
                                <td class="px-2 text-nowrap"><i class="fas fa-parachute-box"></i></td>
                                <td class="px-2 text-nowrap">Parachutisme...</td>
                                <td class="px-2 w-100">Sa description...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">2</th>
                                <td class="px-2 text-nowrap"><i class="fas fa-skiing"></i></td>
                                <td class="px-2 text-nowrap">Ski...</td>
                                <td class="px-2 w-100">Sa description...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">3</th>
                                <td class="px-2 text-nowrap"><i class="fas fa-film"></i></td>
                                <td class="px-2 text-nowrap">Cinéma...</td>
                                <td class="px-2 w-100">Sa description...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                            <tr>
                                <th scope="row" class="px-2">3</th>
                                <td class="px-2 text-nowrap"><i class="fas fa-book-reader"></i></td>
                                <td class="px-2 text-nowrap">Lecture...</td>
                                <td class="px-2 w-100">Sa description...</td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btn btn-sm btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
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
                                        <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="Téléphone" value="<?=$user-> getTelephone();?>" >
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="poste" id="poste" class="form-control" placeholder="Poste recherché" value="<?=$user-> posteRecherche();?>" >
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-3 col-xl-3 align-self-center">
                                                <label for="datenaissance">Date de naissance</label>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                <input type="date" name="datenaissance" id="datenaissance" class="form-control px-1" value="<?=$user-> getDateNaissance()->format('Y-m-d');?>" required>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-5 col-xl-5 pl-5 pr-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="checkbox" class="form-check-input" id="afficherdate" name="afficherdate" <?php if ($user-> getAfficherDateNaissance()) echo "checked";?>>
                                                        <label class="form-check-label" for="afficherdate">Afficher ma date de naissance</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <input type="checkbox" class="form-check-input" id="afficherage" name="afficherage" <?php if ($user-> getAfficherAge()) echo "checked";?>>
                                                        <label class="form-check-label" for="afficherage">Afficher mon age</label>
                                                    </div>
                                                </div>
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