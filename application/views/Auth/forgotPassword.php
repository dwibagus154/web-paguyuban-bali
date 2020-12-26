  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block makebg"></div>
              <div class="col-lg-6"> 
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Forgot Password</h1>

                    <!-- buat flasher -->
                    <?php if ($this->session->flashdata('flash')){ ?>
                       
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                 <?= $this->session->flashdata('flash'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                  
                    <?php } ?>
                    <!--  -->

                    <br><br>
                  </div>
                  <form class="user" method="post" action="<?= base_url('auth/forgotPassword') ?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="input your current email" value="<?= set_value('email') ?>">
                      <?php echo form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    
                    <br><br><br><br>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Create New Password
                    </button>
                    <hr>
                   
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= base_url("auth/login") ?>">Remember your Password, back to login</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= base_url("auth/registration") ?>">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

