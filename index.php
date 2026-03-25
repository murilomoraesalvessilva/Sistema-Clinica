<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\Database\SQLiteMedicoRepository;
use App\Infrastructure\Database\SQLitePacienteRepository;
use App\Infrastructure\Database\SQLiteConsultaRepository;
use App\Application\CadastrarMedico;
use App\Application\CadastrarPaciente;
use App\Application\AgendarConsulta;

// ─── Conexão ───────────────────────────────────────────
$pdo = new PDO('sqlite:' . __DIR__ . '/database/banco.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ─── Repositórios ──────────────────────────────────────
$medicoRepository   = new SQLiteMedicoRepository($pdo);
$pacienteRepository = new SQLitePacienteRepository($pdo);
$consultaRepository = new SQLiteConsultaRepository($pdo);

// ─── Casos de uso ──────────────────────────────────────
$cadastrarMedico   = new CadastrarMedico($medicoRepository);
$cadastrarPaciente = new CadastrarPaciente($pacienteRepository);
$agendarConsulta   = new AgendarConsulta(
    $consultaRepository,
    $medicoRepository,
    $pacienteRepository
);

// ─── Teste com CPF inválido ────────────────────────────
try {
    $cadastrarPaciente->executar(
        "Paciente Inválido",
        "111.111.111-11",
        ["11999991234"],
        "01/01/2000"
    );
} catch (\InvalidArgumentException $e) {
    echo "ERRO: " . $e->getMessage() . PHP_EOL;
}