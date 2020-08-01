<?php

$sql = 'SELECT l.id AS link_id, b.id AS block_id, l.name AS link_name, b.name AS block_name, '
     . 'col_num, href, icon, b.private AS block_private, l.private AS link_private '
     . 'FROM link_block b LEFT JOIN link l ON l.block_id=b.id AND l.deleted = FALSE '
     . 'WHERE b.deleted = FALSE ORDER BY b.sort, l.name';

$rows = $app->pdo->query($sql);

$data = [];
while ($row = $rows->fetchObject()) {

    if (!array_key_exists($row->col_num, $data)) {
        $data[$row->col_num] = [];
    }

    if (!array_key_exists($row->block_name, $data[$row->col_num])) {
        $data[$row->col_num][$row->block_name] = (object)[
            'id'      => $row->block_id,
            'name'    => $row->block_name,
            'private' => (bool)$row->block_private,
            'links'   => [],
        ];
    }

    $data[$row->col_num][$row->block_name]->links[] = (object)[
        'id'      => $row->link_id,
        'name'    => $row->link_name,
        'href'    => $row->href,
        'icon'    => 'https://api.aftaa.ru' . $row->icon,
        'private' => (bool)$row->link_private,
    ];
}


return [
    'columns' => $data,
];
