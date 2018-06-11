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
        
        if ( Cache::has( $file ) )
        {
            $filePath   = Cache::get( $file );
        }
        else
        {
            $filePath = $this->getFilePath( $file );
            
            Cache::forever( $file, $filePath );
        }

        $path       = Config::get( 'ia.upload_path' ) . $filePath;
        $headers    = [
            'Content-Type'  => mime_content_type( $path )
        ];

        return response()->file( $path, $headers );
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    protected function getFilePath( $file )
    {
        $parts  = explode( '-', $file );
        if ( class_exists( $parts[0] ) )
        {
            $class  = $parts[0];
            $entity = $class::find( ( int ) $parts[2] );
        }
        else
        {
            $entity = DB::table( $parts[0] )->find( ( int ) $parts[2] );
        }
            
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
