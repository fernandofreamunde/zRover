<?php


namespace App\Exception;


class UnsupportedCardinalPoint extends \Exception
{
    protected $message = 'Unsuported direction, please only use N, E, S, W';
}