<?php
namespace SpaceXStats\Models\Traits;

trait CommentableTrait {
	public function getCommentTreeAttribute() {
        return $this->buildTree($this->comments()->withTrashed()->with('user')->get()->toArray(), 0);
    }

    private function buildTree($array, $parent, $currentDepth = 0) {
        $branch = [];

        // http://stackoverflow.com/questions/8587341/recursive-function-to-generate-multidimensional-array-from-database-result
        foreach ($array as $model) {
            $model['depth'] = $currentDepth;
            if ($model['parent'] == $parent) {
                $children = $this->buildTree($array, $model['comment_id'], $currentDepth + 1);

                if ($children) {
                    $model['children'] = $children;
                }

                $branch[] = $model;
            }
        }
        return $branch;
    }
}