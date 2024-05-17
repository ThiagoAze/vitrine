<?php
    $cep = $_POST["cep"] ?? NULL;
    $json = NULL;

    if(!empty($cep)){
        if(is_numeric($cep) && strlen($cep) == 8){
            $novoCep = mask($cep, "#####-###");
            $sql = "select * from endereco where cep = :cep";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":cep", $novoCep); 
            $consulta->execute();
            $json = $consulta->fetch(PDO::FETCH_OBJ);
            
            if(empty($json)){
                $dados = file_get_contents("https://viacep.com.br/ws/$cep/json/"); // o valor que for digitado será o valor buscado
                $json = json_decode($dados);
                
                if(!isset($json->erro)){
                    $sql = "INSERT INTO endereco (cep, logradouro, complemento, bairro, localidade, uf, ibge, gia, ddd, siafi) VALUES (:cep, :logradouro, :complemento, :bairro, :localidade, :uf, :ibge, :gia, :ddd, :siafi)";
                    $consulta = $pdo->prepare($sql);
                    $consulta->bindParam(":cep", $json->cep);
                    $consulta->bindParam(":logradouro", $json->logradouro);
                    $consulta->bindParam(":complemento", $json->complemento);
                    $consulta->bindParam(":bairro", $json->bairro);
                    $consulta->bindParam(":localidade", $json->localidade);
                    $consulta->bindParam(":uf", $json->uf);
                    $consulta->bindParam(":ibge", $json->ibge);
                    $consulta->bindParam(":gia", $json->gia);
                    $consulta->bindParam(":ddd", $json->ddd);
                    $consulta->bindParam(":siafi", $json->siafi);
                    $consulta->execute();
                } else{
                    mensagemErroCep("CEP inexistente");
                }
            }
        }
        else{
            mensagemErroCep("CEP inválido (precisa conter 8 números)");
        }
    }
?>

<div class="card">
    <div class="card-header">
        <h2 class="float-left">Cadastros de CEPs</h2>
    </div>
    <div class="card-body">
        <form method="POST">    <!-- Não necessario colocar action pois será tratado no mesmo arquivo/site -->

            <label for="cep">Digite seu CEP</label>
            <input type="text" name="cep" 
                id="cep" class="form-control" placeholder="Digite os 8 números" required>
            <br>
            <button type="submit" class="btn btn-success">
                Buscar
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table 
            class="
            table 
            table-bordered 
            table-hover 
            table-striped"
        >
            <thead>
                <tr>
                    <td>Cep</td>
                    <td>Logradouro</td>
                    <td>Complemento</td>
                    <td>Bairro</td>
                    <td>localidade</td>
                    <td>uf</td>
                    <td>ibge</td>
                    <td>gia</td>
                    <td>ddd</td>
                    <td>siafi</td>
                </tr>
            </thead>

            <tbody>
                <?php
                    if(!is_null($json) && isset($json) && !isset($json->erro)) {
                ?>
                <tr>
                    <td><?=$json->cep?></td>
                    <td><?=$json->logradouro?></td>
                    <td><?=$json->complemento?></td>
                    <td><?=$json->bairro?></td>
                    <td><?=$json->localidade?></td>
                    <td><?=$json->uf?></td>
                    <td><?=$json->ibge?></td>
                    <td><?=$json->gia?></td>
                    <td><?=$json->ddd?></td>
                    <td><?=$json->siafi?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>