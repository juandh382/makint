<main class="col-9 ms-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Iniciar Sesión</h1>
  </div>
  <form action="<?=base_url?>/User/login" method="POST">
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