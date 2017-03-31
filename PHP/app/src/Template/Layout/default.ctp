<?= $this->Html->docType() ?>
<html lang="pt-br">
  <head>
    <?= $this->Html->charset() ?>   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?></title>

    <!-- Bootstrap & JQuery -->
    <?= $this->Html->css('bootstrap.min') ?>
    <?= $this->Html->css('bootstrap-theme.min') ?>
    <?= $this->Html->script('jquery-3.2.0.min') ?>
    <?= $this->Html->script('bootstrap.min') ?>
   
  </head>
        
  <body>
        <script>
            <?= $this->fetch('script') ?>
        </script>
    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
          <?php if ($this->request->session()->read('Auth.User.name') != ""): ?>
              <li role="presentation" class="active">
              <img src="/PHP/app/upload/<?= $this->request->session()->read('Auth.User.picture') ?>" width="90" alt="sem imagem" class="thumbnail" />
              <a href="/PHP/app/logout">sair</a></li>
          <?php else: ?>
            <li role="presentation"><a href="/PHP/app/login">Login</a></li>
            <li role="presentation"><a href="/PHP/app/users/add">Cadastrar</a></li>
          <?php endif; ?>
          </ul>
        </nav>
        <h3 class="text-muted">Array Enterprise</h3>
      </div>

      <div class="jumbotron">
        <h1>Arrays Para Todos</h1>
        <p class="lead">
          Nós adorariamos saber sua opnião sobre nosso novo produto
        </p>
      </div>

      <div class="row marketing">
        <?= $this->fetch('content') ?>
        </div>
      </div>

      <footer class="footer">
        <p>&copy; 2016 Company, Inc.</p>
      </footer>

    </div> <!-- /container -->
  </body>
</html>
