<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 27.05.2016
 * Time: 15:05
 */

function s_prn($content)
{
    echo '<pre style="background: lightgray; border: 1px solid black; padding: 2px">';
    print_r($content);
    echo '</pre>';
}