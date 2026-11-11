<?php
function checkHealth($servidor) {
    $url = "http://{$servidor['host']}:{$servidor['port']}/health.php";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2); // Tempo limite de 2 segundos para a requisição
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return $httpCode === 200 && $response === "OK";

}
// php -S localhost:8000 -t balanceador