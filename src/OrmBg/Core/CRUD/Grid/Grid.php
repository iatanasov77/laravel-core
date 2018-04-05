<?php namespace OrmBg\Core\CRUD\Grid;

use Closure;
use Encore\Admin\Grid as EncoreGrid;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Grid extends EncoreGrid
{
    protected $elPaginator;

    public function __construct( $paginator, Eloquent $model, Closure $builder)
    {
        $this->elPaginator    = $paginator;

        parent::__construct( $model, $builder );
    }

    public function renderCreateButton()
    {
        return sprintf( '<a href="%s/create" class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light">%s</a>',
            $this->resource(),
            __('Добави')
        );
    }

    public function paginator()
    {
        return new Tools\Paginator( $this, $this->elPaginator );
    }

    public function renderFilter()
    {
        if ( ! $this->option( 'useFilter' ) )
        {
            return '';
        }

        return view( 'admin.grid.filter', [
            'grid'  => $this
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    protected function addColumn( $column = '', $label = '' )
    {
        $column = new Column( $column, $label );
        $column->setGrid( $this );

        return $this->columns[] = $column;
    }

    protected function setupFilter()
    {
        $this->filter   = new Filter( $this->model );
        $this->filter->setPaginator( $this->elPaginator );

    }
}
