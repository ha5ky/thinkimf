<?php
/**
 * Created by PhpStorm.
 * User: chenjianhua
 * Date: 2018/4/22
 * Time: 00:13
 */
$propertyMean = [
    [
        'word_id'=>567,
        'adv.'=>'great leader Mao',
        'n'=>'mao`s hobby'
    ],
    [
        'word_id'=>567,
        'adv.'=>'great leader Mao',
        'n'=>'mao`s hobby'
    ]
];
echo PHP_EOL;
echo json_encode($propertyMean,JSON_UNESCAPED_UNICODE).PHP_EOL;
echo PHP_EOL;
$exampleMean = [
    [
        'word_id'=>123,
        'example_1'=>'我(wǒ)爱（ ài）你（ nǐ）',
        'voice_id'=>255,
        'english_mean'
    ],
    [
        'word_id'=>123,
        'example_1'=>'我(wǒ)爱（ ài）你（ nǐ）',
        'voice_id'=>237,
        'english_mean'
    ],
    [
        'word_id'=>123,
        'example_1'=>'我(wǒ)爱（ ài）你（ nǐ）',
        'voice_id'=>237,
        'english_mean'
    ],
];
echo json_encode($exampleMean,JSON_UNESCAPED_UNICODE).PHP_EOL;
