<?php 

    $mensagem = '';
    if(isset($_GET['status'])){
        switch ($_GET['status']) {
            case 'success':

                $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
                break;

            case 'error':

                $mensagem = '<div class="alert alert-danger">Ação não executada!</div>';
                break;
        }
    }

    $resultados = '';
    foreach ($vagas as $vaga) {

        
        $resultados .= '<tr>
                            <td>'. $vaga->id .'</td>
                            <td>'. $vaga->titulo .'</td>
                            <td>'. $vaga->descricao .'</td>
                            <td>'. ($vaga->ativo=='s'?'Ativo':'Inativo') . '</td>
                            <td>'. date('d/m/Y à\s H:i:s', strtotime($vaga->data)) . '</td>
                            <td>
                                <a href="editar.php?id='.$vaga->id.'">
                                    <button type="button" class="btn btn-primary">Editar</button>
                                </a>
                                <a href="excluir.php?id='.$vaga->id.'">
                                <button type="button" class="btn btn-danger">Excluir</button>
                            </a>
                            </td>
                        </tr>';
    }

    $resultados = strlen($resultados) ? $resultados : '<tr>
                                                            <td colspan="6" class="text-center">
                                                                Nenhuma vaga encontrada
                                                            </td>
                                                       </tr>';

    
    $paginas = '';
    $gets = [
        "busca"=> $busca,
        "status" => $status
    ];

    $gets = http_build_query(array_filter($gets));

    $pag = $paginacao->getPages();

    foreach ($pag as $key => $pg) {
        $c = $pg['current'] ? 'btn-primary' : 'btn-light';
        $paginas .= '<a href="?pagina='.$pg['page']. (strlen($gets)? '&'. $gets : '') .'">
                        <button type="button" class="btn '.$c.'">'.$pg['page']. '</button>
                     </a>';
    }

?>

<main>
    <?= $mensagem ?>
    
    <section>

        <a href="cadastrar.php">
            <button class="btn btn-success">Nova Vaga</button>
        </a>
    </section>

    <section>

        <form method="get">

            <div class="row my-4">

                <div class="col">
                    <label for="busca">Buscar por Título</label>
                    <input type="text" name="busca" id="busca" class="form-control" value="<?= $busca ?>">
                </div>
                
                <div class="col">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Ativa/Inativa</option>
                        <option value="s" <?= $status=='s' ? 'selected' : '' ?>>Ativa</option>
                        <option value="n" <?= $status=='n' ? 'selected' : '' ?>>Inativa</option>
                    </select>
                </div>
                <div class="col d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>
    </section>

    <section>
        <table class='table bg-light mt-3'>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>
            </thead>
                
            <tbody>
                <?= $resultados ?>
            </tbody>
        </table>
        <?= $paginas ?>
    </section>
</main>