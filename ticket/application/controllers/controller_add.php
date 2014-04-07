<?php
class Controller_Add extends Controller
{

	function __construct()
    {
        $this->model = new Model_Add();
        $this->view = new View();
    }
	
    function action_index()
    {		
        $data = $this->model->get_data();
		$data['user'] = $this -> model -> user;
		$this->view->generate('add_view.php', 'template_view.php', $data);
    }
}