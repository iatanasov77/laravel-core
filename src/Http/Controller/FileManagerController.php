<?php namespace IA\Laravel\Core\Http\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class FileManagerController extends Controller
{
    public function getFile( $file )
    {
        $file   = pathinfo( $file, PATHINFO_FILENAME ); // Strip the extension
        
        if ( ! Cache::has( $file ) )
        {
            Cache::forever( $file, $this->getFilePath( $file ) );
        }
        
        $path       = Config::get( 'ia.upload_path' ) . DIRECTORY_SEPARATOR . Cache::get( $file );
        $headers    = [
            'Content-Type'  => mime_content_type( $path )
        ];
        
        return response()->file( $path, $headers );
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    protected function getFilePath( $file )
    {
        $parts  = explode( '-', $file );
        $class  = Config::get( 'ia.entity_map.' . $parts[0], $parts[0] );
    
        $entity = class_exists( $class ) 
                    ? $class::find( ( int ) $parts[2] ) 
                    : DB::table( $class )->find( ( int ) $parts[2] );
       
        if ( $entity instanceof \Dimsav\Translatable\Translatable )
        {
            $entity = $entity->translate( App::getLocale(), true );
        }
        
        if ( ! $entity )
        {
            abort( 404 );
        }
        
        return $entity->{$parts[1]};
    }
}
