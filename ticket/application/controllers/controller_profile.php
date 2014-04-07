<?php
class Controller_Profile extends Controller
{

	function __construct()
    {
        $this->model = new Model_Profile();
        $this->view = new View();
    }
	
    function action_index()
    {	
		$data['user'] = $this -> model -> user;	
        $data = $this->model->get_data();
		$this->view->generate('profile_view.php', 'template_view.php', $data);

    }
	function action_edit()
    {		
		$data['user'] = $this -> model -> user;
        $data = $this->model->get_edit_data();
        $this->view->generate('profile_edit_view.php', 'template_view.php', $data);
    }

}