<?php
$lista = require __DIR__ . "/config.php";
$contador_caminho = __DIR__ . "/state/contador.txt";
require_once __DIR__ . "/HealthChecker.php";
if (file_exists($contador_caminho)) {
    $contador = (int)file_get_contents($contador_caminho);
} else {
    $contador = 0;
}

$contador++;
file_put_contents($contador_caminho, $contador);

echo "Requisição número: {$contador}<br>";

$indice = $contador % count($lista);
$servidor = $lista[$indice];

$requisicao = curl_init("http://{$servidor['host']}:{$servidor['port']}/");
curl_setopt($requisicao, CURLOPT_RETURNTRANSFER, true);
$resposta = curl_exec($requisicao);
curl_close($requisicao);
echo $resposta;

// php -S localhost:8000 -t balanceador