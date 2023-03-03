<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php

    use LDAP\Result;

    include('head.php');
    ?>
    <title>Credisim - cadastro</title>
</head>

<body>
    <?php
    include('nav.php');
    ?>
    <main>
        <?php

        function validateCPF($cpf) {
 
            // Extrai somente os números
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
             
            // Verifica se foi informado todos os digitos corretamente
            if (strlen($cpf) != 11) {
                return false;
            }
        
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }
        
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        
        }


        include('config.php');
        if (isset($_POST['Nome'])) {
            if (validateCPF($_POST['CPF'])) {
                $cpf = $_POST['CPF'];
                $con = Consulta("SELECT COUNT(*) FROM cliente WHERE CPF = '$cpf';");
                foreach ($con as $dado) {
                    if ($dado['COUNT(*)'] == 0) {
                        $Nome = $_POST['Nome'];
                        $Sobrenome = $_POST['Sobrenome'];
                        $RG = $_POST['RG'];
                        if (isset($_POST['genero'])) {
                            $genero = $_POST['genero'];
                        } else {
                            $genero = 'null';
                        }
                        if (isset($_POST['estadocivil'])) {
                            $estadocivil = $_POST['estadocivil'];
                        } else {
                            $estadocivil = 'null';
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
                            $fotinha = '';
                        }
                        if (isset($_FILES['CN']) && $_FILES['CN']['name'] != '') {
                            $extencao = strtolower(substr($_FILES['CN']['name'], strripos($_FILES['CN']['name'], '.')));
                            $diretorio = "anexos/CN/";
                            $CN = ($diretorio . $cpf . '-CN' . $extencao);

                            move_uploaded_file($_FILES['CN']['tmp_name'], $CN);
                        } else {
                            $CN = null;
                        }
                        if (isset($_FILES['RGfile']) && $_FILES['RGfile']['name'] != '') {
                            $extencao = strtolower(substr($_FILES['RGfile']['name'], strripos($_FILES['RGfile']['name'], '.')));
                            $diretorio = "anexos/RG/";
                            $RGfile = ($diretorio . $cpf . '-RG' . $extencao);

                            move_uploaded_file($_FILES['RGfile']['tmp_name'], $RGfile);
                        } else {
                            $RGfile = null;
                        }
                        if (isset($_FILES['CNH']) && $_FILES['CNH']['name'] != '') {
                            $extencao = strtolower(substr($_FILES['CNH']['name'], strripos($_FILES['CNH']['name'], '.')));
                            $diretorio = "anexos/CNH/";
                            $CNH = ($diretorio . $cpf . '-CNH' . $extencao);

                            move_uploaded_file($_FILES['CNH']['tmp_name'], $CNH);
                        } else {
                            $CNH = null;
                        }
                        if (isset($_FILES['CTPS']) && $_FILES['CTPS']['name'] != '') {
                            $extencao = strtolower(substr($_FILES['CTPS']['name'], strripos($_FILES['CTPS']['name'], '.')));
                            $diretorio = "anexos/CTPS/";
                            $CTPS = ($diretorio . $cpf . '-CTPS' . $extencao);

                            move_uploaded_file($_FILES['CTPS']['tmp_name'], $CTPS);
                        } else {
                            $CTPS = null;
                        }
                        if (isset($_FILES['CompEndereco']) && $_FILES['CompEndereco']['name'] != '') {
                            $extencao = strtolower(substr($_FILES['CompEndereco']['name'], strripos($_FILES['CompEndereco']['name'], '.')));
                            $diretorio = "anexos/CompEndereco/";
                            $CompEndereco = ($diretorio . $cpf . '-CompEndereco' . $extencao);

                            move_uploaded_file($_FILES['CompEndereco']['tmp_name'], $CompEndereco);
                        } else {
                            $CompEndereco = null;
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

                        $con2 = Consulta("INSERT INTO cliente
                        (CPF, Nome, Sobrenome, RG, estadocivil, genero, nascimento, nacionalidade, naturalidade, telefone, celular, email, fotinha, pai, mae, renda, numerobeneficio, tipobeneficio)
                        VALUES ('$cpf', '$Nome', '$Sobrenome', '$RG', $estadocivil, $genero, '$nascimento', '$nacionalidade', '$naturalidade', '$telefone', '$celular', '$email', '$fotinha', '$pai', '$mae', $renda, '$numerobeneficio', $tipobeneficio);
                        ");

                        $con2 = Consulta("INSERT INTO endereco
                        (CPF, rua, numero, bairro, cidade, uf, cep)
                        VALUES ('$cpf', '$endereco', $numero, '$bairro', '$cidade', $uf, '$cep');
                        ");

                        $con2 = Consulta("INSERT INTO dadosbancarios
                        (CPF, banco, agencia, conta, tipodeconta)
                        VALUES ('$cpf', '$banco', '$agencia', '$conta', $tipodeconta);
                        ");

                        $con2 = Consulta("INSERT INTO anexo
                        (CPF, CN, RG, CNH, CTPS, CompEndereco)
                        VALUES ('$cpf', '$CN', '$RGfile', '$CNH', '$CTPS', '$CompEndereco');
                        ");

                        echo '<div class="sucesso">Cadastro feito com sucesso!</div>';
                    } else {
                        echo '<div class="atencao">CPF já existente</div>';
                    }
                }
            } else {
                echo '<div class="atencao">CPF invalido</div>';
            }
        }
        ?>
        <div class="corpo ficha">
            <h1>Cadastrar</h1>
            <div class="dados container">
                <form action="#" method="post" id="cadastrar" enctype="multipart/form-data">
                    <section class="row">
                        <article class="col-lg-4 campos">
                            <label for="foto" id="img-container">
                                <img id="preview" src="style/perfil.png">
                                <p class="fotolabel">Foto</p>
                            </label>
                            <input type="file" class="notexist" name="foto" id="foto" accept="image/*">
                        </article>
                        <article class="col-lg-8 block">
                            <h3>Dados pessoais:</h3>
                            <div class="row blockchild">
                                <div class="col-md-6 campos">
                                    <input type="text" name="Nome" placeholder="Nome">
                                </div>
                                <div class="col-md-6 campos">
                                    <input type="text" name="Sobrenome" placeholder="Sobrenome">
                                </div>
                            </div>
                            <div class="row blockchild">
                                <div class="col-md-4 campos">
                                    <input type="number" name="Renda" id="renda" placeholder="Renda">
                                </div>
                                <div class="col-md-4 campos">
                                    <input type="text" name="beneficio" id="beneficio" placeholder="Número do Benefício">
                                </div>
                                <div class="col-md-4 campos">
                                    <select name="tipodebeneficio" id="tipodebeneficio">
                                        <option value="null" selected disabled>Tipo de Benefício</option>
                                        <?php
                                        $con = Consulta("SELECT * FROM beneficio;");
                                        foreach ($con as $dado) {
                                            echo '<option value="' . $dado['codigo'] . '">' . $dado['tipoBeneficio'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row blockchild">
                                <div class="col-md-6 campos">
                                    <input type="text" name="CPF" id="CPF" placeholder="CPF">
                                </div>
                                <div class="col-md-6 campos">
                                    <input type="text" name="RG" id="RG" placeholder="RG">
                                </div>
                            </div>
                            <div class="row blockchild">
                                <div class="col-md-4 campos">
                                    <select name="estadocivil" id="estadocivil">
                                        <option value="null" selected disabled>Estado Civil</option>
                                        <?php
                                        $con = Consulta('SELECT * FROM estadocivil;');
                                        foreach ($con as $dado) {
                                            echo '<option value="' . $dado['idestadocivil'] . '">' . $dado['estadocivil'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-6 campos">
                                    <select name="genero" id="genero">
                                        <option value="null" selected disabled>Gênero</option>
                                        <?php
                                        $con = Consulta('SELECT * FROM genero;');
                                        foreach ($con as $dado) {
                                            echo '<option value="' . $dado['idgenero'] . '">' . $dado['genero'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4 col-6 campos">
                                    <input type="text" id="Nascimento" name="Nascimento" placeholder="Nascimento" title="Data de nascimento">
                                </div>
                            </div>
                            <div class="row blockchild">
                                <div class="col-md-6 campos">
                                    <input type="text" name="Nacionalidade" placeholder="Nacionalidade">
                                </div>
                                <div class="col-md-6 campos">
                                    <input type="text" name="Naturalidade" placeholder="Naturalidade">
                                </div>
                            </div>
                            <div class="row blockchild">
                                <div class="col-md-6 campos">
                                    <input type="text" name="Pai" placeholder="Nome do Pai">
                                </div>
                                <div class="col-md-6 campos">
                                    <input type="text" name="Mae" placeholder="Nome da Mãe">
                                </div>
                            </div>
                        </article>
                    </section>
                    <section>
                        <h3>Endereço:</h3>
                        <article class="row">
                            <div class="col-lg-5 col-8">
                                <input type="text" name="Endereço" placeholder="Endereço">
                            </div>
                            <div class="col-lg-2 col-4">
                                <input type="number" name="Número" placeholder="Número">
                            </div>
                            <div class="col-lg-5">
                                <input type="text" name="Bairro" placeholder="Bairro">
                            </div>
                            <div class="col-lg-5">
                                <input type="text" name="CEP" id="CEP" placeholder="CEP">
                            </div>
                            <div class="col-lg-5 col-8">
                                <input type="text" name="Cidade" placeholder="Cidade">
                            </div>
                            <div class="col-lg-2 col-4">
                                <select name="UF">
                                    <option value="null" selected disabled>UF</option>
                                    <?php
                                    $con = Consulta('SELECT * FROM uf;');
                                    foreach ($con as $dado) {
                                        echo '<option value="' . $dado['idUF'] . '">' . $dado['siglaUF'] . '</option>';
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
                                <input type="text" name="Telefone" id="Telefone" placeholder="Telefone">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="Celular" id="Celular" placeholder="Celular">
                            </div>
                            <div>
                                <input type="email" name="email" placeholder="Email">
                            </div>
                        </article>
                        <h3>Dados Bancarios:</h3>
                        <article class="row">
                            <div class="col-md-6">
                                <input type="text" name="Banco" placeholder="Banco">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="Agencia" placeholder="Agencia">
                            </div>
                            <div class="col-md-6">
                                <select name="Tipodeconta">
                                    <option value="" selected disabled>Tipo de conta</option>
                                    <?php
                                    $con = Consulta('SELECT * FROM tiposdeconta;');
                                    foreach ($con as $dado) {
                                        echo '<option value="' . $dado['idtiposdeconta'] . '">' . $dado['tipo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="Conta" placeholder="Conta">
                            </div>
                        </article>
                        <h3>Anexos:</h3>
                        <article class="setanexos">
                            <div>
                                <label for="CN" class="setanexosimg">
                                    <img id="previewCN" src="style/file.png">
                                    <p class="fotolabel">CN</p>
                                </label>
                                <input type="file" class="notexist" name="CN" id="CN" accept="image/*, .pdf">
                            </div>
                            <div>
                                <label for="RGfile" class="setanexosimg">
                                    <img id="previewRG" src="style/file.png">
                                    <p class="fotolabel">RG</p>
                                </label>
                                <input type="file" class="notexist" name="RGfile" id="RGfile" accept="image/*, .pdf">
                            </div>
                            <div>
                                <label for="CNH" class="setanexosimg">
                                    <img id="previewCNH" src="style/file.png">
                                    <p class="fotolabel">CNH</p>
                                </label>
                                <input type="file" class="notexist" name="CNH" id="CNH" accept="image/*, .pdf">
                            </div>
                            <div>
                                <label for="CTPS" class="setanexosimg">
                                    <img id="previewCTPS" src="style/file.png">
                                    <p class="fotolabel">CTPS</p>
                                </label>
                                <input type="file" class="notexist" name="CTPS" id="CTPS" accept="image/*, .pdf">
                            </div>
                            <div>
                                <label for="CompEndereco" class="setanexosimg">
                                    <img id="previewCompEndereco" src="style/file.png">
                                    <p class="fotolabel">Comprovante Endereco</p>
                                </label>
                                <input type="file" class="notexist" name="CompEndereco" id="CompEndereco" accept="image/*, .pdf">
                            </div>
                        </article>
                    </section>
                    <div class="enviar" onclick="enviar('#cadastrar')">Cadastrar novo cliente</div>
                </form>
            </div>
        </div>
    </main>
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
    include('script.php');
    ?>
</body>

</html>