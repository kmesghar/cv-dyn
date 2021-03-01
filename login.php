<?php
    session_name("my-dynamic-cv");
    session_start();

    // Inclusion des fichiers des classes
    include_once "inc/class/alert.class.php";
    include_once "inc/class/user.class.php";

    // Déclarations des objets
    $alert = new Alert();
    $user = new User();

    // Déclarations des variables utiles
    $email = "";

    if (!empty($_POST) && isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $pass = $_POST["password"];

        if ($email == "") {
            $alert-> setType("alert-warning");
            $alert-> setTitle("Connexion impossible !");
            $alert-> setContent("Merci de compléter les champs !"); 
        } else {
            if ($user-> login($email, $pass)) {
                $_SESSION["user"] = serialize($user);
                header("Location: my-dashboard.php");
            } else {
                $alert-> setType("alert-danger");
                $alert-> setTitle("Connexion impossible !");
                $alert-> setContent("Merci de vérifier les champs !"); 
            }
        }
    }
    
    $page = "login";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3 mb-5 pb-5 rounded-lg" id="login-main">
        <h3 class="mb-5 text-secondary text-center">Connectez-vous !</h3>

        <?php if ($alert->isset()) : ?>
        
        <div class="row justify-content-center">
            <div class="col-6">
                <?= $alert; ?>
            </div>
        </div>

        <?php endif; ?>

        <div class="row justify-content-center mb-5">
            <div class="col-6 bg-form rounded-lg">
                <form action="login.php" method="post" class="my-5">
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?=$email;?>" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="•••">
                    </div>

                    <button class="btn btn-secondary w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </main>

    <?php
        include_once "inc/parts/footer.php";
    ?>