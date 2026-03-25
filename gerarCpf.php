<?php

function gerarCpf() {
    $n = array_map(fn() => rand(0,9), range(1,9));
    $soma = 0;
    for($i=0; $i<9; $i++) $soma += $n[$i] * (10-$i);
    $r = $soma % 11;
    $n[] = $r < 2 ? 0 : 11 - $r;
    $soma = 0;
    for($i=0; $i<10; $i++) $soma += $n[$i] * (11-$i);
    $r = $soma % 11;
    $n[] = $r < 2 ? 0 : 11 - $r;
    return implode('', array_slice($n,0,3)) . '.' .
           implode('', array_slice($n,3,3)) . '.' .
           implode('', array_slice($n,6,3)) . '-' .
           implode('', array_slice($n,9,2));
}

echo gerarCpf() . PHP_EOL;
echo gerarCpf() . PHP_EOL;