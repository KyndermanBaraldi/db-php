<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Common\Environment;
use App\Common\Pagination;
use App\Models\Vaga;

Environment::load(__DIR__);

$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

$status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
$status = in_array($status, ['s','n']) ? $status : null;

$cond = [
    strlen($busca) ? 'titulo LIKE "%'. str_replace(' ', '%', $busca) .'%"' : null,
    strlen($status) ? 'ativo = "' . $status . '"' : null
];

$cond = array_filter($cond);

$where = implode(' AND ', $cond);

$total = Vaga::countVagas($where);

$paginacao = new Pagination($total, $_GET["pagina"] ?? 1, 3);

$vagas = Vaga::getVagas($where,null,$paginacao->getLimit());



include __DIR__.'/app/Views/header.php';
include __DIR__.'/app/Views/listagem.php';
include __DIR__.'/app/Views/footer.php';