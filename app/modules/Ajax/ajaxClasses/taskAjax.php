<?
class taskAjax extends AJAX
{
    function __construct()
    {
        $this->model = new Model_Main();
        parent::__construct();
    }

    function makeAjax($post)
    {
        $action = $post['action'];
        switch ($action)
        {
            case 'save':
                $this->saveTask($post);
                break;
            case 'get-last':
                $this->getLastTasks($post);
                break;
            case 'get-count-all':
                $this->getCountAllTasks($post);
                break;
            case 'change-status':
                $this->changeStatus($post);
                break;
            case 'change-text':
                $this->changeText($post);
                break;
            case 'get-by-sort':
                $this->getBySort($post);
                break;
            
            default:
                break;
        }
    }

    function getBySort($post)
    {
        $page = $post['page'];
        $sortField = $post['sort_field'];
        $sortUD = $post['sort_ud'];
        $model = $this->model;
        $lastTasks = $model->getLastTasksBySort($page, $sortField, $sortUD);        
        $result = array('status' => 'ok', 'result' => $lastTasks);
        $this->printJSON($result);
    }

    function changeText($post)
    {
        $user = $this->user;
        if($user && $user['group_u'] === 1)
        {
            $taskID = $post['task_id'];
            $text = $post['text'];
            $model = $this->model;
            $model->updateTaskText($taskID, $text);
            $result = array('status' => 'ok', 'result' => $taskID);
            $this->printJSON($result);
        }
        else
        {
            $result = array('status' => 'error', 'description' => 'Вы не можете выполнить это действие, пожалуйста, авторизуйтесь на странице авторизации.');
            $this->printJSON($result);
        }        
    }

    function changeStatus($post)
    {
        $user = $this->user;
        if($user && $user['group_u'] === 1)
        {
            $taskID = $post['task_id'];
            $status = $post['status'];
            $model = $this->model;
            $model->updateTaskStatus($taskID, $status);
            $result = array('status' => 'ok', 'result' => $taskID);
            $this->printJSON($result);
        }
        else
        {
            $result = array('status' => 'error', 'description' => 'Вы не можете выполнить это действие, пожалуйста, авторизуйтесь на странице авторизации.');
            $this->printJSON($result);
        }        
    }

    function saveTask($post)
    {
        foreach($post as $p)
        {
            if(trim($p) == '')
            {
                $result = array('status' => 'error', 'description' => 'Не все данные введены');
                $this->printJSON($result);
                die;
            }
        }
        $model = $this->model;

        $data['name'] = $post['name'];
        $data['email'] = $post['email'];
        $newUserID = $model->saveTask($data);

        $dataTask['user_id'] = $newUserID;
        $dataTask['text'] = $post['text'];
        $model->addTask($dataTask);
        
        $result = array('status' => 'ok', 'id' => $newUserID);
        $this->printJSON($result);
    }

    function getLastTasks($post)
    {
        $page = $post['page'];
        $model = $this->model;
        $lastTasks = $model->getLastTasks($page);        
        $result = array('status' => 'ok', 'result' => $lastTasks);
        $this->printJSON($result);
    }

    function getCountAllTasks($post)
    {
        $model = $this->model;
        $lastTasks = $model->getCountAllTasks();        
        $result = array('status' => 'ok', 'result' => $lastTasks);
        $this->printJSON($result);
    }
}
?>