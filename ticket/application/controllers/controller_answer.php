<?php
class Controller_Answer extends Controller
{

	function __construct()
    {
        $this->model = new Model_Answer();
        $this->view = new View();
    }
	
    function action_index()
    {		
        $data = $this->model->get_data();
		$data['user'] = $this -> model -> user;
		$this->view->generate('answer_view.php', 'template_view.php', $data);
    }
	
	function action_default()
	{
	    $data = $this->model->get_user_data();
		$data['user'] = $this -> model -> user;
		$this->view->generate('answer_form_view.php', 'template_view.php', $data);
	}
}