<?php
function novaConexao($banco = 'credisim')
{
    $servidor = '127.0.0.1';
    $usuario = 'root';
    $senha = '';

    $conexao = new mysqli($servidor, $usuario, $senha, $banco);

    if ($conexao->connect_error) {
        die($conexao->connect_error);
    }
    return $conexao;
}

function InserirExcluir($sql, $parametros, $array, $banco = 'credisim')
{
    $conexao = novaConexao($banco);
    if ($parametros != null && $array != null) {
        $dados = $_POST;
        $stmt = $conexao->prepare($sql);

        $stmt->bind_param($parametros, ...$array);

        if ($stmt->execute()) {
            unset($dados);
        }
    } else {
        $conexao->query($sql);
    }

    $conexao->close();
}

function Consulta($sql, $banco = 'credisim')
{
    $conexao = novaConexao($banco);
    $resultado = $conexao->query($sql);

    $registros = [];

    if (!empty($resultado->num_rows) && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $registros[] = $row;
        }
    } else {
        echo $conexao->error;
    }

    $conexao->close();
    return $registros;
}
