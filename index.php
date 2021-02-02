<?php
    session_name("my-dynamic-cv");
    session_start();

    include_once "inc/class/article.class.php";
    
    $articles = Article::loadAllPublished();

    $page = "home";
    include_once "inc/parts/header.php";
?>
    <main class="container mt-3">
        <h1 class="mb-5">Mon CV en ligne dynamique avec porte-folio !</h1>

        <?php foreach ($articles as $article): ?>
        <div class="row my-4">
            <div class="col-3">
                <?php if ($article-> getImage() != ""): ?>
                    <img src="<?= $article-> getImage(); ?>" alt="<?= $article-> getTitle(); ?>" class="img-thumbnail rounded">
                <?php endif; ?>
            </div>
            <div class="col-9">
                <h3><?= $article-> getTitle(); ?></h3>
                <?php if ($article-> getAbstract() != ""):
                    echo $article-> getAbstract();
                else:
                    echo substr($article-> getContent(), 0, 1000);
                endif; ?>
            </div>
        </div>
        <?php endforeach; ?>

    </main>

    <?php
        include_once "inc/parts/footer.php";
    ?>