<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous" />
  <link rel="stylesheet" href="/CSS/Informacao.css
  ">
  <title>Informações</title>
</head>

<body>
  <?php
require $_SERVER['DOCUMENT_ROOT'] . "/PHP/INCLUDES/Menu.php";
?>

  <main class="container mt-4">
    <section class="about mt-5 text-start">
      <h4 class="text-primary">Sobre o sistema Vida Serena</h4>
      <p>
        O sistema Vida Serena foi desenvolvido para proporcionar um cuidado
        completo e digno aos idosos em lares especializados. Com um
        acompanhamento contínuo, oferece uma solução eficiente para a gestão
        de profissionais da saúde, incluindo médicos, enfermeiros e
        cuidadores, garantindo assistência humanizada e personalizada.
      </p>

      <ul>
        <li>
          <strong>Gerenciamento de profissionais:</strong> registros de
          atendimento e comunicação direta entre médicos, enfermeiros e
          cuidadores para garantir a continuidade do cuidado.
        </li>
        <li>
          <strong>Monitoramento da saúde:</strong> acompanhamento em tempo
          real do estado de saúde do idoso, incluindo exames, histórico médico
          e administração de medicamentos.
        </li>
        <li>
          <strong>Gestão de medicamentos e exames:</strong> controle preciso
          da medicação, com alerta para horários e necessidade de reposição,
          além de agendamentos automáticos para exames essenciais.
        </li>
        <li>
          <strong>Interação familiar:</strong> canal de comunicação entre o
          lar de idosos e os familiares, permitindo acesso às informações
          sobre qualidade de vida, bem-estar e evolução da saúde do idoso.
        </li>
      </ul>

      <p>
        Com tecnologia avançada e um sistema intuitivo, Vida Serena
        proporciona confiança e segurança, garantindo que os idosos recebam o
        melhor cuidado possível, enquanto seus familiares acompanham cada
        etapa do processo.
      </p>
    </section>

    <div class="div-button d-flex justify-content-center">
      <a type="button" class="btn btn-outline-warning" href="/Index.php">Voltar</a>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"></script>
</body>

</html>