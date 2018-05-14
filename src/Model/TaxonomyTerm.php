<?php namespace IA\LaravelCore\Model;

use Devfactory\Taxonomy\Models\Term;
use Phoenix\EloquentMeta\MetaTrait;

use IA\LaravelCore\Model\Interfaces\MetadataAwareInterface;

class TaxonomyTerm extends Term implements MetadataAwareInterface
{
    use MetaTrait;

    const VOCABULARY_ID = null;

    protected $table    = 'terms';

    public function __construct()
    {
        if ( static::VOCABULARY_ID === null )
        {
            throw new \Exception( 'const VOCABULARY_ID should be overrided with a valid vocabular id in the derived class' );
        }

        $this->vocabulary_id    = static::VOCABULARY_ID;
        $this->parent           = 0;
        $this->weight           = 1;
    }

    public static function get()
    {
        return self::where( 'vocabulary_id', static::VOCABULARY_ID );
    }
}
