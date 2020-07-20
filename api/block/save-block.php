<?php

/** @var object $app */

$sql = "update link_block set
            name = :name,
            col_num = :col_num,
            sort = :sort,                           
            private = :private
        where
            id = :id
";

/** @var PDOStatement $stmt */
$stmt = $app->pdo->prepare($sql);
$stmt->execute([
    'name'    => $_POST['name'],
    'col_num' => $_POST['col_num'],
    'sort'    => $_POST['sort'],
    'private' => $_POST['private'],
    'id'      => $_POST['id'],
]);

return $stmt->rowCount();
