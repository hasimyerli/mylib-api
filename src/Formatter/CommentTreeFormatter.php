<?php


namespace App\Formatter;


use App\Entity\Comment;

class CommentTreeFormatter
{
    /**
     * @param array $comments
     * @param int $total
     * @return array
     */
    public static function format(array $comments, int $total): array
    {
        $data = [];
        $data['total'] = $total;
        /**
         * @var Comment $comment
         */
        foreach ($comments as $key => $comment) {
            $data['comments'][$key]['id'] = $comment->getId();
            $data['comments'][$key]['text'] = $comment->getText();
        }
        return $data;
    }
}