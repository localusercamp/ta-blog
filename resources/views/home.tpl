{extends file="layout.tpl"}

{block name="content"}
    {if $sections}
        {foreach $sections as $section}
            <section>
                <h2>{$section.category->title|escape}</h2>
                <p>{$section.category->description|escape}</p>

                {foreach $section.posts as $post}
                    <article>
                        {if $post->image}
                            <img src="{$post->image|escape}" alt="{$post->title|escape}">
                        {/if}
                        <h3><a href="/post/{$post->id}">{$post->title|escape}</a></h3>
                        <p>{$post->description|escape}</p>
                        <p>{$post->publishedAt->format('d.m.Y')} · {$post->views} просмотров</p>
                    </article>
                {/foreach}

                <a href="/category/{$section.category->id}">Все статьи</a>
            </section>
        {/foreach}
    {else}
        <p>Пока нет категорий со статьями.</p>
    {/if}
{/block}
