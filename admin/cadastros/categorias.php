<?php

    $nome = NULL;

    if (!empty($id)) {
        // Consulta no banco de dados
        $sql = "select * from categoria where id = :id";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':id', $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        $id = $dados->id ?? NULL;
        $nome = $dados->nome ?? NULL;
    }
?>

<div class="card">
    <div class="card-header">
        <h2 class="float-left">Cadastros de Categorias</h2>

        <div class="float-right">
            <a href="listar/categorias" class="btn btn-success">
                Listar Categorias
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="POST" action="salvar/categorias">

            <label for="id">ID da Categoria</label>
            <input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
        
            <label for="nome">Nome da Categoria</label>
            <input type="text" name="nome" 
                id="nome" class="form-control" required value="<?=$nome?>">
            <br>
            <button type="submit" class="btn btn-success">
                Salvar Dados
            </button>
        </form>
    </div>
</div>