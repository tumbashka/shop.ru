<?php

namespace tumba;

abstract class AbstractModel
{
    public array $attributes = [];
    public array $errors = [];
    public array $rules = [];
    public array $labels = [];

    public function __construct()
    {
        DB::getInstance();
    }


}