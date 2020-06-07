<?php

namespace App\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * //alias and default parameters in the annotation are optional.
 * @ES\Index(alias="books", default=true)
 */
class BookDocument
{
    /**
     * @ES\Id()
     */
    public int $id;

    /**
     * @ES\Property(type="text", analyzer="eNgramAnalyzer")
     */
    public string $title;

    /**
     * @ES\Property(type="text", analyzer="eNgramAnalyzer")
     */
    public string $description;
}