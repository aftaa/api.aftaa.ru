<?php

/** @var object $app */

$sql = 'SELECT l.id, l.name AS link_name, b.name AS block_name, '
    . 'col_num, href, icon '
    . 'FROM link l JOIN link_block b ON l.block_id=b.id '
    . 'WHERE b.deleted = FALSE '
    . 'AND l.deleted = FALSE '
    . 'ORDER BY b.sort, l.name';

$rows = $app->pdo->query($sql);

$data = [];

while ($row = $rows->fetchObject()) {
    $link = (object)[
        'id'   => $row->id,
        'name' => $row->link_name,
        'href' => $row->href,
        'icon' => 'http://api.aftaa.ru.local' . $row->icon,
    ];
    $data[$row->col_num][$row->block_name][] = $link;
}

return [
    'columns' => $data,
];
