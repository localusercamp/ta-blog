{extends file="layouts/layout.tpl"}

{block name="content"}
    <header class="page-header">
        <h1 class="page-header__title">{$category->title|escape}</h1>
        <p class="page-header__description">{$category->description|escape}</p>
        <p class="page-header__meta">Всего статей: {$total}</p>
    </header>

    <div class="toolbar">
        <p class="toolbar__label">Сортировка</p>
        <div class="sort-links">
            <a class="sort-link{if $sort === 'date'} sort-link--active{/if}" href="/category/{$category->id}?sort=date">По дате</a>
            <a class="sort-link{if $sort === 'views'} sort-link--active{/if}" href="/category/{$category->id}?sort=views">По просмотрам</a>
        </div>
    </div>

    <h2 class="visually-hidden">Статьи</h2>

    {if $posts}
        <div class="post-grid">
            {foreach $posts as $post}
                {include file="partials/post-card.tpl" post=$post}
            {/foreach}
        </div>
    {else}
        <p class="empty-state">В этой категории пока нет статей.</p>
    {/if}

    {if $lastPage > 1}
        <nav class="pagination" aria-label="Постраничная навигация">
            {if $page > 1}
                <a class="pagination__link" href="/category/{$category->id}?sort={$sort}&amp;page={$previousPage}">← Назад</a>
            {else}
                <span></span>
            {/if}
            <span class="pagination__status">Страница {$page} из {$lastPage}</span>
            {if $page < $lastPage}
                <a class="pagination__link" href="/category/{$category->id}?sort={$sort}&amp;page={$nextPage}">Вперёд →</a>
            {else}
                <span></span>
            {/if}
        </nav>
    {/if}
{/block}
