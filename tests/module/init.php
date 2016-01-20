<?php

Route::set('blog', 'blog')
    ->defaults([
        'controller' => 'blog',
        'action'     => 'index',
    ]);

Route::set('old', 'old-blog')
    ->defaults([
        'controller' => 'blog',
        'action'     => 'old',
    ]);

Route::set('loop', 'redirect-loop')
    ->defaults([
        'controller' => 'blog',
        'action'     => 'loop',
    ]);

Route::set('post', 'blog/<slug>')
    ->defaults([
        'controller' => 'blog',
        'action'     => 'show',
    ]);
