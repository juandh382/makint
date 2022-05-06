<main class="col-9 ms-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrarse</h1>

    
  </div>
    <?php if (isset($_SESSION['register']) && $_SESSION['register'] == 'complete') : ?>
      <div class="alert alert-success" role="alert">
        Registro completado correctamente
      </div>
    <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
      <div class="alert alert-danger" role="alert">
        Registro fallido
      </div>
    <?php endif; ?>

    <?php Utils::deleteSession('register'); ?>


    <form action="<?=base_url?>/User/save" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" name="name" required>
      </div>
      <div class="mb-3">
        <label for="last_name" class="form-label">Apellidos</label>
        <input type="text" class="form-control" name="last_name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Correo Electronico</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</main>