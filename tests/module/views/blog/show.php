<h1>Post</h1>

<h2><?php echo $post['title'] ?></h2>

<?php echo Text::auto_p($post['text']) ?>

<div>
    <h3>Comments</h3>
    <ul>
    <?php foreach ($comments as $comment): ?>
        <li>
            <img width="50" height="50" src="<?php echo $comment['logo'] ?>">
            <span><?php echo $comment['name'] ?></span>
            <p>
                <?php echo $comment['message'] ?>
            </p>
        </li>
    <?php endforeach ?>
    </ul>
</div>
<?php
    echo Form::open(
        Route::url('post', ['slug' => $post['slug']]),
        ['enctype' => 'multipart/form-data']
    )
?>
<fieldset>
    <legend>Submit Comment</legend>
    <p>
        <?php echo Form::input('name') ?>
    </p>
    <p>
        <?php echo Form::file('attachment') ?>
    </p>
    <p>
        <?php echo Form::textarea('message') ?>
    </p>
    <p>
        <?php echo Form::submit('btn', 'pressed') ?>
    </p>
</fieldset>

<?php echo Form::close() ?>
