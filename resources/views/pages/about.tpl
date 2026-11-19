{extends file="layouts/layout.tpl"}

{block name="content"}
    <header class="page-header">
        <h1 class="page-header__title">О блоге</h1>
        <p class="page-header__description">Небольшой проект о разработке без лишних зависимостей.</p>
    </header>

    <div class="prose">
        <p class="prose__text">Этот блог собран на чистом PHP, Smarty и MySQL. Здесь публикуются заметки о практическом программировании: от работы с базой данных до настройки окружения.</p>
        <p class="prose__text">Материалы разбиты по разделам: PHP, MySQL, Frontend, DevOps и новости проекта. Каждый раздел можно открыть из шапки или подвала сайта.</p>
        <p class="prose__text">Интерфейс намеренно остаётся спокойным: минимум отвлекающих элементов и акцент на тексте и карточках статей.</p>
        <p class="prose__text">Начать можно с <a class="prose__link" href="/">главной страницы</a> или со списка <a class="prose__link" href="/sections">всех разделов</a>.</p>
    </div>
{/block}
