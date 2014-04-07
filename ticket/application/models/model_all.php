<?php
class Model_All extends Model
{
    public function get_data()
    {		
		
		if (!isset($_SESSION['userid']))
		{
			Route::ErrorAccess();
		}
		$id = $this -> user['id'];
		$data['posts'] = $this -> base -> getTicketsUsers($id);
		$data['message'] = '<h2>Мои вопросы</h2><p>Отсортированы в хронологическом порядке (последние снизу)</p>';
		
		$data['title'] = 'Мои вопросы';
		return $data;
    }
}