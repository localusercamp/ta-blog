<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$title|escape}</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <header class="site-header">
        <div class="container site-header__inner">
            <a class="brand" href="/">{$appName|escape}</a>
            <nav class="site-nav" id="site-nav" aria-label="Разделы">
                {if $navCategories}
                    {foreach $navCategories as $category}
                        <a class="site-nav__link" href="/category/{$category->id}">{$category->title|escape}</a>
                    {/foreach}
                {/if}
            </nav>
            <button class="nav-toggle" type="button" aria-controls="site-nav" aria-expanded="false" aria-label="Открыть меню">
                <span class="nav-toggle__line"></span>
                <span class="nav-toggle__line"></span>
                <span class="nav-toggle__line"></span>
            </button>
        </div>
    </header>

    <main class="site-main" id="main">
        <div class="container">
            {block name="content"}{/block}
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="site-footer__inner">
                <div class="site-footer__brand">
                    <a class="brand" href="/">{$appName|escape}</a>
                    <p class="site-footer__tagline">Спокойный блог о разработке: PHP, базы данных, фронтенд и инфраструктура.</p>
                </div>
                <div>
                    <h2 class="site-footer__title">Разделы</h2>
                    <ul class="site-footer__links">
                        {if $footerCategories}
                            {foreach $footerCategories as $category}
                                <li><a class="site-footer__link" href="/category/{$category->id}">{$category->title|escape}</a></li>
                            {/foreach}
                        {/if}
                    </ul>
                </div>
            </div>
            <div class="site-footer__bottom">
                <span>© {$smarty.now|date_format:"%Y"} {$appName|escape}</span>
                <span>
                    <a class="site-footer__bottom-link" href="/sections">Все разделы</a>
                    ·
                    <a class="site-footer__bottom-link" href="/about">О блоге</a>
                </span>
            </div>
        </div>
    </footer>

    <script src="/assets/js/app.js" defer></script>
</body>
</html>
