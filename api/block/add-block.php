<?php

/** @var object $app */

$sql = "insert into link_block set
        name = :name,
        col_num = :col_num,
        private = :private,
        sort = 0
";

/** @var PDOStatement $stmt */
$stmt = $app->pdo->prepare($sql);
$stmt->execute([
    'name'    => $_POST['name'],
    'col_num' => $_POST['col_num'],
    'private' => $_POST['private'],
]);

return $stmt->rowCount();
