<?php
    //função para mostrar a janela de erro
    function mensagemErro($msg) {
        ?>
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?=$msg?>',
            }).then((result) => {
                history.back(); 
            })
        </script>
        <?php
        exit;
    } //fim da função

    //função para máscara do cep
    function mask($val, $mask){
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
        exit;
    } //fim da função

    //função para mostrar a janela de erro na página de ceps
    function mensagemErroCep($msg) {
        ?>
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?=$msg?>',
            }).then((result) => {
                location.href='listar/ceps'
            })
        </script>
        <?php
        exit;
    } //fim da função