<?
class Model_Main extends Model
{
	public $lastTaskLimit = 3;
	public $userGroupID = 2;

	public function getLastTasks($page)
	{
		$db = new Data();
		$lastTasks = $db->getLastTasks($this->lastTaskLimit, $this->lastTaskLimit * ($page - 1));
		return $lastTasks;
	}

	public function saveTask($data)
	{
		$db = new Data();
		$data['group_id'] = $this->userGroupID;
		$newUserID = $db->addUser($data);
		return $newUserID;
	}

	public function addTask($dataTask)
	{
		$db = new Data();
        $db->addTask($dataTask);
	}

	public function getCountAllTasks()
	{
		$db = new Data();
        return $db->getCountAllTasks();
	}

	public function updateTaskStatus($taskID, $status)
	{
		$db = new Data();
		$db->updateTaskStatus($taskID, $status);
	}

	public function updateTaskText($taskID, $text)
	{
		$db = new Data();
		$db->updateTaskText($taskID, $text);
	}

	public function getLastTasksBySort($page, $sortField, $sortUD)
	{
		$db = new Data();
		switch ($sortField)
		{
			case 'name':
				$sortFieldValue = 'users.name_u';
				break;
			case 'email':
				$sortFieldValue = 'users.email_u';
				break;
			case 'status':
				$sortFieldValue = 'tasks.status_t';
				break;
			
			default:
				$sortFieldValue = 'tasks.id_t';
				break;
		}
		$sortUDValue = $sortUD == 'up' ? 'ASC' : 'DESC';
		$lastTasks = $db->getLastTasksBySort($this->lastTaskLimit, $this->lastTaskLimit * ($page - 1), $sortFieldValue, $sortUDValue);
		return $lastTasks;
	}
}
?>