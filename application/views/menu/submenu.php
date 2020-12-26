
        <!-- Begin Page Content -->
        <div class="container-fluid">




          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>


<!-- buat flasher -->
<?php if ($this->session->flashdata('flash')){ ?>
	
				
				<div class="col-md-10">

					
					<div class="alert alert-success alert-dismissible fade show" role="alert">
					  data <strong>berhasil </strong> <?= $this->session->flashdata('flash'); ?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>

				</div>

			
<?php } ?>

<!-- form error -->
				
<?= form_error('menuId', "<div class= 'alert alert-danger' role='alert' >", "</div>") ?>
<?= form_error('title', "<div class= 'alert alert-danger' role='alert' >", "</div>") ?>
<?= form_error('url', "<div class= 'alert alert-danger' role='alert' >", "</div>") ?>
<?= form_error('icon', "<div class= 'alert alert-danger' role='alert' >", "</div>") ?>
					  

          <!-- Button trigger modal -->
			<button type="button" class="btn btn-primary mb-4 mt-4 " data-toggle="modal" data-target="#addSubMenu">
				  ADD SUB MENU  
			</button>

          <!-- isi content -->

		     
				<div class="col-md-10">
					<table class="table">

						<thead>
							<tr>
								<th>#</th>
								<th>Menu</th>
								<th>title</th>
								<th>url</th>
								<th>icon</th>
								<th>active</th>
								<td>action</td>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 0;
							foreach ($submenu as $sm ) { ?>
							<tr>
								<td><?= ++$i ?></td>
								<td><?= $sm['menu'] ?></td>
								<td><?= $sm['title'] ?></td>
								<td><?= $sm['url'] ?></td>
								<td><?= $sm['icon'] ?></td>
								<td><?= $sm['is_active'] ?></td>
								<td>
									<a href="" class="badge badge-danger">delete</a>
									<a href="" class="badge badge-success">edit</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					
					



				</div>

                    

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="addSubMenu" tabindex="-1" role="dialog" aria-labelledby="titleAddSubMenu" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleAddSubMenu">Add Sub Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- buat form -->
      <form  action="" method="post" enctype="multipart/form-data">
      <div class="modal-body">
<!-- 
 		<div class="form-group">
 			<label for="menuId">Menu_id</label>
    		<input type="text" class="form-control" id="menuId"  name="menuId" placeholder="input menu id">
    		<small  class="form-text text-danger"><?= form_error('menuId') ?></small>
 		</div> -->
 		<div class="form-group">
 			<label for="title">title</label>
    		<input type="text" class="form-control" id="title"  name="title" placeholder="input title">
    		<small  class="form-text text-danger"><?= form_error('title') ?></small>
 		</div>
 		<div class="form-group">
 			<select class="form-control" name="menu_id" id="menu_id">
 				 <option value="">Select Menu</option>
 				<?php foreach ($menu as $m) {?>
			 	 <option value="<?= $m['id'] ?> " name= ""><?= $m["menu"] ?></option>
				<?php } ?>
			</select>
 		</div>

 		<div class="form-group">
 			<label for="url">url</label>
    		<input type="text" class="form-control" id="url"  name="url" placeholder="input url">
    		<small  class="form-text text-danger"><?= form_error('url') ?></small>
 		</div>
 		<div class="form-group">
 			<label for="icon">icon</label>
    		<input type="text" class="form-control" id="icon"  name="icon" placeholder="input icon">
    		<small  class="form-text text-danger"><?= form_error('icon') ?></small>
 		</div>
		<div class="form-check">
		  <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked="" >
		  <label class="form-check-label" for="is_active">
		    is_active
		  </label>
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Add Menu</button>
      </div>
      </form>

    </div>
  </div>
</div>
