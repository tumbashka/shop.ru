<?php

namespace tumba;

trait TSingleton
{
    private static self|null $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): static
    {
        return static::$instance ?? static::$instance = new static();
    }
}