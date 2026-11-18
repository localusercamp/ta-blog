{extends file="layout.tpl"}

{block name="content"}
    <article>
        {if $post->image}
            <img src="{$post->image|escape}" alt="{$post->title|escape}">
        {/if}
        <h1>{$post->title|escape}</h1>
        <p>{$post->description|escape}</p>
        <p>{$post->publishedAt->format('d.m.Y')} · {$post->views} просмотров</p>
        {if $post->categories}
            <p>
                Категории:
                {foreach $post->categories as $category}
                    <a href="/category/{$category->id}">{$category->title|escape}</a>{if !$category@last}, {/if}
                {/foreach}
            </p>
        {/if}
        <div>{$post->content}</div>
    </article>

    {if $similarPosts}
        <section>
            <h2>Похожие статьи</h2>
            {foreach $similarPosts as $similar}
                <article>
                    {if $similar->image}
                        <img src="{$similar->image|escape}" alt="{$similar->title|escape}">
                    {/if}
                    <h3><a href="/post/{$similar->id}">{$similar->title|escape}</a></h3>
                    <p>{$similar->description|escape}</p>
                </article>
            {/foreach}
        </section>
    {/if}
{/block}
