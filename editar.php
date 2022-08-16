<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Common\Environment;
use App\Models\Vaga;

Environment::load(__DIR__);

define('TITLE', 'Editar Vaga');

if (!isset($_GET["id"]) or !is_numeric($_GET["id"]))
{
    header('location: index.php?status=error');
    exit;
}

$vaga = Vaga::getVaga($_GET["id"]);

if (!$vaga instanceof Vaga)
{
    header('location: index.php?status=error');
    exit;
}


if (isset($_POST["titulo"],$_POST["descricao"],$_POST["ativo"])){
    $vaga->update($_POST["titulo"],$_POST["descricao"],$_POST["ativo"]);
    header('location: index.php?status=success');
    exit;
}

include __DIR__.'/app/Views/header.php';

include __DIR__.'/app/Views/formulario.php';

include __DIR__.'/app/Views/footer.php';