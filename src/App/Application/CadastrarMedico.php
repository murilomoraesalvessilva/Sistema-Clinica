<?php

namespace App\Application;

use App\Domain\Medico\Medico;
use App\Domain\Medico\MedicoRepositoryInterface;

class CadastrarMedico {

    public function __construct(
        private MedicoRepositoryInterface $medicoRepository
    ) {}

    public function executar(
        string $nome,
        string $crm,
        string $especialidade
    ): void {
        $medico = new Medico($nome, $crm, $especialidade);
        $this->medicoRepository->salvar($medico);
        echo "Médico $nome cadastrado com sucesso!" . PHP_EOL;
    }
}