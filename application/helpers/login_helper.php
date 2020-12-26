<?php 

function is_logged_in(){

	//declare ci karena pada file helper tidak terhubung dengan codeigniter
	// jadi harus di instansiasi kan dulu

	$ci = get_instance();

	if (!$ci->session->userdata['email']){
		redirect('auth/login');
	}else {
		$roleId = $ci->session->userdata["role_id"];
		$menu = $ci->db->get_where('user_menu',['menu' => $ci->uri->segment(1)])->row_array();
		$menuId = $menu['id'];

		$queryAccess = $ci->db->get_where('user_access_menu', [
			'role_id' => $roleId,
			'menu_id' => $menuId
		])->num_rows();

		if ($queryAccess < 1){
			redirect('auth/blocked');
		}
		// querry access menu 

	}

}

function is_access($roleId, $menuId){

	$ci = get_instance();

	$result = $ci->db->get_where('user_access_menu', [
		'role_id' => $roleId,
		'menu_id' => $menuId

	]);

	if ($result->num_rows() > 0){
		return 'checked=""';
	}
}


 ?>