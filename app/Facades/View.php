<?php

declare(strict_types=1);

namespace App\Facades;

use Smarty;

final class View extends Facade
{
    protected static ?Facade $instance = null;

    private Smarty $smarty;

    public function __construct(
        string $template_dir,
        string $compile_dir,
        string $cache_dir,
    ) {
        $smarty = new Smarty();
        $smarty->setTemplateDir($template_dir);
        $smarty->setCompileDir($compile_dir);
        $smarty->setCacheDir($cache_dir);
        $smarty->setCaching(Smarty::CACHING_OFF);
        $smarty->setCompileCheck(Smarty::COMPILECHECK_ON);

        $this->smarty = $smarty;
    }

    public static function render(string $template, array $data = []): void
    {
        self::instance()->smarty->assign($data);
        self::instance()->smarty->display($template);
    }
}
