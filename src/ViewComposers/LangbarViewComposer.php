<?php namespace IA\Laravel\Core\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;

class LangbarViewComposer
{
    public function compose( View $view )
    {
        $view->with( 'locales', Config::get( 'app.locales' ) );
    }
}
