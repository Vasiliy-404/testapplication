<?
class authAjax extends AJAX
{
    function __construct()
    {
        $this->model = new Model_Auth();
    }

    function makeAjax($post)
    {
        $action = $post['action'];
        switch ($action)
        {
            case 'check':
                $this->checkAuth($post);
                break;
            
            default:
                break;
        }
    }

    function checkAuth($post)
    {
        $result = false;

        $model = $this->model;
        $login = $post['login'];
        $key = $post['pass'];

        $pass = sha1($key . SALT);
        $user = $model->getUserByLogin($login);
        if($user)
        {
            if($user['pass_u'] === $pass)
            {
                $_SESSION['LOGIN'] = $login;
                $_SESSION['PASS'] = $pass;
                $_SESSION['IS_ADMIN'] = true;
                $result = true;
            }
        }
               
        $result = array('status' => 'ok', 'result' => $result);
        $this->printJSON($result);
    }
}
?>