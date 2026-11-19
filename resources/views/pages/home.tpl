{extends file="layouts/layout.tpl"}

{block name="content"}
    <section class="hero">
        <h1 class="hero__title">{$appName|escape}</h1>
        <p class="hero__lead">Заметки о разработке: практический PHP, работа с базами данных, фронтенд и инфраструктура.</p>
    </section>

    {if $sections}
        {foreach $sections as $section}
            <section class="section-block">
                <div class="section-block__header">
                    <div class="section-block__heading">
                        <h2 class="section-block__title">{$section.category->title|escape}</h2>
                        <p class="section-block__description">{$section.category->description|escape}</p>
                    </div>
                    <a class="section-link" href="/category/{$section.category->id}">Все статьи</a>
                </div>

                {if $section.posts}
                    <div class="post-grid">
                        {foreach $section.posts as $post}
                            {include file="partials/post-card.tpl" post=$post}
                        {/foreach}
                    </div>
                {else}
                    <p class="empty-state">В этом разделе пока нет статей.</p>
                {/if}
            </section>
        {/foreach}
    {else}
        <p class="empty-state">Пока нет разделов со статьями.</p>
    {/if}
{/block}
