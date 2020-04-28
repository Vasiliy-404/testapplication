<?
class Model_Auth extends Model
{
    public function getUserByLogin($login)
    {
        $db = new Data();
        return $db->getUserByLogin($login);
    }
}
?>