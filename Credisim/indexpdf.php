<?php

use Dompdf\Dompdf;
require_once 'dompdf/vendor/autoload.php';

$cpf = $_POST['CPF'];

$dompdf = new Dompdf();

if (isset($_POST['CPF'])) {
    $cpf = $_POST['CPF'];

    include('config.php');
    $con = Consulta("SELECT 
            cliente.CPF, 
            cliente.Nome, 
            cliente.Sobrenome, 
            cliente.RG, 
            estadocivil.estadocivil,
            genero.genero,
            cliente.nascimento, 
            cliente.nacionalidade, 
            cliente.naturalidade, 
            cliente.telefone,
            cliente.celular,
            cliente.email,
            cliente.fotinha,
            cliente.pai,
            cliente.mae,
            cliente.renda,
            cliente.numerobeneficio,
            beneficio.codigo,
            beneficio.tipoBeneficio,
            gruposdebeneficio.grupo,
            endereco.rua,
            endereco.numero,
            endereco.bairro,
            endereco.cidade,
            uf.siglaUF,
            endereco.cep,
            dadosbancarios.banco,
            dadosbancarios.agencia,
            dadosbancarios.conta,
            tiposdeconta.tipo,
            anexo.RG as 'RGfile',
            anexo.CTPS,
            anexo.CNH,
            anexo.CN,
            anexo.CompEndereco
            FROM cliente
            LEFT JOIN estadocivil ON estadocivil.idestadocivil = cliente.estadocivil
            LEFT JOIN genero ON genero.idgenero = cliente.genero
            LEFT JOIN endereco ON endereco.CPF = cliente.CPF
            LEFT JOIN uf ON uf.idUF = endereco.UF
            LEFT JOIN beneficio ON beneficio.codigo = cliente.tipobeneficio
            LEFT JOIN gruposdebeneficio ON gruposdebeneficio.idgruposdebeneficio = beneficio.gruposdebeneficio
            LEFT JOIN dadosbancarios ON dadosbancarios.CPF = cliente.CPF
            LEFT JOIN tiposdeconta ON tiposdeconta.idtiposdeconta = dadosbancarios.tipodeconta
            LEFT JOIN anexo ON anexo.CPF = cliente.CPF
            WHERE cliente.CPF LIKE '$cpf%';");
    foreach ($con as $dado) {
        if ($dado['fotinha'] != '') {
            $fotinha = $dado['fotinha'];
        } else {
            $fotinha = 'style/perfil.png';
        }
        $idade = '';
        if ($dado['nascimento'] != '') {
            list($dia, $mes, $ano) = explode('/', $dado['nascimento']);

            // data atual
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            // Descobre a unix timestamp da data de nascimento do fulano
            $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

            // cálculo
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
            $idade .=  " Anos";
        }

        $html = "<!DOCTYPE html>
        <html lang='en'>
        
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Document</title>
        </head>
        
        <body>
            <h1>DADOS DO CLIENTE</h1>
            <table>
                <tr>
                    <td colspan='10'><b>Nome:</b><br>" . $dado['Nome'] . ' ' . $dado['Sobrenome'] . "</td>
                    <td colspan='2'><b>Idade:</b><br>" . $idade . "</td>
                </tr>
                <tr>
                    <td colspan='6'><b>Renda:</b><br>R$" . $dado['renda'] . "</td>
                    <td colspan='6'><b>Número do Benefício:</b><br>" . $dado['numerobeneficio'] . "</td>
                </tr>
                <tr>
                    <td colspan='10'><b>Grupo do Benefício:</b><br>" . $dado['grupo'] . "</td>
                    <td colspan='2'><b>Benefício:</b><br>" . $dado['codigo'] . "</td>
                </tr>
                <tr>
                    <td colspan='12'><b>Tipo de Benefício:</b><br>" . $dado['tipoBeneficio'] . "</td>
                </tr>
                <tr>
                    <td colspan='7'><b>CPF:</b><br>" . $dado['CPF'] . "</td>
                    <td colspan='5'><b>RG:</b><br>" . $dado['RG'] . "</td>
                </tr>
                <tr>
                    <td colspan='5'><b>Estado Civil:</b><br>" . $dado['estadocivil'] . "</td>
                    <td colspan='4'><b>Gênero:</b><br>" . $dado['genero'] . "</td>
                    <td colspan='3'><b>Nascimento:</b><br>" . $dado['nascimento'] . "</td>
                </tr>
                <tr>
                    <td colspan='7' style='width: 50%;'><b>Nacionalidade:</b><br>" . $dado['nacionalidade'] . "</td>
                    <td colspan='5' style='width: 50%;'><b>Naturalidade:</b><br>" . $dado['naturalidade'] . "</td>
                </tr>
                <tr>
                    <td colspan='7' style='width: 50%;'><b>Nome do Pai:</b><br>" . $dado['pai'] . "</td>
                    <td colspan='5' style='width: 50%;'><b>Nome da Mãe:</b><br>" . $dado['mae'] . "</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td colspan='6'><b>Endereço:</b><br>" . $dado['rua'] . "</td>
                    <td><b>Número:</b><br>" . $dado['numero'] . "</td>
                    <td colspan='5'><b>Bairro:</b><br>" . $dado['bairro'] . "</td>
                </tr>
                <tr>
                    <td colspan='5'><b>CEP:</b><br>" . $dado['cep'] . "</td>
                    <td colspan='5'><b>Cidade:</b><br>" . $dado['cidade'] . "</td>
                    <td colspan='2'><b>UF:</b><br>" . $dado['siglaUF'] . "</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style='width: 50%;'><b>Telefone:</b><br>" . $dado['telefone'] . "</td>
                    <td style='width: 50%;'><b>Celular:</b><br>" . $dado['celular'] . "</td>
                </tr>
                <tr>
                    <td colspan='2'><b>E-mail:</b><br>" . $dado['email'] . "</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style='width: 50%;'><b>Banco:</b><br>" . $dado['banco'] . "</td>
                    <td style='width: 50%;'><b>Agencia:</b><br>" . $dado['agencia'] . "</td>
                </tr>
                <tr>
                    <td style='width: 50%;'><b>Tipo de Conta:</b><br>" . $dado['tipo'] . "</td>
                    <td style='width: 50%;'><b>Conta:</b><br>" . $dado['conta'] . "</td>
                </tr>
            </table>
        
            <style>
                b {
                    font-size: 18px;
                }
        
                * {
                    font-family: Arial, Helvetica, sans-serif;
                }
        
                table {
                    margin-bottom: 20px;
                    width: 100%;
                }

                td {
                    vertical-align: text-top;
                    padding-left: 3px;
                    border: 1px solid black;
                }
            </style>
        </body>
        
        </html>";
    }
}

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

header('Content-type: application/pdf');
$dompdf->stream(
    "Ficha - " . $cpf,
    array(
        "Attachment" => true
    )
);
