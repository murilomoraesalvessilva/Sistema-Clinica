<?php

namespace App\Domain\Paciente;
class Paciente {

    public function __construct(
        private string $nome, 
        private string $cpf, 
        private array $telefones, 
        private string $dataNascimento
        ) {
            $this->cpf = $this->validarCpf($cpf);
            $this->telefones = $this->validarTelefone($telefones);
        }

    private function validarTelefone(array $telefones): array {
        if (count($telefones) > 2) {
            throw new \InvalidArgumentException("São permitidos até 2 telefones");
        }

        return $telefones;
    }

    private function validarCpf(string $cpf): string {

        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) !== 11) {
            throw new \InvalidArgumentException("CPF inválido: deve ter 11 dígitos.");
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            throw new \InvalidArgumentException("CPF inválido: dígitos repetidos.");
        }

        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += intval($cpf[$i]) * (10 - $i);
        }
        $primeiro = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);

        if (intval($cpf[9]) !== $primeiro) {
            throw new \InvalidArgumentException("CPF inválido: dígito verificador incorreto.");
        }

        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += intval($cpf[$i]) * (11 - $i);
        }
        $segundo = ($soma % 11) < 2 ? 0 : 11 - ($soma % 11);

        if (intval($cpf[10]) !== $segundo) {
            throw new \InvalidArgumentException("CPF inválido: dígito verificador incorreto.");
        }

        return $cpf;
    }

    private function mascararTelefome(string $telefone): string {
        $visiveis = substr($telefone, -4);
        $ocultos = str_repeat("*", strlen($telefone) - 4);

        return $ocultos . $visiveis;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function getTelefone(): string {
        $resultado = "";

        foreach ($this->telefones as $tel) {
            $resultado .= $this->mascararTelefome($tel) . PHP_EOL;
        }
        return $resultado;
    }

    public function getTelefonesRaw(): array {
        return $this->telefones;
    }

    public function getDataNascimento(): string {
        return $this->dataNascimento;
    }

    public function __toString(): string {
        return "NOME: $this->nome" . PHP_EOL . "CPF: $this->cpf" . PHP_EOL . "TELEFONES:" . PHP_EOL . $this->getTelefone() . "DATA DE NASCIMENTO: $this->dataNascimento";
    }
}

?>
