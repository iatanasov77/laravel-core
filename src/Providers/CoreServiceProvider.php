<?php namespace IA\Laravel\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;

use IA\Laravel\Core\Helpers\FS;

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
        // Asset
        Blade::directive( 'asset', function ( $expression )
        {
            list( $path, $theme ) = explode( ', ', $expression );
            
            return sprintf( "%s/%s/%s/%s",
                Config::get( 'app.url' ),
                Config::get( 'ia.assets_root', 'assets' ),
                trim( $theme ),
                trim( $path )
            );
        });
        
        // File
        Blade::directive( 'file', function ( $file )
        {
            return FS::getFile( $file );
        });
        
        // IfContinue
        Blade::directive( 'ifcontinue', function ( $expression )
        {
            return "<?php if( {$expression} ) continue; ?>";
        });
        
        // IfBreak
        Blade::directive( 'ifbreak', function ( $expression )
        {
            return "<?php if( {$expression} ) break; ?>";
        });
    }
}
