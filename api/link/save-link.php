<?php

/** @var object $app */

$sql = "update link set
            block_id = :block_id,
            name = :name,
            href = :href,
            icon = :icon,
            private = :private
        where
            id = :id            
";

/** @var PDOStatement $stmt */
$stmt = $app->pdo->prepare($sql);
$stmt->execute([
    'block_id' => $_POST['block_id'],
    'name'     => $_POST['name'],
    'href'     => $_POST['href'],
    'icon'     => $_POST['icon'],
    'private'  => $_POST['private'],
    'id'       => $_POST['id'],
]);

return $stmt->rowCount();
