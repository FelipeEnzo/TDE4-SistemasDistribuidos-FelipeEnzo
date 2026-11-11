<?php
return [
    'algoritmo' => 'round-robin',
    'servidores' => [
    ['host' => 'localhost', 'port' => 8001],
    ['host' => 'localhost', 'port' => 8002],
    ['host' => 'localhost', 'port' => 8003],
    ],
];
// random 
//    for i in 1 2 3 4 5 6; do curl -s http://localhost:8000; echo; done