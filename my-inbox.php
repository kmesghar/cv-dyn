<?php
    session_name("my-dynamic-cv");
    session_start();
    
    if (!isset($_SESSION["user"]))
        header("Location: ./");

    include_once "inc/utils/functions.php";

    include_once "inc/class/alert.class.php";
    include_once "inc/class/message.class.php";

    $alert = new Alert();
    $filtre = "news";

    if (!isset($_GET['filtre'])) {
        $messages = Message::loadAll(Message::LOAD_ONLY_NOT_READ);
    } else {
        $filtre = $_GET['filtre'];
        switch ($filtre) {
            case "all":
                $messages = Message::loadAll(Message::LOAD_ALL);
                break;
            case "news":
                $messages = Message::loadAll(Message::LOAD_ONLY_NOT_READ);
                break;
            case "read":
                $messages = Message::loadAll(Message::LOAD_ONLY_READ);
                break;
            case "archives":
                $messages = Message::loadAll(Message::LOAD_ONLY_ARCHIVED);
                break;
            case "trash":
                $messages = Message::loadAll(Message::LOAD_ONLY_TRASHED);
                break;
            default:
                $messages = Message::loadAll(Message::LOAD_ONLY_NOT_READ);
                break;
        }
    }
    
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
        
        <form action="" class="mt-3 float-right" id="filtre">
            <div class="form-group form-inline">
                <label for="filtre">Filtrer&nbsp;:&nbsp;&nbsp;
                    <select name="filtre" id="filtre" class="form-control" onchange="document.getElementById('filtre').submit()">
                        <option value="all" <?php if ($filtre=="all") echo "selected"; ?>>Tous mes messages</option>
                        <option value="news" <?php if ($filtre=="news") echo "selected"; ?>>Non lus seulement</option>
                        <option value="read" <?php if ($filtre=="read") echo "selected"; ?>>Lus seulement</option>
                        <option value="archives" <?php if ($filtre=="archives") echo "selected"; ?>>Voir les message archivés</option>
                        <option value="trash" <?php if ($filtre=="trash") echo "selected"; ?>>Voir les message dans la corbeille</option>
                    </select>
                </label>
            </div>
        </form>
        
        <table class="table table-striped mt-3">
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

                        <td class="px-1">
                            <button class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#modal-<?= $message-> getId(); ?>" title="Ouvrir le message"><i class="fas fa-eye"></i></button>
                        </td>

                        <td class="px-1">
                            <form action="">
                                <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                <input type="hidden" name="action" value="reply">
                                <button class="btn btn-sm btn-outline-secondary" title="Marquer comme lu"><i class="fas fa-book-reader"></i></button>
                            </form>
                        </td>

                        <td class="px-1">
                            <form action="">
                                <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                <input type="hidden" name="action" value="reply">
                                <button class="btn btn-sm btn-outline-secondary" title="Répondre au message"><i class="fas fa-reply"></i></button>
                            </form>
                        </td>

                        <td class="px-1">
                            <form action="">
                                <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                <input type="hidden" name="action" value="delete">
                                <button class="btn btn-sm btn-outline-secondary" title="Archiver le message"><i class="fas fa-archive"></i></button>
                            </form>
                        </td>

                        <td class="px-1">
                            <form action="">
                                <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                <input type="hidden" name="action" value="delete">
                                <button class="btn btn-sm btn-outline-secondary" title="Supprimer le message"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>

                
                <?php foreach ($messages as $message): ?>
                    <!-- Modal -->
                        <div class="modal fade" id="modal-<?= $message-> getId(); ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="sbl"><?= $message-> getFrom(); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?= $message-> getSubject(); ?></p>
                                        <hr>
                                        <p><?= $message-> getMessage(); ?></p>

                                        <hr>
                                        <h6>Informations:</h6>
                                            Message <?= $message-> getName(); ?> <<?= $message-> getFrom(); ?>><br>
                                            <?php if ($message-> getPhone() != ""): ?>
                                                Joignable au <?= $message-> getPhone(); ?><br>
                                            <?php endif; ?>
                                            recu le <?=  $message-> getDate()-> format("d/m/Y"); ?> à <?=  $message-> getDate()-> format("H:i"); ?><br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i> Supprimer</button>
                                        <button type="button" class="btn btn-outline-warning"><i class="fas fa-archive"></i> Archiver</button>
                                        <button type="button" class="btn btn-outline-secondary"><i class="fas fa-reply"></i> Répondre</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

            </tbody>
        </table>
        
    </main>

<?php
    include_once "inc/parts/footer.php";
?>