<?php
class Controller_Logout extends Controller
{

	function __construct()
    {
        $this->model = new Model_Login();
        $this->view = new View();
    }
	
    function action_index()
    {		
        $data = $this->model->get_data();		
		$data['user'] = $this -> model -> user;
        $this->view->generate('logout_view.php', 'template_view.php', $data);
    }

}