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

        <h3>Voici les demandes de contact</h3>
        <h4>reçues par mes visiteurs</h4>

        <?php if ($alert-> isset()): ?>
            <?= $alert; ?>
        <?php endif; ?>
        
        
        <table class="table table-striped mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Sujet</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($messages as $message) { ?>
                    <tr>
                        <th scope="row" class="px-2"><?= $message-> getId(); ?></th>

                        <td class="px-1 w-25"><?= $message-> getDate()-> format("d/m/Y H:i"); ?></td>

                        <td class="px-1 w-25 text-nowrap"><?= $message-> getName(); ?></td>

                        <td class="px-1 w-25 text-nowrap"><?= $message-> getFrom(); ?></td>

                        <td class="text-nowrap"> <?= $message-> getSubject(); ?> </td>

                        <td>
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#modal-<?= $message-> getId(); ?>" title="Ouvrir le message"><i class="fas fa-eye"></i></button>
                        </td>

                        <td>
                            <form action="">
                                <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                <input type="hidden" name="action" value="reply">
                                <button class="btn btn-sm btn-outline-secondary" title="Marquer comme lu"><i class="fas fa-book-reader"></i></button>
                            </form>
                        </td>

                        <td>
                            <form action="">
                                <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                <input type="hidden" name="action" value="reply">
                                <button class="btn btn-sm btn-outline-secondary" title="Répondre au message"><i class="fas fa-reply"></i></button>
                            </form>
                        </td>

                        <td>
                            <form action="">
                                <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                <input type="hidden" name="action" value="delete">
                                <button class="btn btn-sm btn-outline-secondary" title="Supprimer le message"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
        
    </main>

<?php
    include_once "inc/parts/footer.php";
?>