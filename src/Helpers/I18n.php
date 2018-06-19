<?php namespace IA\Laravel\Core\Helpers;

class I18n
{
    public static function switchLocale( $locale )
    {
        $uri    = request()->segments();
        $uri[0] = $locale;

        return '/' . implode( '/', $uri );
    }
}
