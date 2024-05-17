<?php

    if($_POST) {
        $id = $_POST["id"] ?? NULL;
        $nome = $_POST["nome"] ?? NULL;

        if (empty($nome)) {
            mensagemErro("Preencha o nome da categoria");
        }

        $sql = "select id from categoria
            where nome = :nome and id <> :id
        ";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":nome", $nome);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if (!empty($dados->id)) {
            mensagemErro("Já existe uma categoria cadastrada com este campo");
        }

        if (empty($id)) {
            $sql = "insert into categoria (nome) values (:nome)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
        }else {
            $sql = "update categoria set nome = :nome where id = :id";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":id", $id);
        }

        if (!$consulta->execute()) {
            mensagemErro("Não foi possível salvar os dados");
        }

        echo "<script>location.href='listar/categorias'</script>";
        exit;
    }
//fazer a conexao do pdo, 
//criar o sql de insert para cadastrar na tabela de categoria