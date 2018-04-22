<?php
/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/9
 * Time: 13:37
 */

define('WEB_ROOT',__DIR__.'/..');
$autoLoadFilePath = WEB_ROOT.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
require_once $autoLoadFilePath;

use Swoole\Libs\TableClass;
//$table = 'b_all';
//$table_class = new TableClass();
//$table_class->table = 'b_all';
$table  = new \swoole_table(2000000);
//$b_all[] = ['key'=>'name','type'=>'string','len'=>50];
//$b_all[] = ['key'=>'last_price','type'=>'float','len'=>8];
//$b_all[] = ['key'=>'volume','type'=>'float','len'=>20];
//$b_all[] = ['key'=>'turnover','type'=>'float','len'=>20];
//$b_all[] = ['key'=>'zd','type'=>'float','len'=>6];
//$table->column('id',swoole_table::TYPE_STRING,500);
$table->column('id',swoole_table::TYPE_INT,8);
//$table->column('last_price',swoole_table::TYPE_FLOAT,8);
//$table->column('volume',swoole_table::TYPE_FLOAT,20);
//$table->column('turnover',swoole_table::TYPE_FLOAT,20);
//$table->column('zd',swoole_table::TYPE_FLOAT,6);
$table->create();
//print_r($table->memorySize);
echo PHP_EOL;

for ($i = 0;$i<=1200000;$i++){
    if ($table->set($i,['id'=>1]) == false){
        var_dump($i);
    }
}
//echo time();echo PHP_EOL;
//var_dump($table->exist('10000'));
//echo time();

//foreach ($table as $row => $v){
    print_r($table->memorySize);
//}


//var_dump(strlen(json_encode($array)));
//echo "上面是存入".PHP_EOL;
//$table->set('b_all',['name'=>'Inc','last_price'=>20,'volume'=>20.18,'turnover'=>20.98,'zd'=>'87.23']);
//$table->set('member',['name'=>json_encode($array)]);

//$table->set('2',['id'=>'2']);
//$table_class->column($table_class->{$table},$b_all);
//$table_class->{$table}->create();
//$table_class->{$table}->set($table,['name'=>'Inc','last_price'=>20,'volume'=>20.18,'turnover'=>20.98,'zd'=>'87.23']);
//var_dump($table->get('b_all'));
//foreach($table as $row)
//{
//    var_dump($row);
//}

//echo "这个是取出" . PHP_EOL;
//var_dump(json_decode(($table->get('member'))['name']));


//$table->test();