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

$medicos = [
    ["Dr. Carlos Andrade",  "11111", "Cardiologia"],
    ["Dra. Fernanda Lima",  "22222", "Neurologia"],
    ["Dr. Roberto Souza",   "33333", "Ortopedia"],
    ["Dra. Patrícia Costa", "44444", "Pediatria"],
    ["Dr. Marcos Oliveira", "55555", "Dermatologia"],
];

echo "════════════════════════════════" . PHP_EOL;
echo "       CADASTRANDO MÉDICOS      " . PHP_EOL;
echo "════════════════════════════════" . PHP_EOL;

foreach ($medicos as $medico) {
    $cadastrarMedico->executar($medico[0], $medico[1], $medico[2]);
}


$pacientes = [
    ["Ana Paula Silva",   "529.982.247-25", ["11991110001"], "12/03/1990"],
    ["Bruno Henrique",    "987.654.321-00", ["11922223333", "11944445555"], "25/07/1985"],
    ["Carla Mendonça",    "111.444.777-35", ["11955556666"], "08/11/1992"],
    ["Diego Ferreira",  "974.017.348-93", ["11966667777", "11988889999"], "30/01/1988"],
    ["Elisa Rodrigues", "909.495.831-70", ["11977778888"], "17/06/1995"],
];

echo "════════════════════════════════" . PHP_EOL;
echo "      CADASTRANDO PACIENTES     " . PHP_EOL;
echo "════════════════════════════════" . PHP_EOL;

foreach ($pacientes as $paciente) {
    try {
        $cadastrarPaciente->executar(
            $paciente[0],
            $paciente[1],
            $paciente[2],
            $paciente[3]
        );
    } catch (\InvalidArgumentException $e) {
        echo "ERRO ao cadastrar {$paciente[0]}: " . $e->getMessage() . PHP_EOL;
    }
}

$consultas = [
    [1, 1, "25/03/2026", "08:00"],
    [2, 2, "25/03/2026", "09:00"],
    [3, 3, "26/03/2026", "10:00"],
    [4, 4, "26/03/2026", "11:00"],
    [5, 5, "27/03/2026", "14:00"],
];

echo "════════════════════════════════" . PHP_EOL;
echo "      AGENDANDO CONSULTAS       " . PHP_EOL;
echo "════════════════════════════════" . PHP_EOL;

foreach ($consultas as $consulta) {
    try {
        $agendarConsulta->executar(
            $consulta[0],
            $consulta[1],
            $consulta[2],
            $consulta[3]
        );
    } catch (\InvalidArgumentException $e) {
        echo "ERRO: " . $e->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . "Banco populado com sucesso!" . PHP_EOL;