<?php //namespace IA\Laravel\Core\Http\Controller;
namespace App\Http\Controllers;

use Spatie\DbDumper\Databases\MySql as DbDumper;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class SiteSyncController extends Controller
{
    public function dumpDatabase()
    {
        $dbName     = Config::get( 'database.connections.' . Config::get( 'database.default' ) . '.database');
        $dbUser     = Config::get( 'database.connections.' . Config::get( 'database.default' ) . '.username');
        $dbPass     = Config::get( 'database.connections.' . Config::get( 'database.default' ) . '.password');
        
        $dumpFile   = 'sql/' . $dbName . '.sql';
        
        DbDumper::create()  ->setDbName( $dbName )
                            ->setUserName( $userName )
                            ->setPassword( $password )
                            ->dumpToFile( Storage::path( $dumpFile ) );
       
       return Storage::download( $dumpFile );
    }
    
    public function getData()
    {
        
        
        $path       = Config::get( 'app.upload_path' ) . DIRECTORY_SEPARATOR . $entity->{$parts[1]};
        
        return $this->getFileResponse( $path );
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    protected function getFileResponse( $path )
    {
        $headers    = [
            'Content-Type'  => mime_content_type( $path )
        ];
        
        return response()->file( $path, $headers );
    }
}
