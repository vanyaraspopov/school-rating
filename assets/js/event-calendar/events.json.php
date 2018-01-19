<?php
$events = [
    [
        'date' => '2018-01-21 10:15:20',
        'title' => 'Событие 1',
        'description' => 'Lorem Ipsum dolor set',
        'url' => 'http://lubactive.ru/meropriyatiya/'
    ],
    [
        'date' => '2018-01-01 10:15:20',
        'title' => 'Событие 2',
        'description' => 'Lorem Ipsum dolor set',
        'url' => 'http://lubactive.ru/meropriyatiya/'
    ],
];
echo json_encode($events);