<?php
class Controller_Register extends Controller
{

	function __construct()
    {
        $this->model = new Model_Register();
        $this->view = new View();
    }
	
    function action_index()
    {		
        $data = $this->model->get_data();
		$data['user'] = $this -> model -> user;
        $this->view->generate('register_view.php', 'template_view.php', $data);
    }
}