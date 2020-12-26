
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

          <!-- isi content -->

          <?php echo form_open_multipart('user/edit');?>
          	
          	<div class="form-group row">
			    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
			    <div class="col-sm-10">
			      <input type="text" readonly class="form-control-plaintext" name="email" id="staticEmail" value="<?= $user['email'] ?>">
			    </div>
			</div>

			<div class="form-group row">
			    <label for="name" class="col-sm-2 col-form-label">nama</label>
			    <div class="col-sm-7">
			      <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
			    </div>
			</div>

			<div class="form-group row">
			    <label for="name" class="col-sm-2 col-form-label">image</label>

			    <div class="row">
			    	<div class="col-sm-3 " style="width: 300px; height: 200px">
			    		<img src="<?= base_url('assets/img/') . $user['image']; ?>" class="img-thumbnail" style= "">
			    	</div>
				    <div class="custom-file col-sm-7">
				      	
						  <input type="file" name="image" class="custom-file-input" id="customFile">
						  <label class="custom-file-label" for="customFile">Choose file</label>
						
				    </div>
			    </div>
			</div>

			<div class="form-group row">
			    <div class="col-sm-2"></div>
			    <div class="col-sm-6">
			      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
			    </div>
			</div>




          </form>

                    

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
