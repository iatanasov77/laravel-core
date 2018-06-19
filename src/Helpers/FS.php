<?php namespace IA\Laravel\Core\Helpers;

use Illuminate\Support\Facades\Config;

class FS
{
    public static function getFile( $file )
    {
        return sprintf( "%s/%s.ext",
            Config::get( 'ia.upload_provider' ),
            $file
        );
    }
}
