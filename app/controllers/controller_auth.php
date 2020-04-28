<?
class Controller_Auth extends Controller
{
    function __construct()
	{
		$this->model = new Model_Auth();
        $this->view = new View();
        parent::__construct();
    }
    
	function action_index()
	{
        $model = $this->model;
        $user = $this->user;
        if($user)
        {
            header('Location: /');
            die;
        }

		$this->view->generate('auth.php', 'template_auth.php', []);
	}
}
?>