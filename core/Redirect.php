<?php

namespace Core;

Class Redirect
{
    public static function route($url)
    {
        return header("Location: $url");
    }
}