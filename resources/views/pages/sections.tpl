{extends file="layouts/layout.tpl"}

{block name="content"}
    <header class="page-header">
        <h1 class="page-header__title">Все разделы</h1>
        <p class="page-header__description">Выберите тему, чтобы посмотреть статьи.</p>
    </header>

    {if $sections}
        <div class="section-grid">
            {foreach $sections as $section}
                <a class="section-card" href="/category/{$section.category->id}">
                    <h2 class="section-card__title">{$section.category->title|escape}</h2>
                    <p class="section-card__description">{$section.category->description|escape}</p>
                    <p class="section-card__meta">Статей: {$section.postCount}</p>
                </a>
            {/foreach}
        </div>
    {else}
        <p class="empty-state">Пока нет ни одного раздела.</p>
    {/if}
{/block}
