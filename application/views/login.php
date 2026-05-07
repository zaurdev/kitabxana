<div class="container">
  <div class="row justify-content-center align-items-center" style="min-height:100vh">
    <div class="col-lg-4 px-5 py-5">
      <h3 class="text-center mb-3">Kitabxana</h3>
      <p class="text-center mb-3 small text-secondary">Sənədləri görmək üçün zəhmət olmasa daxil olun. Sistemə daxil olmadan sənədlərə baxa bilməzsiniz. </p>
      <form action="" method="post" autocomplete="off">
        <label for="" class="form-label mb-3 d-block">
            <small class="d-block mb-2">E-poçt adresiniz</small>
            <input type="text" name="email" class="form-control w-full" name="" value="">
        </label>
        <label for="" class="form-label d-block mb-2">
            <small class="d-block mb-2">Şifrəniz</small>
            <input type="password" name="password" class="form-control w-full" name="" value="">
        </label>
        <button type="submit" class="btn-primary btn w-100 mt-4" name="button">Daxil ol</button>
      </form>
      <?php if($has_error):?>
      <div class="alert alert-danger" role="alert">
        <small><?=$error?></small>
      </div>
      <?php endif;?>
    </div>
  </div>
</div>
