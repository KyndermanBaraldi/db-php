<main>
    <section>
        <h2 class="mt-3">Confirmar Exclusão</h2>
        
    </section>


    <form action="" method="post">
        <div class="form-group">
            <p>Deseja realmente excluir a vaga <strong><?= $vaga->titulo ?></strong></p>
        </div>
      
        <div class="form-group"> 
            
            <a href="index.php">
                <button type="button" class="btn btn-primary">Cancelar</button>
            </a>
            <button type="subimit" class="btn btn-danger" name="excluir">Excluir</button>
        </div>

    </form>
</main>