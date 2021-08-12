<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require_once 'vendor/autoload.php';

// Padrao Arrange-act-assert ou Give When Then

// Arrumo a casa pra teste - Arrange - Given
$leilao = new Leilao('Fiat 147 0km');

$maria = new Usuario('Maria');
$joao = new Usuario('João');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

$leiloeiro = new Avaliador();

// Executo o codigo a ser testado - Act - When
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

 // Verifico se a saida é esperada - Assert - Then
$valorEsperado = 2500;

if ($maiorValor == $valorEsperado) {
    echo "Teste OK";
} else {
    echo "Teste Falhou";
}