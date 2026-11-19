<a class="post-card" href="/post/{$post->id}">
    {if $post->image}
        <div class="post-card__media">
            <img class="post-card__image" src="{$post->image|escape}" alt="" loading="lazy">
        </div>
    {/if}
    <div class="post-card__body">
        <h3 class="post-card__title">{$post->title|escape}</h3>
        <p class="post-card__description">{$post->description|escape}</p>
        <p class="post-card__meta">
            <time datetime="{$post->publishedAt->format('Y-m-d')}">{$post->publishedAt->format('d.m.Y')}</time>
            <span>{$post->views} просмотров</span>
        </p>
    </div>
</a>
