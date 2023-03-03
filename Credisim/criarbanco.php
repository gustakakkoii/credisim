<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    include('head.php');
    ?>
    <title>Credisim - criar banco</title>
</head>

<body>
    <?php
    include('nav.php');
    ?>
    <main>
        <div class="corpo ficha">
            <div class="mensagem">
                <?php
                require_once 'config.php';

                $arquivo = './bd/SQL.sql';
                $handle = fopen($arquivo, 'r');
                $ler = fread($handle, filesize($arquivo));

                $comandossql = explode(';', $ler);

                for ($i = 0; $i < sizeof($comandossql) - 1; $i++) {
                    if ($i < 5) {
                        InserirExcluir($comandossql[$i], null, null, null);
                    } else {
                        InserirExcluir($comandossql[$i], null, null);
                    }
                }
                echo '<div class="sucesso">Banco de dados atualizado com sucesso';
                ?>
            </div>
        </div>
    </main>
</body>

</html>