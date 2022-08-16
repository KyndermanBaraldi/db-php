<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Common\Environment;
use App\Models\Vaga;

Environment::load(__DIR__);

define('TITLE', 'Cadastrar Vaga');

$vaga = new Vaga();

if (isset($_POST["titulo"],$_POST["descricao"],$_POST["ativo"])){
    $vaga->add($_POST["titulo"],$_POST["descricao"],$_POST["ativo"]);
    header('location: index.php?status=success');
    exit;
}

include __DIR__.'/app/Views/header.php';

include __DIR__.'/app/Views/formulario.php';

include __DIR__.'/app/Views/footer.php';