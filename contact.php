<?php
    session_name("my-dynamic-cv");
    session_start();

    include_once "inc/utils/functions.php";

    include_once "inc/class/alert.class.php";
    include_once "inc/class/message.class.php";

    $alert = new Alert();
    $message = new Message();

    @$message-> setFrom(($_POST["email"]) ? validateInputs($_POST["email"]) : "");
    @$message-> setName(($_POST["nom"]) ? validateInputs($_POST["nom"]) : "");
    @$message-> setPhone(($_POST["telephone"]) ? validateInputs($_POST["telephone"]) : "");
    @$message-> setSubject(($_POST["objet"]) ? validateInputs($_POST["objet"]) : "");
    @$message-> setMessage(($_POST["message"]) ? validateInputs($_POST["message"]) : "");

    if (!empty($_POST)) {
        if (!isset($_POST["email"]) || $_POST["email"] == "") {
            $alert-> setType("alert-danger");
            $alert-> setTitle("Désolé !");
            $alert-> setContent("Il nous est nécessaire de connaître votre adresse email pour vous répondre !");
            $alert-> setFooter("Merci de renseigner votre adresse email.");
        } else if (!isset($_POST["objet"]) || $_POST["objet"] == "") {
            $alert-> setType("alert-danger");
            $alert-> setTitle("Désolé !");
            $alert-> setContent("Le traitement de votre demande est acceléré si l'objet en est bien identifié !");
            $alert-> setFooter("Merci de préciser l'objet de votre demande.");
        } else if (!isset($_POST["message"]) || $_POST["message"] == "") {
            $alert-> setType("alert-danger");
            $alert-> setTitle("Désolé !");
            $alert-> setContent("Sans message, il nous sera impossible de traiter votre demande !");
            $alert-> setFooter("Merci détailler votre demande dans la partie réservée (message).");
        } else {
            // Tenter de sauvegarder le message dans la base de données :
            if ($message-> save()) {
                $alert-> setType("alert-success");
                $alert-> setTitle("Félicitations !");
                $alert-> setContent("Votre message a bien été envoyé !");
                $alert-> setFooter("Votre demande sera traité dans les meilleurs délais.");

                // Envoyer un mail de notification à l'administrateur
                
            } else {
                $alert-> setType("alert-danger");
                $alert-> setTitle("Désolé !");
                $alert-> setContent("Votre message n'a pu être envoyé !");
                $alert-> setFooter("Merci d'essayer à nouveau.");
            }
        }
    }
    
    $page = "contact";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1>Mon CV en ligne dynamique avec porte-folio !</h1>

        <h3>Vous souhaitez me contacter ?</h3>

        <?php if ($alert-> isset()): ?>
            <?= $alert; ?>
        <?php endif; ?>

        <form action="" method="post" class="my-5 p-2">
            <div class="form-group">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-12 col-lg-7 col-xl-7 mb-2">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Votre adresse email" value="<?= $message-> getFrom(); ?>" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-7 col-lg-4 col-xl-4 mb-2">
                        <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="Votre nom">
                    </div>
                    <div class="col-12 col-md-5 col-lg-3 col-xl-3 mb-2">
                        <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="Votre téléphone">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row justify-content-lg-center">
                    <div class="col-12 col-md-7 col-lg-7 col-xl-7">
                        <select name="objet" id="objet" class="form-control" required>
                            <option value="">Objet de votre message</option>
                            <option value="Proposition d'emploi">proposition d'emploi</option>
                            <option value="Demande de contact">Demande de contact</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-12 col-lg-7 col-xl-7">
                        <textarea name="message" id="message" class="form-control" placeholder="Merci de détailler ici votre demande..." required></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group text-right">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-7 col-lg-4 col-xl-4"></div>
    
                    <div class="col-12 col-md-5 col-lg-3 col-xl-3 mb-2">
                        <button class="btn btn-secondary w-100">Envoyer le message !</button>
                    </div>
                </div>
            </div>
        </form>
    </main>

<?php
    include_once "inc/parts/footer.php";
?>