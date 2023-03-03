<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php

    use LDAP\Result;

    include('head.php');
    ?>
    <title>Credisim - editar</title>
</head>

<body>
    <?php
    include('nav.php');
    ?>
    <main>
        <div class="corpo ficha">
            <?php

            include('config.php');
            function validateCPF($number)
            {
                $cpf = preg_replace('/[^0-9]/', "", $number);

                if (strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
                    return false;
                }

                $sum = 0;
                $number_to_multiplicate = 10;

                for ($index = 0; $index < 9; $index++) {
                    $sum += $cpf[$index] * ($number_to_multiplicate--);
                }

                $result = (($sum * 10) % 11);

                $number_quantity_to_loop = [9, 10];

                foreach ($number_quantity_to_loop as $item) {

                    $sum = 0;
                    $number_to_multiplicate = $item + 1;

                    for ($index = 0; $index < $item; $index++) {

                        $sum += $cpf[$index] * ($number_to_multiplicate--);
                    }

                    $result = (($sum * 10) % 11);

                    if ($cpf[$item] != $result) {
                        return false;
                    };
                }
                return true;
            }
            if (isset($_POST['editar'])) {
                $cpf = $_POST['editar'];
                $con = Consulta("SELECT 
            cliente.CPF, 
            cliente.Nome, 
            cliente.Sobrenome, 
            cliente.RG, 
            estadocivil.estadocivil,
            estadocivil.idestadocivil,
            genero.genero,
            genero.idgenero,
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
            uf.idUF,
            endereco.cep,
            dadosbancarios.banco,
            dadosbancarios.agencia,
            dadosbancarios.conta,
            tiposdeconta.tipo,
            tiposdeconta.idtiposdeconta,
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
            WHERE cliente.CPF LIKE '$cpf%'");
                foreach ($con as $dado) {
            ?>
                    <h1>Editar</h1>
                    <div class="dados container">
                        <form action="editar.php" method="post" id="cadastrar" enctype="multipart/form-data">
                            <section class="row">
                                <article class="col-lg-4 campos">
                                    <label for="foto" id="img-container">
                                        <img id="preview" src="<?php

                                                                $lista_dir = scandir("clientes");
                                                                $n = 0;
                                                                foreach ($lista_dir as $arquivo) {
                                                                    if ($arquivo == substr($dado['fotinha'], 9)) {
                                                                        $n++;
                                                                        echo "clientes/" . $arquivo;
                                                                    }
                                                                }
                                                                if ($n == 0) {
                                                                    echo 'style/perfil.png';
                                                                }
                                                                ?>">
                                        <p class="fotolabel">Foto</p>
                                    </label>
                                    <input type="file" class="notexist" name="foto" id="foto" value="<?= $dado['fotinha'] ?>" accept="image/*">
                                </article>
                                <article class="col-lg-8 block">
                                    <h3>Dados pessoais:</h3>
                                    <div class="row blockchild">
                                        <div class="col-md-6 campos">
                                            <input type="text" name="Nome" placeholder="Nome" value="<?= $dado['Nome'] ?>">
                                        </div>
                                        <div class="col-md-6 campos">
                                            <input type="text" name="Sobrenome" placeholder="Sobrenome" value="<?= $dado['Sobrenome'] ?>">
                                        </div>
                                    </div>
                                    <div class="row blockchild">
                                        <div class="col-md-4 campos">
                                            <input type="number" name="Renda" id="renda" placeholder="Renda" value="<?= $dado['renda'] ?>">
                                        </div>
                                        <div class="col-md-4 campos">
                                            <input type="text" name="beneficio" id="beneficio" placeholder="Número do Benefício" value="<?= $dado['numerobeneficio'] ?>">
                                        </div>
                                        <div class="col-md-4 campos">
                                            <select name="tipodebeneficio" id="tipodebeneficio">
                                                <?php
                                                if ($dado['tipoBeneficio'] != '') {
                                                    echo "<option value='" . $dado['codigo'] . "'selected>" . $dado['tipoBeneficio'] . "</option>";
                                                } else {
                                                    echo '<option value="null" selected disabled>Tipo de Benefício</option>';
                                                }
                                                $con = Consulta("SELECT * FROM beneficio;");
                                                foreach ($con as $dado2) {
                                                    echo '<option value="' . $dado2['codigo'] . '">' . $dado2['tipoBeneficio'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row blockchild">
                                        <div class="col-md-6 campos">
                                            <input type="text" name="cpf" id="CPF" placeholder="CPF" value="<?= $cpf ?>">
                                        </div>
                                        <div class="col-md-6 campos">
                                            <input type="text" name="RG" id="RG" placeholder="RG" value="<?= $dado['RG'] ?>">
                                        </div>
                                    </div>
                                    <div class="row blockchild">
                                        <div class="col-md-4 campos">
                                            <select name="estadocivil" id="estadocivil">
                                                <?php
                                                if ($dado['estadocivil'] != '') {
                                                    echo "<option value='" . $dado['idestadocivil'] . "'selected>" . $dado['estadocivil'] . "</option>";
                                                } else {
                                                    echo '<option value="null" selected disabled>Estado Civil</option>';
                                                }
                                                $con = Consulta("SELECT * FROM estadocivil;");
                                                foreach ($con as $dado2) {
                                                    echo '<option value="' . $dado2['idestadocivil'] . '">' . $dado2['estadocivil'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-6 campos">
                                            <select name="genero" id="genero">
                                                <?php
                                                if ($dado['genero'] != '') {
                                                    echo "<option value='" . $dado['idgenero'] . "'selected>" . $dado['genero'] . "</option>";
                                                } else {
                                                    echo '<option value="null" selected disabled>Gênero</option>';
                                                }
                                                $con = Consulta("SELECT * FROM genero;");
                                                foreach ($con as $dado2) {
                                                    echo '<option value="' . $dado2['idgenero'] . '">' . $dado2['genero'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-6 campos">
                                            <input type="text" id="Nascimento" name="Nascimento" placeholder="Nascimento" title="Data de nascimento" value="<?= $dado['nascimento'] ?>">
                                        </div>
                                    </div>
                                    <div class="row blockchild">
                                        <div class="col-md-6 campos">
                                            <input type="text" name="Nacionalidade" placeholder="Nacionalidade" value="<?= $dado['nacionalidade'] ?>">
                                        </div>
                                        <div class="col-md-6 campos">
                                            <input type="text" name="Naturalidade" placeholder="Naturalidade" value="<?= $dado['naturalidade'] ?>">
                                        </div>
                                    </div>
                                    <div class="row blockchild">
                                        <div class="col-md-6 campos">
                                            <input type="text" name="Pai" placeholder="Nome do Pai" value="<?= $dado['pai'] ?>">
                                        </div>
                                        <div class="col-md-6 campos">
                                            <input type="text" name="Mae" placeholder="Nome da Mãe" value="<?= $dado['mae'] ?>">
                                        </div>
                                    </div>
                                </article>
                            </section>
                            <section>
                                <h3>Endereço:</h3>
                                <article class="row">
                                    <div class="col-lg-5 col-8">
                                        <input type="text" name="Endereço" placeholder="Endereço" value="<?= $dado['rua'] ?>">
                                    </div>
                                    <div class="col-lg-2 col-4">
                                        <input type="number" name="Número" placeholder="Número" value="<?= $dado['numero'] ?>">
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" name="Bairro" placeholder="Bairro" value="<?= $dado['bairro'] ?>">
                                    </div>
                                    <div class="col-lg-5">
                                        <input type="text" name="CEP" id="CEP" placeholder="CEP" value="<?= $dado['cep'] ?>">
                                    </div>
                                    <div class="col-lg-5 col-8">
                                        <input type="text" name="Cidade" placeholder="Cidade" value="<?= $dado['cidade'] ?>">
                                    </div>
                                    <div class="col-lg-2 col-4">
                                        <select name="UF">
                                            <?php
                                            if ($dado['idUF'] != '') {
                                                echo "<option value='" . $dado['idUF'] . "'selected>" . $dado['siglaUF'] . "</option>";
                                            } else {
                                                echo '<option value="null" selected disabled>UF</option>';
                                            }
                                            $con = Consulta('SELECT * FROM uf;');
                                            foreach ($con as $dado2) {
                                                echo '<option value="' . $dado2['idUF'] . '">' . $dado2['siglaUF'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </article>
                            </section>
                            <section>
                                <h3>Contato:</h3>
                                <article class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="Telefone" id="Telefone" placeholder="Telefone" value="<?= $dado['telefone'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="Celular" id="Celular" placeholder="Celular" value="<?= $dado['celular'] ?>">
                                    </div>
                                    <div>
                                        <input type="email" name="email" placeholder="Email" value="<?= $dado['email'] ?>">
                                    </div>
                                </article>
                                <h3>Dados Bancarios:</h3>
                                <article class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="Banco" placeholder="Banco" value="<?= $dado['banco'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="Agencia" placeholder="Agencia" value="<?= $dado['agencia'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <select name="Tipodeconta">
                                            <?php
                                            if ($dado['tipo'] != '') {
                                                echo "<option value='" . $dado['idtiposdeconta'] . "'selected>" . $dado['tipo'] . "</option>";
                                            } else {
                                                echo '<option value="null" selected disabled>Tipo de conta</option>';
                                            }
                                            $con = Consulta('SELECT * FROM tiposdeconta;');
                                            foreach ($con as $dado2) {
                                                echo '<option value="' . $dado2['idtiposdeconta'] . '">' . $dado2['tipo'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="Conta" placeholder="Conta" value="<?= $dado['conta'] ?>">
                                    </div>
                                </article>
                                <h3>Anexos:</h3>
                                <article class="setanexos">
                                    <div>
                                        <label for="CN" class="setanexosimg">
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
                                        </label>
                                        <input type="file" class="notexist" name="CN" id="CN" accept="image/*, .pdf">
                                    </div>
                                    <div>
                                        <label for="RGfile" class="setanexosimg">
                                            <img id="previewRG" src="<?php
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
                                        </label>
                                        <input type="file" class="notexist" name="RGfile" id="RGfile" accept="image/*, .pdf">
                                    </div>
                                    <div>
                                        <label for="CNH" class="setanexosimg">
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
                                        </label>
                                        <input type="file" class="notexist" name="CNH" id="CNH" accept="image/*, .pdf">
                                    </div>
                                    <div>
                                        <label for="CTPS" class="setanexosimg">
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
                                        </label>
                                        <input type="file" class="notexist" name="CTPS" id="CTPS" accept="image/*, .pdf">
                                    </div>
                                    <div>
                                        <label for="CompEndereco" class="setanexosimg">
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
                                        </label>
                                        <input type="file" class="notexist" name="CompEndereco" id="CompEndereco" accept="image/*, .pdf">
                                    </div>
                                </article>
                            </section>
                            <input type="text" class="notexist" name="cpforiginal" value="<?= $cpf ?>">
                            <div class="enviar" onclick="enviar('#cadastrar')">Editar dados</div>
                        </form>
                    </div>
        </div>

        <?php
                    include('script.php');
        ?>
        <script>
            function readImage() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        document.getElementById("preview").src = e.target.result;
                    }
                };
                file.readAsDataURL(this.files[0]);
            }

            document.getElementById("foto").addEventListener("change", readImage, false);

            function readImageCN() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        if (e.target.result.indexOf("data:application/") == -1) {
                            document.getElementById("previewCN").src = e.target.result;
                        } else {
                            document.getElementById("previewCN").src = "anexos/pdf.png";
                        }
                    };
                    file.readAsDataURL(this.files[0]);
                }
            }
            document.getElementById("CN").addEventListener("change", readImageCN, false);

            function readImageRG() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        if (e.target.result.indexOf("data:application/") == -1) {
                            document.getElementById("previewRG").src = e.target.result;
                        } else {
                            document.getElementById("previewRG").src = "anexos/pdf.png";
                        }
                    };
                    file.readAsDataURL(this.files[0]);
                }
            }
            document.getElementById("RGfile").addEventListener("change", readImageRG, false);

            function readImageCNH() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        if (e.target.result.indexOf("data:application/") == -1) {
                            document.getElementById("previewCNH").src = e.target.result;
                        } else {
                            document.getElementById("previewCNH").src = "anexos/pdf.png";
                        }
                    };
                    file.readAsDataURL(this.files[0]);
                }
            }
            document.getElementById("CNH").addEventListener("change", readImageCNH, false);

            function readImageCTPS() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        if (e.target.result.indexOf("data:application/") == -1) {
                            document.getElementById("previewCTPS").src = e.target.result;
                        } else {
                            document.getElementById("previewCTPS").src = "anexos/pdf.png";
                        }
                    };
                    file.readAsDataURL(this.files[0]);
                }
            }
            document.getElementById("CTPS").addEventListener("change", readImageCTPS, false);

            function readImageCompEndereco() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        if (e.target.result.indexOf("data:application/") == -1) {
                            document.getElementById("previewCompEndereco").src = e.target.result;
                        } else {
                            document.getElementById("previewCompEndereco").src = "anexos/pdf.png";
                        }
                    };
                    file.readAsDataURL(this.files[0]);
                }
            }
            document.getElementById("CompEndereco").addEventListener("change", readImageCompEndereco, false);
        </script>
    <?php
                }
            } else {
                $cpf = $_POST['cpf'];
                $cpforiginal = $_POST['cpforiginal'];
                $Nome = $_POST['Nome'];
                $Sobrenome = $_POST['Sobrenome'];
                $RG = $_POST['RG'];
                if (isset($_POST['estadocivil'])) {
                    if ($_POST['estadocivil'] != '') {
                        $estadocivil = $_POST['estadocivil'];
                    } else {
                        $estadocivil = 'null';
                    }
                } else {
                    $estadocivil = 'null';
                }
                if (isset($_POST['genero'])) {
                    if ($_POST['genero'] != '') {
                        $genero = $_POST['genero'];
                    } else {
                        $genero = 'null';
                    }
                } else {
                    $genero = 'null';
                }
                if ($_POST['Nascimento'] == '') {
                    $nascimento = '';
                } else {
                    $nascimento = $_POST['Nascimento'];
                }
                $nacionalidade = $_POST['Nacionalidade'];
                $naturalidade = $_POST['Naturalidade'];
                $endereco = $_POST['Endereço'];
                if ($_POST['Número'] == '') {
                    $numero = 'null';
                } else {
                    $numero = $_POST['Número'];
                }
                $bairro = $_POST['Bairro'];
                $cep = $_POST['CEP'];
                $cidade = $_POST['Cidade'];

                if (isset($_POST['UF'])) {
                    $uf = $_POST['UF'];
                } else {
                    $uf = 'null';
                }
                $telefone = $_POST['Telefone'];
                $celular = $_POST['Celular'];
                $email = $_POST['email'];

                if (isset($_FILES['foto']) && $_FILES['foto']['name'] != '') {
                    $extencao = strtolower(substr($_FILES['foto']['name'], strripos($_FILES['foto']['name'], '.')));
                    $diretorio = "clientes/";
                    $fotinha = ($diretorio . $cpf . $extencao);

                    move_uploaded_file($_FILES['foto']['tmp_name'], $fotinha);
                } else {
                    $fotinha = (Consulta("SELECT fotinha FROM cliente WHERE CPF = '$cpf'")[0]['fotinha']);
                }
                if (isset($_FILES['CN']) && $_FILES['CN']['name'] != '') {
                    $extencao = strtolower(substr($_FILES['CN']['name'], strripos($_FILES['CN']['name'], '.')));
                    $diretorio = "anexos/CN/";
                    $CN = ($diretorio . $cpf . '-CN' . $extencao);

                    move_uploaded_file($_FILES['CN']['tmp_name'], $CN);
                } else {
                    $CN = (Consulta("SELECT CN FROM anexo WHERE CPF = '$cpf'")[0]['CN']);
                }
                if (isset($_FILES['RGfile']) && $_FILES['RGfile']['name'] != '') {
                    $extencao = strtolower(substr($_FILES['RGfile']['name'], strripos($_FILES['RGfile']['name'], '.')));
                    $diretorio = "anexos/RG/";
                    $RGfile = ($diretorio . $cpf . '-RG' . $extencao);

                    move_uploaded_file($_FILES['RGfile']['tmp_name'], $RGfile);
                } else {
                    $RGfile = (Consulta("SELECT RG FROM anexo WHERE CPF = '$cpf'")[0]['RG']);
                }
                if (isset($_FILES['CNH']) && $_FILES['CNH']['name'] != '') {
                    $extencao = strtolower(substr($_FILES['CNH']['name'], strripos($_FILES['CNH']['name'], '.')));
                    $diretorio = "anexos/CNH/";
                    $CNH = ($diretorio . $cpf . '-CNH' . $extencao);

                    move_uploaded_file($_FILES['CNH']['tmp_name'], $CNH);
                } else {
                    $CNH = (Consulta("SELECT CNH FROM anexo WHERE CPF = '$cpf'")[0]['CNH']);
                }
                if (isset($_FILES['CTPS']) && $_FILES['CTPS']['name'] != '') {
                    $extencao = strtolower(substr($_FILES['CTPS']['name'], strripos($_FILES['CTPS']['name'], '.')));
                    $diretorio = "anexos/CTPS/";
                    $CTPS = ($diretorio . $cpf . '-CTPS' . $extencao);

                    move_uploaded_file($_FILES['CTPS']['tmp_name'], $CTPS);
                } else {
                    $CTPS = (Consulta("SELECT CTPS FROM anexo WHERE CPF = '$cpf'")[0]['CTPS']);
                }
                if (isset($_FILES['CompEndereco']) && $_FILES['CompEndereco']['name'] != '') {
                    $extencao = strtolower(substr($_FILES['CompEndereco']['name'], strripos($_FILES['CompEndereco']['name'], '.')));
                    $diretorio = "anexos/CompEndereco/";
                    $CompEndereco = ($diretorio . $cpf . '-CompEndereco' . $extencao);

                    move_uploaded_file($_FILES['CompEndereco']['tmp_name'], $CompEndereco);
                } else {
                    $CompEndereco = (Consulta("SELECT CompEndereco FROM anexo WHERE CPF = '$cpf'")[0]['CompEndereco']);
                }

                $pai = $_POST['Pai'];
                $mae = $_POST['Mae'];


                if ($_POST['Renda'] != '') {
                    $renda = $_POST['Renda'];
                } else {
                    $renda = 'null';
                }

                if ($_POST['beneficio'] != '') {
                    $numerobeneficio = $_POST['beneficio'];
                } else {
                    $numerobeneficio = 'null';
                }

                if (isset($_POST['tipodebeneficio'])) {
                    $tipobeneficio = $_POST['tipodebeneficio'];
                } else {
                    $tipobeneficio = 'null';
                }

                $banco = $_POST['Banco'];
                $agencia = $_POST['Agencia'];
                $conta = $_POST['Conta'];

                if (isset($_POST['Tipodeconta'])) {
                    $tipodeconta = $_POST['Tipodeconta'];
                } else {
                    $tipodeconta = 'null';
                }

                $con2 = Consulta("UPDATE cliente SET
                CPF = '$cpf', 
                Nome = '$Nome', 
                Sobrenome = '$Sobrenome', 
                RG = '$RG', 
                estadocivil = $estadocivil, 
                genero = $genero, 
                nascimento = '$nascimento', 
                nacionalidade = '$nacionalidade', 
                naturalidade = '$naturalidade', 
                telefone = '$telefone',
                celular = '$celular', 
                email = '$email', 
                fotinha = '$fotinha', 
                pai = '$pai', 
                mae = '$mae', 
                renda = $renda, 
                numerobeneficio = '$numerobeneficio', 
                tipobeneficio = $tipobeneficio
                WHERE CPF = '$cpforiginal';");
                $con2 = Consulta("UPDATE endereco SET
                CPF = '$cpf', 
                rua = '$endereco', 
                numero = $numero, 
                bairro = '$bairro', 
                cidade = '$cidade', 
                uf = $uf, 
                cep = '$cep'
                WHERE CPF = '$cpforiginal';");

                $con2 = Consulta("UPDATE dadosbancarios SET
                CPF = '$cpf', 
                banco = '$banco', 
                agencia = '$agencia', 
                conta = '$conta', 
                tipodeconta = $tipodeconta
                WHERE CPF = '$cpforiginal'");

                $con2 = Consulta("UPDATE anexo SET
                CPF = '$cpf', 
                CN = '$CN', 
                RG = '$RGfile', 
                CNH = '$CNH', 
                CTPS = '$CTPS', 
                CompEndereco = '$CompEndereco'
                WHERE CPF = '$cpforiginal';");



    ?>
    <form method="POST" action="ficha.php" id="form" class="mensagem">
        <input class="notexist" type="text" name="CPF" value="<?= $cpf ?>">
        <input class="notexist" type="text" name="mensagem" value="mensagem">
    </form>
    <script>
        document.querySelector('#form').submit();
    </script>
<?php

            }
?>
    </main>
</body>

</html>