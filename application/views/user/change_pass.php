
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

          <!-- isi content -->
          <br><br>

                  <!-- buat flasher -->
                    <?php if ($this->session->flashdata('flash')){ ?>
                       
                              <div class="alert alert-success alert-dismissible fade show col-sm-6" role="alert">
                                 <?= $this->session->flashdata('flash'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                  
                    <?php } ?>
                    <!--  -->


          <br>
          <div class="container">
          <div class="row">
          	<div class="col-sm-6">

          		<form action="" method="post">
          			
          			<div class="form-group">
			 			<label for="currentPass">Input your current password</label>
			    		<input type="password" class="form-control" id="currentPass" name="currentPass">
			    		<small  class="form-text text-danger"><?= form_error('currentPass') ?></small>
			 		</div>

			 		<div class="form-group">
			 			<label for="newPass">Input your new password</label>
			    		<input type="password" class="form-control" id="newPass"  name="newPass">
			    		<small  class="form-text text-danger"><?= form_error('newPass') ?></small>
			 		</div>

			 		<div class="form-group">
			 			<label for="newPass2">Input your new password again </label>
			    		<input type="password" class="form-control" id="newPass2"  name="newPass2">
			    		<small  class="form-text text-danger"><?= form_error('newPass2') ?></small>
			 		</div>

			 		<div class="form-group">
			 			<button type="submit" class="btn btn-primary">
			 				Change Password
			 			</button>
			 		</div>


          		</form>
          	</div>
          		
          	</div>
          </div>

                    

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
