<?php
class Model_Order extends Model
{
    public function get_data()
    {	
		$data['date'] = isset($_POST['date']) ? $_POST['date'] : NULL;
		$data['task'] = isset($_POST['task']) ? $_POST['task'] : NULL;		
		$data['itemId'] = isset($_POST['itemId']) ? $_POST['itemId'] : NULL;
		$data['fl'] = isset($_POST['fl']) ? $_POST['fl'] : false;

		// нужно допилить вывод суммы заказа (вероятно на js)
		// сильно много условий, нужно будет что-то сделать
		// вообще тут слишком много кода, и по-моему всё это бред
		
		// + проверка размеров изображения и кучу ещё всего нужно сделать, но влом
		
		if ($data['fl']) 
		{			
			$data['errors'] = array();
			
			$correctDate = false;		// флаг корректности даты
			if ($data['date'] == NULL)
			{
				$str = "Не указана дата";
				array_push($data['errors'],$str);
			}
			else
			{
				$currentDate = date("Y-m-d");
				$validDate =  strtotime("$currentDate + 3 day");		// допустимая дата выполнения заказа: день заказа + 3 дня
				$validDate = date("Y-m-d", $validDate);
				$data['date'] = explode("-",$data['date']);
				$data['date'] = $data['date'][2]."-".$data['date'][1]."-".$data['date'][0]; // формирование даты в нужное представление для базы
				
				if ((strtotime($currentDate) > strtotime($data['date'])) or (!preg_match("/\d\d\d\d-\d\d-\d\d/",$data['date'])))
				{
					$str = 'Некорректная дата';
					array_push($data['errors'],$str);
				}
				elseif (strtotime($validDate) > strtotime($data['date']))		// проверка срока сдачи заказа
				{
					$str = 'Ранний срок выполнения заказа ' . date("d-m-Y", strtotime($validDate));
					array_push($data['errors'],$str);
				}
				else
				{
					$correctDate = true;
				}
			}
			if ($data['itemId'] == NULL)
			{
				$str = "Не выбран предмет";
				array_push($data['errors'],$str);
			}
			elseif ($correctDate)
			{
				$price = $this -> base -> getPrice($data['itemId']);
				$diffDate = strtotime($data['date']) - strtotime($currentDate + "1 day");	// считаем сколько дней до даты сдачи заказа не включая сегодня
				$diffDate = (int)date("d", $diffDate);
				// рассчёт стоимости относительно базовой (базовая - за срок 5 дней)
				switch($correctDate) {
					case 3: 
						$price = $price * 1.6;
						break;
					case 4: 
						$price = $price * 1.4;
						break;
					case 5: 
						$price = $price;
						break;
					default:
						$price = $price * 0.8;
				}
				if ($price > $this -> user['balance'])
					{
						$str = "На ващем счету недостаточно средств, <a href=\"/pay\" title=\"Пополнить счёт\">пополнить</a>";
						array_push($data['errors'],$str);
					}
								
			}
			$i = 0;	// счётчик номера файла
			$filesName = array(); 
			foreach ($_FILES as $name => $file )
			{
				$i++;
				if (!empty($file['name']))
				{
					$url = explode('.', $file['name']);
					$format = array_pop($url);					
					if ((strtolower($format) != 'jpg') and (strtolower($format) != 'gif') and (strtolower($format) != 'png'))
					{
						$str = "Недопустимый формат файла ".$i;						
						array_push($data['errors'],$str);
					}
					else
					{
						array_push($filesName,array('tmp_name' => $file['tmp_name'],'name'=>$name, 'url'=>$url, 'format'=>$format));	// записываем подходящие к загрузке файлы
					}
				}
			}
		
			
			if (empty($data['errors']))
			{
				// перемещаем файлы	
				$files = array(NULL,NULL,NULL);
				$i = 0; 		// счётчик
				foreach ($filesName as $file)
				{		
					$name = md5(implode($file['url']));		// создаём уникальное имя (нужно будет добавить ещё ID task)
					$files[$i] = $_SERVER['DOCUMENT_ROOT']."/files/".$name.".".$file['format'];
					move_uploaded_file($file['tmp_name'], $files[$i]);
					// получаем url файла для записи в базу
					$files[$i] = substr($files[$i],strlen($_SERVER['DOCUMENT_ROOT']),strlen($files[$i]) - strlen($_SERVER['DOCUMENT_ROOT']));
					$i++;					
				}
				$this -> base -> addTask($this->user['id'],$data['itemId'],$data['date'],$data['task'],$files[0],$files[1],$files[2],$price);				
			}			
		}
		else
		{
		}
		
		$data['items'] = $this -> base -> getItems();
		$data['navkac'] = 'order';
		$data['title'] = "Оформление заказа";
		return $data;

    }
}