<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img src="/images/hamburger.svg" width="30" height="30" alt="">
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Início <span class="sr-only">(current)</span></a>
      </li>
    </ul>

    <form class="form-inline m-auto" style="width: 80%">
      <input class="form-control mr-sm-2" style="width: 80%" type="search" placeholder="Buscar produtos" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>

    <?php if (!isset($user) || !$user): ?>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="/user/login">Entrar</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="/user/register">Cadastrar</a>
        </li>
      </ul>
    <?php endif; ?>

    <?php if (isset($user) && $user): ?>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="/user/logout">Sair</a>
        </li>
      </ul>
    <?php endif; ?>

  </div>
</nav>