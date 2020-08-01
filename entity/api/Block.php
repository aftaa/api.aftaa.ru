<?php


namespace entity\api;

/**
 * Class Block
 * @package entity\api
 */
class Block
{
    public string $name;
    public int $col_num;
    public int $sort;
    public bool $private;

    /** @var Link[] $links */
    public array $links;
}