<?php

$category = App::getInstance()->getTable(name: 'Category');

if (!empty($_POST)) {
    $result = $category->delete($_POST['id']);

    header('Location: admin.php?p=categories.index');
}