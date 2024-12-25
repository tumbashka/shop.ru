<?php

namespace app\widgets\language;

use RedBeanPHP\R;
use tumba\App;

class Language
{
    protected string $tpl;
    protected array $languages;
    protected array $language;

    public function __construct()
    {
        $this->tpl = __DIR__ . "/lang_tpl.php";
        $this->run();
    }

    protected function run()
    {
        $this->languages = App::$appReg->getProperty('languages');
        $this->language = App::$appReg->getProperty('language');
        echo $this->getHTML();
    }

    public static function getLanguages(): array
    {
        return R::getAssoc('SELECT code, title, base, id FROM language ORDER BY base DESC ');
    }

    public static function getLanguage($languages)
    {
        $lang = App::$appReg->getProperty('lang');
        if ($lang && array_key_exists($lang, $languages)) {
            $key = $lang;
        } elseif (!$lang) {
            $key = key($languages);
        } else {
            $lang = h($lang);
            throw new \Exception("Language {$lang} not found in database", 404);
        }
        $lang_info = $languages[$key];
        $lang_info['code'] = $key;
        return $lang_info;
    }

    protected function getHTML(): string
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}