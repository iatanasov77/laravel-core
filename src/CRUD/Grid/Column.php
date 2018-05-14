<?php namespace IA\LaravelCore\CRUD\Grid;

use Encore\Admin\Grid\Column as EncoreGridColumn;
use Illuminate\Support\Facades\URL;

class Column extends  EncoreGridColumn
{
    public function sorter()
    {
        if (!$this->sortable) {
            return;
        }

        $icon = 'fa-sort';
        $type = 'desc';

        if ($this->isSorted()) {
            $type = $this->sort['type'] == 'desc' ? 'asc' : 'desc';
            $icon .= "-amount-{$this->sort['type']}";
        }

        $query = app('request')->all();
        $query = array_merge($query, [$this->grid->model()->getSortName() => ['column' => $this->name, 'type' => $type]]);

        $url = URL::current().'?'.http_build_query($query);

        return "<a class=\"fa fa-fw $icon\" href=\"$url\">"
            . ( $type == 'desc' ? "&uarr;" : "&darr;" )
            . "</a>";
    }
}
