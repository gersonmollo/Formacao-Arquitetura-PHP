<?php

namespace Alura\Leilao\Test\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;
use Alura\Leilao\Service\Avaliador;

class AvaliadorTest extends TestCase
{
    private object $leiloeiro;

    public function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider criarLeilao
     */
    public function testAvaliadorMaiorValor(Leilao $leilao)
    {
        // Executo o codigo a ser testado - Act - When
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Verifico se a saida é esperada - Assert - Then
        self::assertEquals(2500, $maiorValor);
    }

    /**
     * @dataProvider criarLeilao
     */
    public function testAvaliadorMenorValor(Leilao $leilao)
    {
        // Executo o codigo a ser testado - Act - When
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        // Verifico se a saida é esperada - Assert - Then
        self::assertEquals(1700, $menorValor);
    }

    /**
     * @dataProvider criarLeilao
     */
    public function testAvaliador3MaioresValores(Leilao $leilao)
    {
        // Executo o codigo a ser testado - Act - When
        $this->leiloeiro->avalia($leilao);

        $maioresLances = $this->leiloeiro->getMaioresLances();
        static::assertCount(3, $maioresLances);
        static::assertEquals(2500, $maioresLances[0]->getValor());
    }

    public function criarLeilao(): array
    {
        $leilao = new Leilao('Fiat 147 0km');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            [$leilao]
        ];
    }
}