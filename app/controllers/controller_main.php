<?
class Controller_Main extends Controller
{
    function __construct()
	{
		$this->model = new Model_Main();
		$this->view = new View();
		parent::__construct();
    }
    
	function action_index()
	{
		$data = [];
		$user = $this->user;
		if($user && $user['group_u'] === 1)
		{
			$data['isAdmin'] = true;
		}
        $model = $this->model;

        $lastTasks = $model->getLastTasks(1);
        
        $data['tasks'] = $lastTasks;

		$this->view->generate('home.php', 'template_main.php', $data);
	}
}
?>