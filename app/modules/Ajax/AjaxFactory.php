<?
abstract class AJAX
{
	protected $user;

	public function __construct()
	{
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

	protected function printJSON($data)
	{
		header('Content-type: application/json; charset=utf-8');
		$res = json_encode($data);
		print_r($res);
	}
	
	abstract protected function makeAjax($post);
}

class AjaxFactory
{
    static private $path = PATH . '/app/modules/Ajax/ajaxClasses/';
    public $model;

    static private function getAjax($type)
    {
        switch ($type)
        {
            case 'user':
                self::requireAjax('userAjax');
                return new userAjax();
                break;
            case 'task':
                self::requireAjax('taskAjax');
                return new taskAjax();
                break;
            case 'auth':
                self::requireAjax('authAjax');
                return new authAjax();
                break;
            
            default:
                break;
        }
    }

    static private function requireAjax($name)
	{
		$path = self::$path;
        require_once($path . $name . '.php');
        
        $model_path = "app/models/model_" . $_POST['model'] . '.php';
        
		if(file_exists($model_path))
		{
			include $model_path;
		}
    }
    
    static function ajax()
	{
		if(isset($_POST['atype']))
		{
			$a = AjaxFactory::getAjax($_POST['atype']);
			if($a !== null)
			{
				$a->makeAjax($_POST);
			}
			die;
		}
		if(isset($_GET['atype']))
		{
			$a = AjaxFactory::getAjax($_GET['atype']);
			if($a !== null)
			{
				$a->makeAjax($_GET);
			}
			die;
		}
	}
}
?>