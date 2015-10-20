<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Comment;

class CommentsTableSeeder extends Seeder {
    public function run() {
        Comment::create(array(
            'object_id' => 1,
            'user_id' => 1,
            'comment' => 'Root comment',
            'parent' => 0,
            'depth' => 0
        ));

        Comment::create(array(
            'object_id' => 1,
            'user_id' => 1,
            'comment' => 'A reply',
            'parent' => 1,
            'depth' => 1
        ));

        Comment::create(array(
            'object_id' => 1,
            'user_id' => 1,
            'comment' => 'A nested reply',
            'parent' => 2,
            'depth' => 2
        ));

        Comment::create(array(
            'object_id' => 1,
            'user_id' => 1,
            'comment' => 'Another nested reply',
            'parent' => 2,
            'depth' => 2
        ));

        Comment::create(array(
            'object_id' => 1,
            'user_id' => 1,
            'comment' => 'A second root comment',
            'parent' => 0,
            'depth' => 0
        ));

        Comment::create(array(
            'object_id' => 1,
            'user_id' => 1,
            'comment' => 'Has a reply',
            'parent' => 5,
            'depth' => 1
        ));
    }
}