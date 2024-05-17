<?php
    $login = $_POST['login'] ?? NULL;
    $senha = $_POST['senha'] ?? NULL;

    $loginDiferenteDeVazio = !empty($login);
    $senhaDiferenteDeVazio = !empty($senha);

    //verificar se tem informações POST
    if ($loginDiferenteDeVazio && $senhaDiferenteDeVazio) {
        $sql = "
            select id, nome, login, senha
                from usuario
                where
                login = :login AND ativo = 'S'
        ";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":login", $login);
        $consulta->execute();

        //PDO::FETCH_ASSOC
        $dadosDoBanco = $consulta->fetch(PDO::FETCH_OBJ);
        
        $idNaoExiste = !isset($dadosDoBanco->id);
        $dadosInvalidos = $idNaoExiste || !password_verify($senha, $dadosDoBanco->senha);    //(senha do usuario, senha armazenada no banco)
        //utiliza o password_hash para criptografar a senha e o password_verify para verificar se bate a senha com o do banco

        if($dadosInvalidos){
            mensagemErro("Credenciais Inválidas"); //Recomendado não especificar qual dado esta incorreto por segurança
        }

        $_SESSION["usuario"] = [
            "id" => $dadosDoBanco->id,
            "nome" => $dadosDoBanco->nome,
            "login" => $dadosDoBanco->login
        ];

        echo "<script>location.href='paginas/home'</script>";
        exit;
    }
    //Caso tenha, criar a consulta no banco de dados
    //Verificar se o id que vem do banco está preenchido
    //Verificar se a senha digitada é a mesma que está no banco de dados
    //Grava o usuário na sessão
    //Redireciona o usuário para uma página HOME
?>

<div class="login">
    <h1 class="text-align">Efetuar Login</h1>

    <form method="POST">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login"
            class="form-control" required
            placeholder="Favor preencher este campo">

        <br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha"
            class="form-control" required
            placeholder="Por favor preencha este campo">
        <br>

        <button type="submit" class="btn btn-success w-100">Efetuar Login</button>
    </form>
</div>