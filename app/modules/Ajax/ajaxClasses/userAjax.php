<?
class userAjax extends AJAX
{
    function __construct()
    {
        $this->model = new Model_Main();
    }

    function makeAjax($post)
    {
        $status = $post['status'];
        $photoID = $post['photo'];
        $this->model->updateStatus($status, $photoID);
        
        $result = array('status' => 'ok');
        $this->printJSON($result);
    }
}
?>