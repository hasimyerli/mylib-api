<?php


namespace App\Formatter;


use App\Entity\Comment;

class CommentTreeFormatter
{
    /**
     * @param array $parentComments
     * @param array $childComments
     * @return array
     */
    public static function format(array $parentComments, array $childComments): array
    {
        $comments = [];
        $parentCount = 0;

        /**
         * @var Comment $parentComment
         */
        foreach ($parentComments as $parentComment) {
            $comments[$parentCount]['id'] = $parentComment->getId();
            $comments[$parentCount]['text'] = $parentComment->getText();
            $comments[$parentCount]['childs'] = [];

            $childCount = 0;

            /**
             * @var Comment $childComment
             */
            foreach ($childComments as $childKey =>  $childComment) {
                if ($childComment->getParent() === $parentComment) {
                    $comments[$parentCount]['childs'][$childCount]['id'] = $childComment->getId();
                    $comments[$parentCount]['childs'][$childCount]['text'] = $childComment->getText();
                    $childCount++;
                    unset($childComments[$childKey]);
                }
            }
            $parentCount++;
        }
        return $comments;
    }
}