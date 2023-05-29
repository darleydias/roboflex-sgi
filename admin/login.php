<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="pt-BR" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page dark-mode">
  
  <script>
    start_loader()
  </script>

  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
      text-shadow: 2px 2px black
    }

    .bg-login{
      background: #05346A;
    }

  </style>
<div>
<div class="col-3 mx-auto">
<img src="../admin/logoroboflex.png" class="img-fluid" alt="Responsive image">
</div><br><br>
  <div class="text-center" style="font-size: 25px;">
    SGI<br>Sistema de Gestão de Informações
    </div>
    </div>
    <br><br>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
  
    <div class="card-body bg-login">
      <p class="login-box-msg">Insira seus dados para iniciar a sessão</p>

      <form id="login-frm" action="" method="post">
        <div class="input-group mb-3">
          <input type="text" style="background-color: #05346A;" class="form-control" autofocus name="username" placeholder="Usuário" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text" style="background-color: #05346A;">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" style="background-color: #05346A;" class="form-control" name="password" placeholder="Senha">
          <div class="input-group-append">
            <div class="input-group-text" style="background-color: #05346A;">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->



<script>
  $(document).ready(function(){
    end_loader();
  })
</script>
</body>
</html>