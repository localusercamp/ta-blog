<?php

declare(strict_types=1);

namespace App\Facades;

use Smarty;

final class View extends Facade
{
    protected static ?Facade $instance = null;

    private Smarty $smarty;

    /**
     * @var array<string, mixed>
     */
    private array $shared = [];

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

    /**
     * @param array<string, mixed> $data
     */
    public static function share(array $data): void
    {
        $view = self::instance();
        $view->shared = array_merge($view->shared, $data);
    }

    public static function render(string $template, array $data = []): void
    {
        $view = self::instance();
        $view->smarty->assign(array_merge($view->shared, $data));
        $view->smarty->display($template);
    }
}
