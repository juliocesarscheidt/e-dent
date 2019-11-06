<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Lista de Pacientes">
  <meta name="keyword" content="Web System, Odontologic System, Dentist">
  <title>Lista de Pacientes</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/main.css">
  <link rel="icon" type="image/png" href="images/icons/iconEdent.png"/>
</head>

<body>
  <?php
    include_once('connection.php');

    $search = isset ($_GET['search']) ? $_GET['search'] : '';
    // Sanitize query param
    $search = trim(htmlspecialchars(filter_var($search, FILTER_SANITIZE_STRING)));
  ?>
  <section id="container" class="">
    <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Menu lateral" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>
      <a class="navbar-brand" href="login.php">
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
                LISTA PACIENTES
              </header>
              <div class="panel-body">
                  <form method="get" action="">
                  <div class="">
                    <label for="" class="control-label col-lg-2">Pesquise o Paciente: <span class="required">*</span></label>
                      <div class="col-lg-6">
                        <input type="text" name="search" class="form-control" placeholder="Busque pelo nome, RG ou CPF" required autofocus value="<?= $search ? $search : ''; ?>">
                        <br>
                        <input class="btn btn-primary" type="submit" value="Pesquisar">
                      </div>
                  </div>
                  </form>
              </div>
              <div class="panel-body">
                <div class="col-lg-12">
                  <section class="panel">
                    <table class="table table-striped table-advance table-hover">
                      <tbody>
                        <tr>
                          <th><i class="icon_profile"></i> Nome</th>
                          <th><i class="icon_calendar"></i> D. Nascimento</th>
                          <th><i class="icon_mail_alt"></i> Email</th>
                          <th><i class="icon_pin_alt"></i> RG</th>
                          <th><i class="icon_pin_alt"></i> CPF</th>
                          <th><i class="icon_mobile"></i> Telefone</th>
                          <th><i class="icon_document_alt"></i> Prontuários</th>
                          <th><i class="icon_cogs"></i></th>
                        </tr>
                        <?php
                          // Build query
                          $fields = "pac.idPaciente,
                                      pac.nome,
                                      date_format(pac.data_nasc, '%d/%m/%Y') as data_nasc,
                                      pac.email,
                                      pac.rg,
                                      pac.cpf,
                                      pac.telefone";

                          $where_search = "WHERE
                                            pac.nome LIKE '%{$search}%' OR
                                            pac.cpf LIKE '%{$search}%' OR
                                            pac.rg LIKE '%{$search}%'";

                          // If there is a search in query param, use it
                          $where = $search ? $where_search : '';

                          $query = "SELECT
                                    {$fields},
                                    group_concat(ppo.fk_idProntuarioOdontologico) as idsProntuarios
                                  FROM
                                    paciente pac
                                  LEFT JOIN
                                    paciente_prontuario_odontologico ppo on ppo.fk_idPaciente = pac.idPaciente
                                  {$where}
                                  GROUP BY pac.idPaciente
                                  LIMIT 50";

                          $result = mysqli_query($conn, $query);

                          if ($result) {
                            while ($data = mysqli_fetch_array($result)) {
                              $prontuarios = explode(',', $data['idsProntuarios']);
                              $prontuarios_str = implode(' ', array_map(function($p) {
                                return "<a href=\"editar_prontuario_odontologico.php?id={$p}\">{$p}</a>";
                              }, $prontuarios));
                              ?>
                                <tr>
                                  <td><?= $data['nome']; ?></td>
                                  <td><?= $data['data_nasc']; ?></td>
                                  <td><?= $data['email']; ?></td>
                                  <td><?= $data['rg']; ?></td>
                                  <td><?= $data['cpf']; ?></td>
                                  <td><?= $data['telefone']; ?></td>
                                  <td><?= $prontuarios_str; ?></td>
                                  <td>
                                    <a class="link_edit" href="editar_paciente.php?id=<?= $data['idPaciente']; ?>">Editar</a>
                                  </td>
                                </tr>
                              <?php
                            }
                          }
                        ?>
                      </tbody>
                    </table>
                  </section>
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