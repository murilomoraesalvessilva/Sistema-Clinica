<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\Database\SQLiteMedicoRepository;
use App\Infrastructure\Database\SQLitePacienteRepository;
use App\Infrastructure\Database\SQLiteConsultaRepository;
use App\Application\CadastrarMedico;
use App\Application\CadastrarPaciente;
use App\Application\AgendarConsulta;

$pdo = new PDO('sqlite:' . __DIR__ . '/database/banco.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$medicoRepository   = new SQLiteMedicoRepository($pdo);
$pacienteRepository = new SQLitePacienteRepository($pdo);
$consultaRepository = new SQLiteConsultaRepository($pdo);

$cadastrarMedico   = new CadastrarMedico($medicoRepository);
$cadastrarPaciente = new CadastrarPaciente($pacienteRepository);
$agendarConsulta   = new AgendarConsulta(
    $consultaRepository,
    $medicoRepository,
    $pacienteRepository
);

$cadastrarMedico->executar("Dr. João", "12345", "Cardiologia");
$cadastrarMedico->executar("Dra. Maria", "67890", "Neurologia");

$cadastrarPaciente->executar(
    "Carlos Silva",
    "111.111.111-11",
    ["11999991234", "11988887654"],
    "01/01/1990"
);

$cadastrarPaciente->executar(
    "Ana Souza",
    "222.222.222-22",
    ["11977776543"],
    "15/05/1995"
);

$agendarConsulta->executar(1, 1, "25/03/2026", "09:00");
$agendarConsulta->executar(2, 2, "26/03/2026", "14:00");

echo "════════════════════════════════" . PHP_EOL;
echo "          MÉDICOS               " . PHP_EOL;
echo "════════════════════════════════" . PHP_EOL;

foreach ($medicoRepository->listarTodos() as $medico) {
    echo $medico . PHP_EOL;
    echo "────────────────────────────────" . PHP_EOL;
}

echo "════════════════════════════════" . PHP_EOL;
echo "          PACIENTES             " . PHP_EOL;
echo "════════════════════════════════" . PHP_EOL;

foreach ($pacienteRepository->listarTodos() as $paciente) {
    echo $paciente . PHP_EOL;
    echo "────────────────────────────────" . PHP_EOL;
}

echo "════════════════════════════════" . PHP_EOL;
echo "          CONSULTAS             " . PHP_EOL;
echo "════════════════════════════════" . PHP_EOL;

foreach ($consultaRepository->listarTodos() as $consulta) {
    echo $consulta . PHP_EOL;
    echo "────────────────────────────────" . PHP_EOL;
}