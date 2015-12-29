<?php

class Controller_Blog extends Controller_Template
{
    public $posts = [
        'first-post' => [
            'slug' => 'first-post',
            'title' => 'First Post',
            'text' => 'Some text',
        ],
        'next-post' => [
            'slug' => 'next-post',
            'title' => 'Next Post',
            'text' => "Some other thing\nGreat stuff\n\nCraftsmenship!",
        ],
    ];

    public function action_index()
    {
        $this->template->content = View::factory('blog/index', ['posts' => $this->posts]);
    }

    public function action_show()
    {
        $post = $this->posts[$this->request->param('slug')];

        $comments = [];

        if (Request::POST === $this->request->method()) {
            $data = Arr::merge($this->request->post(), $_FILES);

            $data = Validation::factory($data)
                ->rule('name', 'not_empty')
                ->rule('message', 'not_empty')
                ->rule('attachment', 'Upload::valid');

            if ($data->check()) {
                $comments []= [
                    'name' => $data['name'],
                    'message' => $data['message'],
                    'logo' => $data['attachment']['tmp_name']
                ];
            }
        }

        $this->template->content = View::factory('blog/show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function action_old()
    {
        $this->redirect(Route::url('blog'));
    }

    public function action_loop()
    {
        $this->redirect(Route::url('loop'));
    }
}
