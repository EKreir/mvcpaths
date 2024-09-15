<?php

$table = App::getInstance()->getTable('Category');

if (!empty($_POST)) {
    $result = $table->create([
        'titre' => $_POST['titre']
    ]);

    if ($result) {
        header('Location: admin.php?p=categories.index');
    }
}

$form = new Core\HTML\BootstrapForm($_POST);

?>

<form method="post">
    <?= $form->input('titre', label: 'Titre de l\'article'); ?>
    <button class="btn btn-primary">Sauvegarder</button>
</form>