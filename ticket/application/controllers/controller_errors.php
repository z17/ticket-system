<?php
class Controller_Errors extends Controller
{
	function __construct()
    {
        $this->model = new Model_Errors();
        $this->view = new View();
    }
	
    function action_index()
    {	
	$data = $this->model->get_data();
		$data['user'] = $this -> model -> user;
        $this->view->generate('errors_view.php', 'template_view.php', $data);
    }
	function action_access()
    {	
		$data = $this->model->get_data();
		$data['user'] = $this -> model -> user;
        $this->view->generate('errors_access_view.php', 'template_view.php', $data);
    }
	function action_404()
    {	
		$data = $this->model->get_data();
		$data['user'] = $this -> model -> user;
        $this->view->generate('errors_404_view.php', 'template_view.php', $data);
    }
}