<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private array $lances;
    /** @var string */
    private string $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
            return;
        }

        $totalLancesUsuario = $this
            ->quantidadeLancesPorUsuario($lance->getUsuario());
        if ($totalLancesUsuario >= 5) {
            return;
        }
        
        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    private function ehDoUltimoUsuario(Lance $lance)
    {
        $ultimoLance = $this->lances[array_key_last($this->lances)];
        return $lance->getUsuario() === $ultimoLance->getUsuario();
    }

    private function quantidadeLancesPorUsuario(Usuario $usuario): int
    {
        $totalLancesUsuario = array_reduce(
            $this->lances, 
            function(int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if($lanceAtual->getUsuario() == $usuario) {
                    return $totalAcumulado + 1; 
                }

                return $totalAcumulado;
            },
            0
        );

        return $totalLancesUsuario;
    }
}
