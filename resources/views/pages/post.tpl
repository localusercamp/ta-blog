{extends file="layouts/layout.tpl"}

{block name="content"}
    {if $post->image}
        <div class="post-hero">
            <img class="post-hero__image" src="{$post->image|escape}" alt="{$post->title|escape}">
        </div>
    {/if}

    <article class="post">
        {if $post->categories}
            <ul class="tag-list post-categories">
                {foreach $post->categories as $category}
                    <li><a class="tag" href="/category/{$category->id}">{$category->title|escape}</a></li>
                {/foreach}
            </ul>
        {/if}

        <h1 class="post__title">{$post->title|escape}</h1>
        <p class="post__lead">{$post->description|escape}</p>
        <p class="post__meta">
            <time datetime="{$post->publishedAt->format('Y-m-d')}">{$post->publishedAt->format('d.m.Y')}</time>
            <span>{$post->views} просмотров</span>
        </p>

        <div class="post__content">{$post->content}</div>
    </article>

    {if $similarPosts}
        <section class="similar">
            <h2 class="similar__title">Похожие статьи</h2>
            <div class="post-grid">
                {foreach $similarPosts as $post}
                    {include file="partials/post-card.tpl" post=$post}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
