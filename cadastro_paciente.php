<?php
  include_once('connection.php');

  if (!empty($_POST)) {
    if (empty($_POST['nome']) || empty($_POST['data_nasc']) || empty($_POST['telefone'])
      || empty($_POST['sexo']) || empty($_POST['estado_civil']) || empty($_POST['rg'])
      || empty($_POST['cpf']) || empty($_POST['endereco']) || empty($_POST['bairro'])
      || empty($_POST['cep']) || empty($_POST['cidade']) || empty($_POST['email'])) {
    ?>
      <script>
        alert("Todos os campos são obrigatorios");
      </script>
    <?php
      header("Refresh: 0; cadastro_paciente.php");
    } else {
      $nome = $_POST['nome'];
      $data_nasc = $_POST['data_nasc'];
      $telefone = $_POST['telefone'];
      $sexo = $_POST['sexo'];
      $estado_civil = $_POST['estado_civil'];
      $rg = $_POST['rg'];
      $cpf_paciente = $_POST['cpf'];
      $endereco = $_POST['endereco'];
      $bairro = $_POST['bairro'];
      $cep = $_POST['cep'];
      $cidade = $_POST['cidade'];
      $email = $_POST['email'];

      $query = mysqli_query($conn, "SELECT * FROM paciente WHERE cpf = '{$cpf_paciente}' ");

      $result = mysqli_fetch_array ($query);

      if ($result > 0) {
      ?>
        <script>
          alert("Paciente já cadastrado no sistema, reveja os dados!");
        </script>
      <?php

      header("Refresh: 0; cadastro_paciente.php");

      } else {
        $query = "INSERT INTO paciente
        (nome, data_nasc, telefone, sexo, estado_civil, rg, cpf, endereco, bairro, cep, cidade, email)
        VALUES
        ('{$nome}', '{$data_nasc}', '{$telefone}', '{$sexo}', '{$estado_civil}', '{$rg}', '{$cpf_paciente}', '{$endereco}', '{$bairro}', '{$cep}','{$cidade}','{$email}')";

        $result = mysqli_query($conn, $query);

        if ($result) {
          ?>
            <script>
              alert("Paciente cadastrado com sucesso no sistema!");
            </script>
          <?php
          header("Refresh: 0; lista_paciente.php");
        } else {
          ?>
            <script>
              alert("Erro ao cadastrar paciente!");
            </script>
          <?php
          header("Refresh: 0; index.php");
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Cadastro de Pacientes">
  <meta name="keyword" content="Web System, Odontologic System, Dentist">
  <title>Cadastro de Pacientes</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/main.css">
  <link rel="icon" type="image/png" href="images/icons/iconEdent.png"/>
</head>

<body>
  <section id="container" class="">
    <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>
      <a class="navbar-brand" href="#">
        <img src="images/icons/E-DENT-3.png" class="nav-item" alt="logo" style="width: 90px">
      </a>
    </header>

    <?php
      include('aside.php');
    ?>

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                CADASTRO DE PACIENTE
              </header>
              <div class="panel-body">
                <div class="form">
                  <form class="form-validate form-horizontal" id="register_form" method="post" action="">
                    <div class="form-group">
                      <label for="nome" class="control-label col-lg-2">Nome Completo<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="nome" name="nome" type="text" placeholder="Digite o Nome" required="required"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="data_nasc" class="control-label col-lg-2">Data de Nascimento<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="data_nasc" name="data_nasc" type="date" required="required" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="rg" class="control-label col-lg-2">RG<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="rg" name="rg" type="text" placeholder="123456789" required="required"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="cpf" class="control-label col-lg-2">CPF<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="cpf" name="cpf" placeholder="12345678910" type="text" required="required"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="telefone" class="control-label col-lg-2">Telefone<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="telefone" name="telefone" type="text" placeholder="(99)99999-9999" required="required"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email" class="control-label col-lg-2">Email<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" name="email" type="email" placeholder="email@dominio.com"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="sexo" class="control-label col-lg-2">Sexo<span class="required">*</span></label>
                        <div class="col-lg-10">
                              <select name = "sexo" class="form-control" required="required">
                                <option value="" selected>Selecionar</option>
                                <option value="f">Feminino</option>
                                <option value ="m">Masculino</option>
                              </select>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="estado_civil" class="control-label col-lg-2">Estado Civil<span class="required">*</span></label>
                        <div class="col-lg-10">
                              <select required="required" name ="estado_civil" class="form-control">
                                <option value="" selected>Selecionar</option>
                                <option value="s">Solteiro</option>
                                <option value="c">Casado</option>
                                <option value="d">Divorciado</option>
                              </select>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="cep" class="control-label col-lg-2">CEP<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="cep" name="cep" placeholder="Digite o CEP" type="text" required="required"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="endereco" class="control-label col-lg-2">Endereço Residencial<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="endereco" name="endereco" class="form-control" id="endereco" placeholder="Digite o Endereço" type="text" required="required" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="bairro" class="control-label col-lg-2">Bairro<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="bairro" name="bairro" class="form-control" id="" placeholder="Digite o Bairro" type="text" required="required" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="cidade" class="control-label col-lg-2">Cidade<span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="cidade" name="cidade" class="form-control" id="" placeholder="Digite a Cidade" type="text" required="required" />
                      </div>
                    </div>
                    <center>
                      <div>
                        <small id="" class="form-text text">
                          OBS: Antes de encerrar o cadastro verificar e com o auxilio do paciente verificar se todos os dados estão corretos.
                        </small>
                      </div>
                      <br>

                      <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                          <button class="btn btn-primary" type="submit" value="Cadastrar Paciente">Salvar</button>
                          <button class="btn btn-default" type="button">Cancelar</button>
                        </div>
                      </div>
                    </center>
                  </form>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
    </section>
  </section>

  <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
  <script src="js/jquery-ui-1.10.4.min.js"></script>
  <script src="js/jquery-1.8.3.min.js"></script>
  <script src="js/jquery.scrollTo.min.js"></script>
  <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="js/jquery.customSelect.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="js/scripts.js"></script>
</body>

</html>