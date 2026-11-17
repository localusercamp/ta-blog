<?php

declare(strict_types=1);

namespace App\Core;

use Smarty;

final class View
{
    private static View $instance;

    private Smarty $smarty;

    public function __construct()
    {
        $smarty = new Smarty();
        $smarty->setTemplateDir('');
        $smarty->setCompileDir('');
        $smarty->setCacheDir('');
        $smarty->setCaching(Smarty::CACHING_OFF);
        $smarty->setCompileCheck(Smarty::COMPILECHECK_ON);

        $this->smarty = $smarty;
    }

    public static function register(): void
    {
        self::$instance = new View();
    }



    public static function render(string $template, array $data = []): void
    {
        self::$instance->smarty->assign($data);
        self::$instance->smarty->display($template);
    }
}
