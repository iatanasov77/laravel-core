<?php namespace OrmBg\Core\CRUD;

use Encore\Admin\Grid\Displayers\Actions as EncoreActions;
use Illuminate\Http\Request;
use OrmBg\Core\CRUD\Grid\Grid;

class ExtendedResourceController extends ResourceController
{
    const GRID_TITLE    = 'ORM Grid';
	const PAGE_SIZE     = 20;

    public function index( Request $request )
    {
        $this->getItems($request);
        $content    = $this ->grid( $request )->with([
            'title'     => __(static::GRID_TITLE)
        ])->render();

        return parent::index( $request )->with([
            'content'   => $content
        ]);
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    protected function grid( Request $request )
    {
        $paginator  = $this->getItems( $request )->paginate( static::PAGE_SIZE );

        $grid   = new Grid( $paginator, $this->getItems( $request )->getModel(), function ( Grid $grid )
        {
            $grid->setView( 'admin.grid.table' );

            $this->buildGrid( $grid );
        });

        return $grid;
    }

    protected function buildGrid( Grid  &$grid )
    {
        $grid->id( __('Номер') )->sortable();

        $grid->actions( function ( EncoreActions $actions )
        {
            $actions->column->setAttributes( ['class' => 'gridActions'] );

            $actions->append( sprintf( '<a href="%s/%d/edit" data-uk-tooltip title="%s"><i class="material-icons md-24">&#xE254;</i></a>',
                $this->grid->resource(),
                $actions->getKey(),
                __('Редактиране')
            ));

            $actions->append( sprintf( '<a class="btnDelete uk-margin-left" href="%s/%d" data-uk-tooltip title="%s"><i class="material-icons md-24">&#xE872;</i></a>',
                $this->grid->resource(),
                $actions->getKey(),
                __('Изтриване')
            ));
        });


        $grid   ->disableExport()
                ->disableFilter()
                ->disableRowSelector();
    }
}
