<?php

namespace App\Domain\Medico;

class Medico {
    public function __construct(
        private string $nome, 
        private string $crm, 
        private string $especialidade
        ) {}

    public function getNome(): string {
        return $this->nome;
    }

    public function getCrm(): string {
        return $this->crm;
    }

    public function getEspecialidade(): string {
        return $this->especialidade;
    }

    public function __toString(): string {
        return "CRM: $this->crm" . PHP_EOL . "MEDICO: $this->nome" . PHP_EOL . "ESPECIALIDADE: $this->especialidade";
    }
}