<?php
/** @var object $app */

$sql = "insert into link set
            block_id = :block_id,
            name = :name,
            href = :href,
            icon = :icon,
            private = :private  
";

/** @var PDOStatement $stmt */
$stmt = $app->pdo->prepare($sql);
$stmt->execute([
    'block_id' => $_POST['block_id'],
    'name'     => $_POST['name'],
    'href'     => $_POST['href'],
    'icon'     => $_POST['icon'],
    'private'  => $_POST['private'],
]);

return $app->pdo->lastInsertId();
