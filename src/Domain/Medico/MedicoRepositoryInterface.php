<?php

namespace Src\Domain\Medico;

interface MedicoRepositoryInterface {
    public function salvar(Medico $medico): void;
    public function buscarPorId(int $id): ?Medico;
    public function listarTodos(): array;
    public function deletar(int $id): void;
}