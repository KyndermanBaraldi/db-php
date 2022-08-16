<main>
    <section>
        <a href="index.php">
            <button class="btn btn-success">Voltar</button>
        </a>
    </section>

    <h2 class="mt-3"><?= TITLE ?></h2>

    <form action="" method="post">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?=$vaga->titulo?>">
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" rows="5"><?=$vaga->descricao?></textarea>
        </div>
        <div class="form-group">
            <label>Status</label>
            <div>
                <div class="form-check form-check-inline">
                    <label class="form-control">
                        <input type="radio" name="ativo" value="s" checked>Ativo
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-control">
                        <input type="radio" name="ativo" value="n" <?=$vaga->ativo == 'n' ? 'checked' : ''?>>Inativo
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="subimit" class="btn btn-success">Enviar</button>
        </div>

    </form>
</main>