{extends file="layout.tpl"}

{block name="content"}
    <h1>{$category->title|escape}</h1>
    <p>{$category->description|escape}</p>

    <p>
        Сортировка:
        <a href="/category/{$category->id}?sort=date">по дате</a>
        <a href="/category/{$category->id}?sort=views">по просмотрам</a>
    </p>
    <p>Всего статей: {$total}</p>

    {if $posts}
        {foreach $posts as $post}
            <article>
                {if $post->image}
                    <img src="{$post->image|escape}" alt="{$post->title|escape}">
                {/if}
                <h3><a href="/post/{$post->id}">{$post->title|escape}</a></h3>
                <p>{$post->description|escape}</p>
                <p>{$post->publishedAt->format('d.m.Y')} · {$post->views} просмотров</p>
            </article>
        {/foreach}
    {else}
        <p>В этой категории пока нет статей.</p>
    {/if}

    {if $lastPage > 1}
        <nav>
            {if $page > 1}
                <a href="/category/{$category->id}?sort={$sort}&amp;page={$previousPage}">Назад</a>
            {/if}
            <span>Страница {$page} из {$lastPage}</span>
            {if $page < $lastPage}
                <a href="/category/{$category->id}?sort={$sort}&amp;page={$nextPage}">Вперёд</a>
            {/if}
        </nav>
    {/if}
{/block}
