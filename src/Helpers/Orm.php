<?php namespace IA\LaravelCore\Helpers;

class Orm
{
    public static function switchLocale( $locale )
    {
        $uri    = request()->segments();
        $uri[0] = $locale;

        return '/' . implode( '/', $uri );
    }
}
