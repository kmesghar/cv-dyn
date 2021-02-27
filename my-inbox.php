<?php
    session_name("my-dynamic-cv");
    session_start();
    
    if (!isset($_SESSION["user"]))
        header("Location: ./");

    include_once "inc/utils/functions.php";

    include_once "inc/class/alert.class.php";
    include_once "inc/class/message.class.php";

    $alert = new Alert();
    $messages = Message::loadAll(Message::LOAD_ONLY_NOT_READ);
    
    $page = "my-inbox";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1>Mon CV en ligne dynamique avec porte-folio !</h1>

        <h3>Vous souhaitez me contacter ?</h3>

        <?php if ($alert-> isset()): ?>
            <?= $alert; ?>
        <?php endif; ?>

        
    </main>

<?php
    include_once "inc/parts/footer.php";
?>