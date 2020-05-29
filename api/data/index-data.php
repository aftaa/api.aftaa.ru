<?php

$sql = 'SELECT l.id, l.name AS link_name, b.name AS block_name, '
    . 'col_num, href, icon '
    . 'FROM link l JOIN link_block b ON l.block_id=b.id '
    . 'WHERE b.deleted = FALSE AND l.deleted = FALSE '
    . 'AND l.private = FALSE AND b.private = FALSE '
    . 'ORDER BY b.sort, l.name';

$rows = $pdo->query($sql);

$data = [];
while ($row = $rows->fetchObject()) {
    $link = (object)[
        'id'   => $row->id,
        'name' => $row->link_name,
        'href' => $row->href,
        'icon' => $row->icon,
    ];

    $data[$row->col_num][$row->block_name][] = $link;
}

echo (object)[
    'columns' => $data,
];
