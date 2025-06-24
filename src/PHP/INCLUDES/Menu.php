<header>
    <nav class="navbar navbar-expand-lg-2 text-center bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="/Index.php">Vida Serena</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/Index.php">Página principal</a>
            </li>
            <?php   
            if(isset($_SESSION["logado"]) and $_SESSION["logado"]){
            ?>
            <li class="nav-item">
              <a class="nav-link" href="/PHP/Logout.php">Logout</a>
            </li>
            <?php
            }else{
            ?>
            <li class="nav-item">
              <a class="nav-link" href="/PHP/Logar.php">Logar</a>
            </li>
            <?php
            }
            ?>
            <?php   
            if(isset($_SESSION['perfil']) and $_SESSION['perfil'] == "admin"){
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">Cadastros</a>
              <ul class="dropdown-menu text-center">
                <li><a class="dropdown-item" href="/PHP/CadastroUsuario.php">Novo Usuário</a></li>
                <li><a class="dropdown-item" href="/PHP/CadastroMedicamentos.php">Cadastro Medicamentos</a></li> -->
                <li>
                  <hr class="dropdown-divider" />
                </li> 
              </ul>
            </li> 
            <?php
            }
            ?>
            <li class="nav-item">
              <a class="nav-link" href="/HTML/Informacao.html">Sobre o sistema</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>