<?php require('./components/header.php'); ?>
<?php if(isset($_SESSION['isLogged']) && $_SESSION['isLogged']) header("Location: ./"); ?>
<section class="vh-100 full-page" >
  <div class="container py-2 ">
    <div class="row d-flex justify-content-center align-items-center h-100" style="">
      <div class="col col-xl-5">
        <div class="card" style="border-radius: 1rem;  ">
          <div class="row g-0">
            <div class="col-md-12 col-lg-12 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <form method="post" onsubmit="return loginUser(this)">
                  <h4 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login</h4>

                  <div class="form-outline mb-4" style="position: relative; display:flex; align-items: center;">
                    <i class="bi bi-person" style=" position: absolute; z-index: 999; color:#ccc; font-size: 1.5em; margin-left:10px;"></i>
                    <input type="text" id="username" class="form-control form-control-lg" onautocomplete="off" placeholder="Username or email" style="padding:10px; padding-left: 40px; " />
                    
                    <label class="form-label" for="username"><span class="form-error">Errors here</span> </label>
                  </div>

                  <div class="form-outline mb-4" style="position: relative; display:flex; align-items: center;">
                    <i class="bi bi-lock" style=" position: absolute; z-index: 999; color:#ccc; font-size: 1.5em; margin-left:10px;"></i>
                    <input type="password" id="password" class="form-control form-control-lg" placeholder="Password" style="padding:10px; padding-left: 40px; " />
                    <i class="bi bi-eye-slash" style=" position: absolute; z-index: 999; color:#ccc; font-size: 1.5em; margin-right:10px; right: 0px; cursor: pointer;" id="showPassword"></i>
                    <label class="form-label" for="password"> <span class="form-error">Errors here</span></label>
                  </div>

                  <div class="pt-1 mb-4">
                    <button type="submit" class="btn  btn-lg btn-primary" type="button" style="width: 100%;">Login</button>
                  </div>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require('./components/footer.php'); ?>

<style>
  .full-page {
    background: rgb(67,60,195);
    background: linear-gradient(90deg, rgba(67,60,195,1) 0%, rgba(3,3,153,1) 61%, rgba(15,138,163,1) 100%);
    height: 100vh;
    display: flex;
  }
</style>

<script>
  $('#showPassword').on('click', (e) => {
    let div = $(e.target).parents('.form-outline');
    let eye = $(e.target);
    if($(eye).hasClass('bi-eye-slash')) {
      $(div).find('input').attr('type', 'text');
      $(eye).toggleClass('bi-eye-slash')
      $(eye).toggleClass('bi-eye')
    } else {
      $(div).find('input').attr('type', 'password');
      $(eye).toggleClass('bi-eye')
      $(eye).toggleClass('bi-eye-slash')
    }
    
  })
</script>