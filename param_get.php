<?php
// null coalesce replacement function
function param_get(&$value, $default = null)
{
    return isset($value) ? $value : $default;
}
