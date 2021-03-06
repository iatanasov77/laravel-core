<?php namespace IA\Laravel\Core\CRUD\Grid;

use Encore\Admin\Grid\Filter as EncoreGridFilter;

class Filter extends EncoreGridFilter
{
    protected $elPaginator;

    public function execute()
    {
        return $this->elPaginator->getCollection()->toArray();
    }

    public function setPaginator( $paginator )
    {
        $this->elPaginator  = $paginator;
    }
}
