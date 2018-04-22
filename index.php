<?php

if(!empty($_POST)){
    foreach ($_POST as $v) {
        echo '<pre>';
        echo '<b style="color:red;">'.$v.'</b><br>';
    }
}else{
    echo '您没有填写任何信息'.PHP_EOL;
}

$info = [
    'xiaomao',
    'xiaogou'
];
foreach ($info as $k=>$value) {
    # code...
    echo $k.'      '.$value.PHP_EOL;
};


