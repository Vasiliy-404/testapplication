<?
class Controller
{
	public $model;
	public $view;
	protected $user;
	
	function __construct()
	{
		$this->view = new View();

		$login = $_SESSION['LOGIN'];
		$pass = $_SESSION['PASS'];
		$db = new Data();
		$user = $db->getUserByLogin($login);
        if($user)
        {
			$user = (array)$user;
            if($user['pass_u'] === $pass)
            {
				unset($user['queryString'], $user['pass_u']);
                $this->user = $user;
            }
        }
	}
	
	function action_index()
	{

	}

	function notFound()
	{
		$this->view->generate('404.php', 'template_404.php');
	}
}
?>