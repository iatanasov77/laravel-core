<?php namespace IA\LaravelCore\CRUD\Grid\Tools;

use Encore\Admin\Grid\Tools\Paginator as EncorePaginator;
use IA\LaravelCore\CRUD\Grid\Grid;

class Paginator extends EncorePaginator
{

    public function __construct( Grid $grid, $paginator )
    {
        $this->paginator    = $paginator;
        $this->grid         = $grid;
    }

    /**
     * Render Paginator.
     *
     * @return string
     */
    public function render()
    {
        $html   = '';

        if ( $this->grid->usePagination() )
        {
            //$html   .= $this->paginationRanger();
            $html   .= $this->paginationLinks();
            //$html   .= $this->perPageSelector();
        }

        return $html;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get Pagination links.
     *
     * @return string
     */
    protected function paginationLinks()
    {
        return $this->paginator->render( 'admin.pagination' );
    }
}
