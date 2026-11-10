<?php
$lista = require __DIR__ . "/config.php";
foreach ($lista as $servidor) {
    $url = "http://{$servidor['host']}:{$servidor['port']}/health.php";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode === 200 && $response === 'OK') {
        echo "Servidor {$servidor['host']}:{$servidor['port']} está saudável.<br>";
    } else {
        echo "Servidor {$servidor['host']}:{$servidor['port']} não está saudável.<br>";
    }
}
// php -S localhost:8000 -t balanceador