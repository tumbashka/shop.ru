<?php

namespace tumba;

use RedBeanPHP\R;
use Valitron\Validator;

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

    public function load($data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function validate($data): bool
    {
        Validator::langDir(APP . '/languages/validator/lang');
        Validator::lang(App::$appReg->getProperty('language')['code']);
        $validator = new Validator($data);
        $validator->rules($this->rules);
        $validator->labels($this->getLabels());
        if ($validator->validate()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }

    }

    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            foreach ($error as $errorItem) {
                $errors .= '<li>' . $errorItem . '</li>';
            }
        }
        $errors .= '</ul>';
        $_SESSION['errors'] = $errors;
        return $errors;
    }

    public function getLabels(): array
    {
        $labels = [];
        foreach ($this->labels as $key => $value) {
            $labels[$key] = getLang($value);
        }
        return $labels;
    }

    public function save($table): int|string
    {
        $tbl = R::dispense($table);
        foreach ($this->attributes as $name => $value) {
            if ($value != '') {
                $tbl->$name = $value;
            }
        }
        return R::store($tbl);
    }

}