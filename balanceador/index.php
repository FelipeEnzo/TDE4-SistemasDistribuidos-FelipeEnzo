<?php
require_once __DIR__ . "/HealthChecker.php";
$config = require __DIR__ . "/config.php";
$lista = $config['servidores'];
$contador_caminho = __DIR__ . "/state/contador.txt";

if (file_exists($contador_caminho)) {
    $contador = (int)file_get_contents($contador_caminho);
} else {
    $contador = 0;
}

$contador++;
file_put_contents($contador_caminho, $contador);
$total = count($lista);

// Round Robin
if ($config['algoritmo'] === 'round-robin') {
    $indice = ($contador - 1) % $total;
} else {
    $indice = random_int(0, $total - 1);  
}

// Percorre a lista
$escolhido = null;
for ($tentativas = 0; $tentativas < $total; $tentativas++) {
    $servidor = $lista[$indice];
    if (checkHealth($servidor)) {
        $escolhido = $servidor;
        break;
    }
    // Próximo servidor
    $indice = ($indice + 1) % $total;
}
// Devolve erro
if ($escolhido === null) {
    http_response_code(503);
    echo "Todos os servidores estão indisponíveis.";
    exit;
}

// Requesição 
echo "Requisição número: {$contador}<br>";

$requisicao = curl_init("http://{$escolhido['host']}:{$escolhido['port']}/");
curl_setopt($requisicao, CURLOPT_RETURNTRANSFER, true);
$resposta = curl_exec($requisicao);
curl_close($requisicao);

echo $resposta;

// php -S localhost:8000 -t balanceador