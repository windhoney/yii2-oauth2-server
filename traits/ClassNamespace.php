<?php

namespace wind\oauth2\traits;

trait ClassNamespace
{
    public static function className()
    {
        return get_called_class();
    }
}