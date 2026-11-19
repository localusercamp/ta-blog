{extends file="layouts/error.tpl"}

{block name="content"}
    <div class="error-page__card">
        <p class="error-page__code">500</p>
        <h1 class="error-page__title">Что-то пошло не так</h1>
        <p class="error-page__text">Внутренняя ошибка сервера. Мы уже записали её в журнал и постараемся исправить.</p>
        <a class="button" href="/">На главную</a>
    </div>
{/block}
