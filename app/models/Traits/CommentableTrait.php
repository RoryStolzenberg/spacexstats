<?php
namespace SpaceXStats\Models\Traits;

trait CommentableTrait {

    public function comments() {
        return $this->hasMany('SpaceXStats\Models\Comment');
    }

	public function getCommentTreeAttribute() {
        return $this->buildTree($this->comments()->withTrashed()->get()->toArray(), 0);
    }

    private function buildTree($array, $parent, $currentDepth = 0) {
        $branch = [];

        // http://stackoverflow.com/questions/8587341/recursive-function-to-generate-multidimensional-array-from-database-result
        foreach ($array as $model) {
            if ($model['parent'] == $parent) {
                $children = $this->buildTree($array, $model['comment_id'], $currentDepth + 1);

                if ($children) {
                    $model['children'] = $children;
                } else {
                    $model['children'] = [];
                }

                // Only include the comment if it has no children and has been deleted
                if(count($model['children']) > 0 || is_null($model['deleted_at'])) {
                    $branch[] = $model;
                }
            }
        }
        return $branch;
    }
}