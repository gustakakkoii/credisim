<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    include('head.php');
    ?>
    <title>Credisim - ficha</title>
</head>

<body>
    <?php
    include('nav.php');
    ?>
    <main>
        <?php
        if (isset($_POST['mensagem'])) {
        ?>
            <div class="sucesso">Dados editados com sucesso!</div>
        <?php
        }
        ?>
        <div class="corpo ficha">
            <?php
            include('config.php');
            if (isset($_POST['CPF'])) {
                $cpf = $_POST['CPF'];
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
                    if ($dado['renda'] == '') {
                        $dado['renda'] = 0;
                    } ?>
                    <div class="dados container">
                        <h1>Ficha do cliente</h1>
                        <section class="row">
                            <article class="col-lg-4 campos">
                                <div for="foto" id="img-container">
                                    <img id="clientefoto" src="<?php
                                                                if ($dado['fotinha'] != '') {
                                                                    echo $dado['fotinha'];
                                                                } else {
                                                                    echo 'style/perfil.png';
                                                                } ?>">
                                </div>
                            </article>
                            <article class="col-lg-8 block">
                                <div class="row blockchild">
                                    <div class="col-8">
                                        <b>Nome: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['Nome'] . ' ' . $dado['Sobrenome'] ?>')"> <?= $dado['Nome'] . ' ' . $dado['Sobrenome'] ?></p>
                                    </div>
                                    <div class="col-4">
                                        <b>Idade: </b>
                                        <?php
                                        // separando yyyy, mm, ddd
                                        if ($dado['nascimento'] != '') {
                                            list($dia, $mes, $ano) = explode('/', $dado['nascimento']);

                                            // data atual
                                            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                                            // Descobre a unix timestamp da data de nascimento do fulano
                                            $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

                                            // cálculo
                                            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
                                            $idade .= " Anos";
                                        } else {
                                            $idade = '';
                                        } ?>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $idade ?>')"><?= $idade ?></p>
                                    </div>
                                </div>



                                <div class="row blockchild">
                                    <div class="col-md-6">
                                        <b>Renda: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('R$<?= $dado['renda'] ?>')"> R$<?= $dado['renda'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <b>Número do Benefício: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['numerobeneficio'] ?>')"> <?= $dado['numerobeneficio'] ?></p>
                                    </div>
                                    <div class="col-9">
                                        <b>Grupo do Benefício: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['grupo'] ?>')"> <?= $dado['grupo'] ?></p>
                                    </div>
                                    <div class="col-3">
                                        <b>Benefício: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['codigo'] ?>')"> <?= $dado['codigo'] ?></p>
                                    </div>
                                    <div>
                                        <b>Tipo de Benefício: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['tipoBeneficio'] ?>')"> <?= $dado['tipoBeneficio'] ?></p>
                                    </div>
                                </div>



                                <div class="row blockchild">
                                    <div class="col-md-6">
                                        <b>CPF: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['CPF'] ?>')"> <?= $dado['CPF'] ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <b>RG: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['RG'] ?>')"> <?= $dado['RG'] ?></p>
                                    </div>
                                </div>
                                <div class="row blockchild">
                                    <div class="col-md-4">
                                        <b>Estado Civil: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['estadocivil'] ?>')"> <?= $dado['estadocivil'] ?></p>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <b>Gênero: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['genero'] ?>')"> <?= $dado['genero'] ?></p>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <b>Nascimento: </b>
                                        <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['nascimento'] ?>')"> <?= $dado['nascimento'] ?></p>
                                    </div>
                                </div>
                            </article>
                        </section>
                        <section>
                            <div class="row blockchild">
                                <div class="col-md-6">
                                    <b>Nacionalidade: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['nacionalidade'] ?>')"> <?= $dado['nacionalidade'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <b>Naturalidade: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['naturalidade'] ?>')"> <?= $dado['naturalidade'] ?></p>
                                </div>
                            </div>
                            <div class="row blockchild">
                                <div class="col-md-6">
                                    <b>Nome do Pai: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['pai'] ?>')"> <?= $dado['pai'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <b>Nome da Mãe: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['mae'] ?>')"> <?= $dado['mae'] ?></p>
                                </div>
                            </div>
                            <h3>Endereço:</h3>
                            <article class="row">
                                <div class="col-lg-5 col-8">
                                    <b>Endereço: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['rua'] ?>')"> <?= $dado['rua'] ?></p>
                                </div>
                                <div class="col-lg-2 col-4">
                                    <b>Número: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['numero'] ?>')"> <?= $dado['numero'] ?></p>
                                </div>
                                <div class="col-lg-5">
                                    <b>Bairro: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['bairro'] ?>')"> <?= $dado['bairro'] ?></p>
                                </div>
                                <div class="col-lg-5">
                                    <b>CEP: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['cep'] ?>')"> <?= $dado['cep'] ?></p>
                                </div>
                                <div class="col-lg-5 col-8">
                                    <b>Cidade: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['cidade'] ?>')"> <?= $dado['cidade'] ?></p>
                                </div>
                                <div class="col-lg-2 col-4">
                                    <b>UF: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['siglaUF'] ?>')"> <?= $dado['siglaUF'] ?></p>
                                </div>
                            </article>
                        </section>
                        <section>
                            <h3>Contato:</h3>
                            <article class="row">
                                <div class="col-md-6">
                                    <b>Telefone: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['telefone'] ?>')"> <?= $dado['telefone'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <b>Celular: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['celular'] ?>')"> <?= $dado['celular'] ?></p>
                                </div>
                                <div>
                                    <b>E-mail: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['email'] ?>')"> <?= $dado['email'] ?></p>
                                </div>
                            </article>
                            <h3>Dados Bancarios:</h3>
                            <article class="row">
                                <div class="col-md-6">
                                    <b>Banco: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['banco'] ?>')"> <?= $dado['banco'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <b>Agencia: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['agencia'] ?>')"> <?= $dado['agencia'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <b>Tipo de conta: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['tipo'] ?>')"> <?= $dado['tipo'] ?></p>
                                </div>
                                <div class="col-md-6">
                                    <b>Conta: </b>
                                    <p class="campotexto" title="Pressione para copiar o texto" onclick="copiarTexto('<?= $dado['conta'] ?>')"> <?= $dado['conta'] ?></p>
                                </div>
                            </article>
                            <h3>Anexos:</h3>
                            <article class="setanexos">
                                <div class="cardanexos">
                                    <a href=<?php
                                            if ($dado['CN'] != '') {
                                                echo '"' . $dado['CN'] . '" download';
                                            } else {
                                                echo '"#"';
                                            } ?> for="CN" class="getanexosimg">
                                        <img id="previewCN" src="<?php
                                                                    if ($dado['CN'] != '') {
                                                                        if (strripos($dado['CN'], 'pdf') == false) {
                                                                            echo $dado['CN'];
                                                                        } else {
                                                                            echo 'anexos/pdf.png';
                                                                        }
                                                                    } else {
                                                                        echo 'anexos/file.png';
                                                                    } ?>">
                                        <p class="fotolabel">CN</p>
                                    </a>
                                </div>
                                <div class="cardanexos">
                                    <a href=<?php
                                            if ($dado['RGfile'] != '') {
                                                echo '"' . $dado['RGfile'] . '" download';
                                            } else {
                                                echo '"#"';
                                            } ?> for="RGfile" class="getanexosimg">
                                        <img id="previewRGfile" src="<?php
                                                                        if ($dado['RGfile'] != '') {
                                                                            if (strripos($dado['RGfile'], 'pdf') == false) {
                                                                                echo $dado['RGfile'];
                                                                            } else {
                                                                                echo 'anexos/pdf.png';
                                                                            }
                                                                        } else {
                                                                            echo 'anexos/file.png';
                                                                        } ?>">
                                        <p class="fotolabel">RG</p>
                                    </a>
                                </div>
                                <div class="cardanexos">
                                    <a href=<?php
                                            if ($dado['CNH'] != '') {
                                                echo '"' . $dado['CNH'] . '" download';
                                            } else {
                                                echo '"#"';
                                            } ?> for="CNH" class="getanexosimg">
                                        <img id="previewCNH" src="<?php
                                                                    if ($dado['CNH'] != '') {
                                                                        if (strripos($dado['CNH'], 'pdf') == false) {
                                                                            echo $dado['CNH'];
                                                                        } else {
                                                                            echo 'anexos/pdf.png';
                                                                        }
                                                                    } else {
                                                                        echo 'anexos/file.png';
                                                                    } ?>">
                                        <p class="fotolabel">CNH</p>
                                    </a>
                                </div>
                                <div class="cardanexos">
                                    <a href=<?php
                                            if ($dado['CTPS'] != '') {
                                                echo '"' . $dado['CTPS'] . '" download';
                                            } else {
                                                echo '"#"';
                                            } ?> for="CTPS" class="getanexosimg">
                                        <img id="previewCTPS" src="<?php
                                                                    if ($dado['CTPS'] != '') {
                                                                        if (strripos($dado['CTPS'], 'pdf') == false) {
                                                                            echo $dado['CTPS'];
                                                                        } else {
                                                                            echo 'anexos/pdf.png';
                                                                        }
                                                                    } else {
                                                                        echo 'anexos/file.png';
                                                                    } ?>">
                                        <p class="fotolabel">CTPS</p>
                                    </a>
                                </div>
                                <div class="cardanexos">
                                    <a href=<?php
                                            if ($dado['CompEndereco'] != '') {
                                                echo '"' . $dado['CompEndereco'] . '" download';
                                            } else {
                                                echo '"#"';
                                            } ?> for="CompEndereco" class="getanexosimg">
                                        <img id="previewCompEndereco" src="<?php
                                                                            if ($dado['CompEndereco'] != '') {
                                                                                if (strripos($dado['CompEndereco'], 'pdf') == false) {
                                                                                    echo $dado['CompEndereco'];
                                                                                } else {
                                                                                    echo 'anexos/pdf.png';
                                                                                }
                                                                            } else {
                                                                                echo 'anexos/file.png';
                                                                            } ?>">
                                        <p class="fotolabel">Comprovante Endereco</p>
                                    </a>
                                </div>
                            </article>
                        </section>
                        <section class="row">
                            <div class="col-md-6">
                                <form class="pdf" class="col-md-3 col-6" action="indexpdf.php" method="POST" id="pdf">
                                    <input class="notexist" type="text" name="CPF" value="<?= $_POST['CPF'] ?>">
                                    <div onclick="enviar('#pdf')">Gerar PDF</div>
                                </form>
                            </div>
                            <form class="col-md-3 col-6" action="editar.php" method="POST" id="editar">
                                <input class="notexist" type="text" name="editar" value="<?= $_POST['CPF'] ?>">
                                <input type="submit" class="editar" onclick="eviar('#editar')" value="Editar">
                            </form>
                            <form class="col-md-3 col-6" action="#" method="POST" id="excluir">
                                <input class="notexist" type="text" name="excluir" value="<?= $_POST['CPF'] ?>">
                                <div class="excluir" onclick="confirmar('#excluir')">Excluir</div>
                            </form>
                            <script>
                                function enviar(id) {
                                    form = document.querySelector(id);
                                    form.submit();
                                }

                                function confirmar(id) {
                                    comfirmar = confirm('Deseja excluir este cliente? Não será possível recuperar os dados!');
                                    if (comfirmar == true) {
                                        enviar(id);
                                    }
                                }

                                function copiarTexto(text) {
                                    navigator.clipboard.writeText(text);
                                }
                            </script>
                        </section>
                    </div>
                <?php }
            }
            if (isset($_POST['excluir'])) {
                $cpf = $_POST['excluir'];
                $result = Consulta("SELECT RG, CTPS, CN, CNH, CompEndereco FROM anexo WHERE CPF = '$cpf'");
                foreach ($result as $resultados) {
                    foreach ($resultados as $files) {
                        if ($files != '') {
                            if (unlink($files)) {
                                echo '';
                            }
                        }
                    }
                }
                $result = Consulta("SELECT fotinha FROM cliente WHERE CPF = '$cpf'");
                foreach ($result as $resultados) {
                    foreach ($resultados as $files) {
                        if ($files != '') {
                            if (unlink($files)) {
                                echo '';
                            }
                        }
                    }
                }
                InserirExcluir("DELETE FROM endereco WHERE cpf = ?", 's', [$_POST['excluir']]);
                InserirExcluir("DELETE FROM anexo WHERE cpf = ?", 's', [$_POST['excluir']]);
                InserirExcluir("DELETE FROM dadosbancarios WHERE cpf = ?", 's', [$_POST['excluir']]);
                InserirExcluir("DELETE FROM cliente WHERE cpf = ?", 's', [$_POST['excluir']]);
                ?>
                <div class="mensagem">
                    <div id="voltar" class="sucesso">Cliente excluido com sucesso!<br>(Aperte aqui para voltar para a consulta)</div>
                </div>
                <script>
                    voltar = document.querySelector('#voltar');
                    voltar.addEventListener('click', function() {
                        window.location.replace("index.php");
                    });
                </script>
            <?php
            }
            ?>
        </div>
    </main>
</body>

</html>