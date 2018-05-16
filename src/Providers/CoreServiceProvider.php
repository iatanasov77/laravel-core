<?php namespace IA\Laravel\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBladeDirectives();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Register config.
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        Blade::directive( 'ifcontinue', function ( $expression )
        {
            return "<?php if( {$expression} ) continue; ?>";
        });
        
        Blade::directive( 'ifbreak', function ( $expression )
        {
            return "<?php if( {$expression} ) break; ?>";
        });
    }
}
