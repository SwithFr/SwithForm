<?php


namespace Swith;


class Form
{
    public static function __callStatic($method, $arguments)
    {
        $formHelper = new FormHelper();
        return call_user_func_array([$formHelper, $method], $arguments);
    }
}