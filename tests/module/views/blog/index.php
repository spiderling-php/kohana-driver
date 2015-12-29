<h1>Blog Index</h1>

<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <?php echo HTML::anchor(Route::url('post', ['slug' => $post['slug']]), $post['title']) ?>
        </li>
    <?php endforeach ?>
</ul>
