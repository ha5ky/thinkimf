<?php
/**
 * Created by PhpStorm.
 * User: Echo
 * Date: 2018/4/4
 * Time: 13:41
 */
//$client = new swoole_redis;
//$client->on('message', function (swoole_redis $client, $result) use ($server) {
//    if ($result[0] == 'message') {
//        foreach($server->connections as $fd) {
//            $server->push($fd, $result[1]);
//        }
//    }
//});
//$client->connect('127.0.0.1', 6379);
//    $client->publish('msg_0',"新年快乐");
//$client->connect('127.0.0.1', 6379, function (swoole_redis $client, $result) {
//    $client->publish('msg_0',"新年快乐");
//});

//发布
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
//$message='新年快乐';
$message = [
	"buy_deep"=> [
	    [
		"price"=> "15",
		"amount"=> 4888
	],[
		"price"=> "16",
		"amount"=> 4948
	], [
		"price"=> "17",
		"amount"=> 15012
	], [
		"price"=> "18",
		"amount"=> 13714
	], [
		"price"=> "19",
		"amount"=>18536
	], [
		"price"=> "20",
		"amount"=> 24955
        ], [
		"price"=> "21",
		"amount"=> 2903
        ], [
		"price"=> "23",
		"amount"=> 405
        ], [
		"price"=> "24",
		"amount"=> 854
        ],
        ],
	"orders"=> [
		"deal_amount"=> 74,
		"price"=> 26,
		"argv_price"=> 26,
		"current_frozen_amount"=> 304,
		"pair_id"=> 1,
		"user_no"=> "293947485594845184",
		"order_amount"=> 378,
		"type"=> 2,
		"fee_rate"=> "0.002",
		"created_at"=> 1523181173,
		"pair"=> "A/INC",
		"updated_at"=> 1523181173,
		"fee_coin_code"=> "INC",
		"turnover"=> 1924,
		"order_no"=> "300206358278438912",
		"initial_frozen_amount"=> 378,
		"weight"=> "2600000000.1523181173",
		"fee"=> 3.848,
		"status"=> 1
	],
	"sell_deep"=> [
	    [
		"price"=> "26",
		"amount"=> 304
        ], [
		"price"=> "27",
		"amount"=> 10039
        ], [
		"price"=> "28",
		"amount"=> 15338
], [
		"price"=> "29",
		"amount"=> 12488
], [
		"price"=> "30",
		"amount"=> 8240
], [
		"price"=> "31",
		"amount"=> 11899
], [
		"price"=> "32",
		"amount"=> 5215
], [
		"price"=> "33",
		"amount"=> 1404
], [
		"price"=> "34",
		"amount"=> 1803
], [
		"price"=> "35",
		"amount"=> 749
	]],
	"order_book"=> [
		"id"=> "300206382043365376",
		"type"=>2,
		"pair_id"=> 1,
		"price"=>26,
		"volume"=> 74,
		"turnover"=> 1924,
		"created_at"=> 1523181179
	],
	"user_assets"=> [
	    [
		"available_amount"=> "99925636.08",
		"coin_id"=> "5",
		"frozen_amount"=> "76714",
		"user_no"=> "293947485594845184",
	],[
		"available_amount"=> "97716322.046",
		"coin_id"=> "1",
		"frozen_amount"=> "2200038",
		"user_no"=> "293947485594845184"
], [
		"available_amount"=> "97716322.046",
		"coin_id"=> "1",
		"frozen_amount"=> "2200038",
		"user_no"=> "293947485594845184"
], [
		"available_amount"=> "99925709.932",
		"coin_id"=> "5",
		"frozen_amount"=> "76714",
		"user_no"=> "293947485594845184"
], [
		"available_amount"=> "97716322.046",
		"coin_id"=> "1",
		"frozen_amount"=> "2198114",
		"user_no"=> "293947485594845184"
]],
	"pair"=> [
		"low"=> "15",
		"last_price"=> "32.23",
		"volume"=> "333026",
		"high"=> "33",
		"turnover"=> "7984420",
		"pair_id"=> "1",
        'tage'   => 'star,sport,all',
        'first_price'  =>'2.624'
		
	]
    ]
;
$ret=$redis->publish('msg_0',json_encode($message));
//var_dump(json_encode($message,true));
