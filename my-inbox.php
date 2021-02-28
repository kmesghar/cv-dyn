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

    $q = "";
    $pages = 1;

    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
        $url = "https"; 
    else
        $url = "http";
    $url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 

    // Nombre de messages par page
    $perPage = 20;

    if (isset($_POST["action"]) && isset($_POST["message"])) {
        switch ($_POST["action"]) {
            case "mark-unread":
                Message::_unsetFlagRead($_POST["message"]);
                break;
            case "mark-read":
                Message::_setFlagRead($_POST["message"]);
                break;
            case "reply":
                break;
            case "archive":
                Message::_setFlagArchive($_POST["message"]);
                break;
            case "unarchive":
                Message::_unsetFlagArchive($_POST["message"]);
                break;
            case "delete":
                Message::_delete($_POST["message"]);
                break;
            case "restore":
                Message::_restore($_POST["message"]);
                break;
            case "drop":
                break;
            default:
                break;
        }
    }

    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }

    if (!isset($_GET['filtre'])) {
        $nb_results = Message::count(Message::LOAD_ALL);

        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }else{
            $currentPage = 1;
        }
    
        // On calcule le nombre de pages total
        $pages = ceil($nb_results / $perPage);
    
        // Calcul du 1er message de la page
        $first = ($currentPage * $perPage) - $perPage;

        $messages = Message::loadAll(Message::LOAD_ONLY_NOT_READ, $first, $perPage);
    } else {
        $filtre = $_GET['filtre'];
        switch ($filtre) {
            case "all":
                $nb_results = Message::count(Message::LOAD_ALL);

                if(isset($_GET['page']) && !empty($_GET['page'])){
                    $currentPage = (int) strip_tags($_GET['page']);
                }else{
                    $currentPage = 1;
                }

                // On calcule le nombre de pages total
                $pages = ceil($nb_results / $perPage);

                // Calcul du 1er message de la page
                $first = ($currentPage * $perPage) - $perPage;

                $messages = Message::loadAll(Message::LOAD_ALL, $first, $perPage);
                break;
            case "news":
                $nb_results = Message::count(Message::LOAD_ONLY_NOT_READ);

                if(isset($_GET['page']) && !empty($_GET['page'])){
                    $currentPage = (int) strip_tags($_GET['page']);
                }else{
                    $currentPage = 1;
                }

                // On calcule le nombre de pages total
                $pages = ceil($nb_results / $perPage);

                // Calcul du 1er message de la page
                $first = ($currentPage * $perPage) - $perPage;

                $messages = Message::loadAll(Message::LOAD_ONLY_NOT_READ, $first, $perPage);
                break;
            case "read":
                $nb_results = Message::count(Message::LOAD_ONLY_READ);

                if(isset($_GET['page']) && !empty($_GET['page'])){
                    $currentPage = (int) strip_tags($_GET['page']);
                }else{
                    $currentPage = 1;
                }

                // On calcule le nombre de pages total
                $pages = ceil($nb_results / $perPage);

                // Calcul du 1er message de la page
                $first = ($currentPage * $perPage) - $perPage;

                $messages = Message::loadAll(Message::LOAD_ONLY_READ, $first, $perPage);
                break;
            case "archives":
                $nb_results = Message::count(Message::LOAD_ONLY_ARCHIVED);

                if(isset($_GET['page']) && !empty($_GET['page'])){
                    $currentPage = (int) strip_tags($_GET['page']);
                }else{
                    $currentPage = 1;
                }

                // On calcule le nombre de pages total
                $pages = ceil($nb_results / $perPage);

                // Calcul du 1er message de la page
                $first = ($currentPage * $perPage) - $perPage;

                $messages = Message::loadAll(Message::LOAD_ONLY_ARCHIVED, $first, $perPage);
                break;
            case "trash":
                $nb_results = Message::count(Message::LOAD_ONLY_TRASHED);

                if(isset($_GET['page']) && !empty($_GET['page'])){
                    $currentPage = (int) strip_tags($_GET['page']);
                }else{
                    $currentPage = 1;
                }

                // On calcule le nombre de pages total
                $pages = ceil($nb_results / $perPage);

                // Calcul du 1er message de la page
                $first = ($currentPage * $perPage) - $perPage;

                $messages = Message::loadAll(Message::LOAD_ONLY_TRASHED, $first, $perPage);
                break;
            default:
                $nb_results = Message::count(Message::LOAD_ONLY_NOT_READ);

                if(isset($_GET['page']) && !empty($_GET['page'])){
                    $currentPage = (int) strip_tags($_GET['page']);
                }else{
                    $currentPage = 1;
                }

                // On calcule le nombre de pages total
                $pages = ceil($nb_results / $perPage);

                // Calcul du 1er message de la page
                $first = ($currentPage * $perPage) - $perPage;

                $messages = Message::loadAll(Message::LOAD_ONLY_NOT_READ, $first, $perPage);
                break;
        }
    }
    
    $page = "my-inbox";
    include_once "inc/parts/header.php";

    /**
     * En cas d'inactivité !
     */
    if (!isset($_SESSION["user"]))
        header("Location: ./");
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
                    <tr <?php if (!$message-> getRead()) echo "class='font-weight-bold'"; ?> id="line-<?= $message-> getId(); ?>">
                        <th scope="row" class="px-2"><?= $message-> getId(); ?></th>

                        <td class="px-1 w-25"><?= $message-> getDate()-> format("d/m/Y H:i"); ?></td>

                        <td class="px-1 w-25 text-nowrap"><?= $message-> getName(); ?></td>

                        <td class="px-1 w-25 text-nowrap"><?= $message-> getFrom(); ?></td>

                        <td class="text-nowrap"> <?= $message-> getSubject(); ?> </td>

                        <td class="px-1">
                            <button class="btn btn-sm btn-outline-secondary w-100" data-toggle="modal" data-target="#modal-<?= $message-> getId(); ?>" title="Ouvrir le message" onclick="post('<?=$url;?>', <?= $message-> getId(); ?>, 'mark-read')"><i class="fas fa-eye"></i></button>
                        </td>

                        <td class="px-1" id="form-mark-read">
                            <?php if (!$message-> getDeleted()): ?>
                                <?php if ($message-> getRead()) : ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                        <input type="hidden" name="action" value="mark-unread">
                                        <button class="btn btn-sm btn-outline-secondary w-100" title="Marquer comme non lu"><i class="far fa-bell"></i></button>
                                    </form>
                                <?php else: ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                        <input type="hidden" name="action" value="mark-read">
                                        <button class="btn btn-sm btn-outline-secondary w-100" title="Marquer comme lu"><i class="far fa-bell-slash"></i></button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>

                        <td class="px-1">
                            <?php if (!$message-> getDeleted()): ?>
                                <form action="" method="post">
                                    <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                    <input type="hidden" name="action" value="reply">
                                    <button class="btn btn-sm btn-outline-secondary w-100" title="Répondre au message"><i class="fas fa-reply"></i></button>
                                </form>
                            <?php endif; ?>
                        </td>

                        <td class="px-1">
                            <?php if (!$message-> getDeleted()): ?>
                                <?php if ($message-> getArchived()): ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                        <input type="hidden" name="action" value="unarchive">
                                        <button class="btn btn-sm btn-outline-secondary w-100" title="Restaurer le message depuis les archives"><i class="fas fa-inbox"></i></button>
                                    </form>
                                <?php else: ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                        <input type="hidden" name="action" value="archive">
                                        <button class="btn btn-sm btn-outline-secondary w-100" title="Archiver le message"><i class="fas fa-archive"></i></button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>

                        <td class="px-1">
                            <?php if ($message-> getDeleted()): ?>
                                <form action="" method="post">
                                    <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                    <input type="hidden" name="action" value="restore">
                                    <button class="btn btn-sm btn-outline-secondary w-100" title="Restaurer le message"><i class="fas fa-trash-restore"></i></button>
                                </form>
                            <?php else: ?>
                                <form action="" method="post">
                                    <input type="hidden" name="message" value="<?= $message-> getId(); ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button class="btn btn-sm btn-outline-secondary w-100" title="Supprimer le message"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>

        <?php foreach ($messages as $message): ?>
        <!-- Modal-<?= $message-> getId(); ?> -->
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
                            <button type="button" class="btn btn-outline-danger" title="Mettre le message dans la corbeille"><i class="fas fa-trash-alt"></i> Supprimer</button>
                            <?php if ($message-> getArchived()): ?>
                                <button type="button" class="btn btn-outline-warning" title="Restaurer depuis les archives"><i class="fas fa-inbox"></i></i> Restaurer</button>
                            <?php else: ?>
                                <button type="button" class="btn btn-outline-warning" title="Archiver le message"><i class="fas fa-archive"></i> Archiver</button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-outline-secondary" title="Répondre au message"><i class="fas fa-reply"></i> Répondre</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if ($nb_results > 0): ?>
            <nav>
                <ul class="pagination justify-content-end">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="?filtre=<?=$filtre;?>&q=<?= $q; ?>&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                            <a href="?filtre=<?=$filtre;?>&q=<?= $q; ?>&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endfor ?>
                        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="?filtre=<?=$filtre;?>&q=<?= $q; ?>&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
        
    </main>

<?php
    include_once "inc/parts/footer.php";
?>