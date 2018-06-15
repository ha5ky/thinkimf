<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/5/10
 * Time: 下午2:53
 */
if (isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
    $final = $GLOBALS['HTTP_RAW_POST_DATA'];
} else {
    $final = file_get_contents('php://input');
}
var_export($final);
