<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    include('head.php');
    ?>
    <title>Credisim - consulta</title>
</head>

<body>
    <?php
    include('nav.php');
    ?>
    <main>
        <div class="corpo">
            <h1>Consultar</h1>
            <div class="accordion" id="accordionExample">
            <div class="dados">
                    <?php
                    include('config.php');
                    if (isset($_POST['CPF'])) {
                    ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Consultar
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                <?php
                            } else {
                                ?>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Consultar
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                <?php
                                            }
                                                ?>

                                                <form action="#" method="post" id="consultar">
                                                    <section>
                                                        <article class="block">
                                                            <h3>Dados:</h3>
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
                                                                        $con = Consulta('SELECT * FROM beneficio;');
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
                                                                <div class="col-md-6">
                                                                    <input type="text" name="Telefone" id="Telefone" placeholder="Telefone">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="Celular" id="Celular" placeholder="Celular">
                                                                </div>
                                                                <div>
                                                                    <input type="email" name="email" placeholder="Email">
                                                                </div>
                                                            </div>

                                                        </article>
                                                        <div class="enviar" onclick="enviar('#consultar')">Buscar</div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <section class="row  resultado">

                                    <?php
                                    function preparacpf($cpf)
                                    {
                                        $resposta = '';
                                        for ($i = 0; $i < strlen($cpf); $i++) {
                                            if ($cpf[$i] != '.' && $cpf[$i] != '-')
                                                $resposta .= $cpf[$i];
                                        }
                                        return $resposta;
                                    }

                                    if (isset($_POST['Nome'])) {
                                        $consulta2 = "SELECT 
                                        cliente.Nome,
                                        cliente.Sobrenome,
                                        cliente.CPF,
                                        cliente.RG,
                                        estadocivil.estadocivil,
                                        genero.genero,
                                        cliente.nascimento,
                                        cliente.fotinha,
                                        cliente.telefone
                                        FROM cliente
                                        LEFT JOIN estadocivil ON estadocivil.idestadocivil = cliente.estadocivil
                                        LEFT JOIN genero ON genero.idgenero = cliente.genero";

                                        if ($_POST['Nome'] != '') {
                                            $Nome = $_POST['Nome'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.Nome LIKE '$Nome'";
                                            } else {
                                                $consulta2 .= " AND cliente.Nome LIKE '$Nome'";
                                            }
                                        }

                                        if ($_POST['Sobrenome'] != '') {
                                            $Sobrenome = $_POST['Sobrenome'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.Sobrenome LIKE '$Sobrenome'";
                                            } else {
                                                $consulta2 .= " AND cliente.Sobrenome LIKE '$Sobrenome'";
                                            }
                                        }

                                        if (isset($_POST['tipodebeneficio'])) {
                                            if ($_POST['tipodebeneficio'] != '') {
                                                $tipodebeneficio = $_POST['tipodebeneficio'];
                                                if (strpos($consulta2, 'WHERE') == false) {
                                                    $consulta2 .= " WHERE cliente.tipobeneficio LIKE $tipodebeneficio";
                                                } else {
                                                    $consulta2 .= " AND cliente.tipobeneficio LIKE $tipodebeneficio";
                                                }
                                            }
                                        }

                                        if ($_POST['beneficio'] != '') {
                                            $beneficio = $_POST['beneficio'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.numerobeneficio LIKE '$beneficio'";
                                            } else {
                                                $consulta2 .= " AND cliente.numerobeneficio LIKE '$beneficio'";
                                            }
                                        }

                                        if ($_POST['Renda'] != '') {
                                            $Renda = $_POST['Renda'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.renda LIKE '$Renda'";
                                            } else {
                                                $consulta2 .= " AND cliente.renda LIKE '$Renda'";
                                            }
                                        }

                                        if ($_POST['CPF'] != '') {
                                            $CPF = $_POST['CPF'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.CPF LIKE '$CPF'";
                                            } else {
                                                $consulta2 .= " AND cliente.CPF LIKE '$CPF'";
                                            }
                                        }

                                        if ($_POST['RG'] != '') {
                                            $RG = $_POST['RG'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.RG LIKE '$RG'";
                                            } else {
                                                $consulta2 .= " AND cliente.RG LIKE '$RG'";
                                            }
                                        }

                                        if (isset($_POST['genero'])) {
                                            $genero = $_POST['genero'];
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.genero LIKE $genero";
                                            } else {
                                                $consulta2 .= " AND cliente.genero LIKE $genero";
                                            }
                                        }

                                        if (isset($_POST['estadocivil'])) {
                                            $estadocivil = $_POST['estadocivil'];
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.estadocivil LIKE $estadocivil";
                                            } else {
                                                $consulta2 .= " AND cliente.estadocivil LIKE $estadocivil";
                                            }
                                        }

                                        if ($_POST['Nascimento'] != '') {
                                            $Nascimento = $_POST['Nascimento'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.nascimento LIKE '$Nascimento'";
                                            } else {
                                                $consulta2 .= " AND cliente.nascimento LIKE '$Nascimento'";
                                            }
                                        }

                                        if ($_POST['Naturalidade'] != '') {
                                            $Naturalidade = $_POST['Naturalidade'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.naturalidade LIKE '$Naturalidade'";
                                            } else {
                                                $consulta2 .= " AND cliente.naturalidade LIKE '$Naturalidade'";
                                            }
                                        }

                                        if ($_POST['Nacionalidade'] != '') {
                                            $Nacionalidade = $_POST['Nacionalidade'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.nacionalidade LIKE '$Nacionalidade'";
                                            } else {
                                                $consulta2 .= " AND cliente.nacionalidade LIKE '$Nacionalidade'";
                                            }
                                        }

                                        if ($_POST['Pai'] != '') {
                                            $Pai = $_POST['Pai'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.pai LIKE '$Pai'";
                                            } else {
                                                $consulta2 .= " AND cliente.pai LIKE '$Pai'";
                                            }
                                        }

                                        if ($_POST['Mae'] != '') {
                                            $Mae = $_POST['Mae'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.mae LIKE '$Mae'";
                                            } else {
                                                $consulta2 .= " AND cliente.mae LIKE '$Mae'";
                                            }
                                        }


                                        if ($_POST['Telefone'] != '') {
                                            $Telefone = $_POST['Telefone'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.telefone LIKE '$Telefone'";
                                            } else {
                                                $consulta2 .= " AND cliente.telefone LIKE '$Telefone'";
                                            }
                                        }


                                        if ($_POST['Celular'] != '') {
                                            $Celular = $_POST['Celular'] . '%';
                                            if (strpos($consulta2, 'WHERE') == false) {
                                                $consulta2 .= " WHERE cliente.celular LIKE '$Celular'";
                                            } else {
                                                $consulta2 .= " AND cliente.celular LIKE '$Celular'";
                                            }
                                        }

                                        $consulta2 .= " ORDER BY cliente.Nome, cliente.Sobrenome;";

                                        $con2 = Consulta($consulta2);
                                        if (sizeof($con2) != 0) {
                                            foreach ($con2 as $dado) {
                                    ?>
                                                <article class="col-sm-6 col-xl-4">
                                                    <div class="row articlecard">
                                                        <div class="col-sm-3 articlecard-img" style="background-image: url(<?php

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
                                                                                                                                    ?>);">
                                                        </div>
                                                        <div class="col-sm-9 articlecard-body">
                                                            <div class="block">
                                                                <h4><?= $dado['Nome'] . ' ' . $dado['Sobrenome'] ?></h4>
                                                                <div class="row blockchild">
                                                                    <div class="col-lg-6"><b>CPF: </b><br><?= $dado['CPF'] ?></div>
                                                                    <div class="col-lg-6"><b>RG: </b><br><?= $dado['RG'] ?></div>
                                                                </div>
                                                                <div class="row blockchild">
                                                                    <div class="col-lg-6"><b>Estado Civil: </b><br><?= $dado['estadocivil'] ?></div>
                                                                    <div class="col-lg-6"><b>Gênero: </b><br><?= $dado['genero'] ?></div>
                                                                </div>
                                                                <div class="row blockchild">
                                                                    <div class="col-lg-6"><b>Nascimento: </b><br> <?= $dado['nascimento'] ?></div>
                                                                    <div class="col-lg-6"><b>Contato: </b><br><?= $dado['telefone'] ?></div>
                                                                </div>
                                                                <div class="row blockchild">
                                                                    <div class="col-lg-6"></div>
                                                                    <div class="col-lg-6 verficha">
                                                                        <form id="busca<?= preparacpf($dado['CPF']) ?>" method="POST" action="ficha.php">
                                                                            <input class="notexist" type="text" name="CPF" value="<?= $dado['CPF'] ?>">
                                                                            <button id="verfichabutton" onclick="enviar('#busca<?= preparacpf($dado['CPF']) ?>')" class="verfichabutton">Ver ficha completa</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                    <?php
                                            }
                                        } else {
                                            echo '<div class="atencao">Nada encontrado</div>';
                                        }
                                    }
                                    ?>
                                </section>
                            </div>
    </main>
    <?php
    include('script.php');
    ?>
</body>

</html>