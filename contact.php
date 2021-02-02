<?php
    session_name("my-dynamic-cv");
    session_start();
    
    $page = "contact";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1>Mon CV en ligne dynamique avec porte-folio !</h1>

        <h3>Vous souhaitez me contacter ?</h3>

        <form action="" method="post" class="my-5 p-2">
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Votre adresse email" required>
                    </div>
                    <div class="col">
                        <input type="tel" name="telephone" id="telephone" class="form-control" placeholder="Votre téléphone">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <select name="objet" id="objet" class="form-control" required>
                    <option value="">Objet de votre message</option>
                    <option value="Proposition d'emploi">proposition d'emploi</option>
                    <option value="Demande de contact">Demande de contact</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>

            <div class="form-group">
                <textarea name="message" id="message" class="form-control" placeholder="Merci de détailler ici votre demande..."></textarea>
            </div>

            <div class="form-group text-right">
                <button class="btn btn-secondary">Envoyer le message !</button>
            </div>
        </form>
    </main>

<?php
    include_once "inc/parts/footer.php";
?>