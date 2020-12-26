<!-- Begin Page Content -->
<div class="container-fluid">




	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>


	<!-- buat flasher -->
	<?php if ($this->session->flashdata('flash')) { ?>


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

	<?= form_error('menu', "<div class= 'alert alert-danger' role='alert' >", "</div>") ?>


	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary mb-4 mt-4 " data-toggle="modal" data-target="#addMenu">
		ADD MENU
	</button>

	<!-- isi content -->


	<div class="col-md-6">
		<table class="table">

			<thead>
				<tr>
					<th>#</th>
					<th>Menu</th>
					<th>action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 0;
				foreach ($menu as $m) { ?>
					<tr>
						<td><?= ++$i ?></td>
						<td><?= $m['menu'] ?></td>
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
<div class="modal fade" id="addMenu" tabindex="-1" role="dialog" aria-labelledby="titleAddMenu" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titleAddMenu">Add Menu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<!-- buat form -->
			<form action="" method="post" enctype="multipart/form-data">
				<div class="modal-body">

					<div class="form-group">
						<input type="text" class="form-control" id="menu" name="menu" placeholder="input menu">
						<small class="form-text text-danger"><?= form_error('menu') ?></small>
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