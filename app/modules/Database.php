<?

class Data
{    
    private $db;
    public function __construct()
    {
        $this->db = DB::DataBase();
    }

    ################################################
    #################### TASKS #####################
    ################################################

    function getLastTasks($limit, $offset)
    {
        $db = $this->db;
        $query = "SELECT users.name_u, users.email_u, tasks.text_t, tasks.id_t, tasks.status_t, tasks.is_edit_t FROM tasks INNER JOIN users ON tasks.user_id_t = users.id_u ORDER BY id_t DESC LIMIT :limit OFFSET :offset;";
        $sth = $db->prepare($query);
        $sth->bindValue(':limit', $limit, PDO::PARAM_INT);
        $sth->bindValue(':offset', $offset, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    function getLastTasksBySort($limit, $offset, $sortField, $sortUD)
    {
        $db = $this->db;
        $query = "SELECT users.name_u, users.email_u, tasks.text_t, tasks.id_t, tasks.status_t, tasks.is_edit_t FROM tasks LEFT JOIN users ON tasks.user_id_t = users.id_u ORDER BY {$sortField} {$sortUD} LIMIT :limit OFFSET :offset;";
        $sth = $db->prepare($query);
        $sth->bindValue(':limit', $limit, PDO::PARAM_INT);
        $sth->bindValue(':offset', $offset, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    function addTask($data)
    {
        $db = $this->db;
        $query = "INSERT INTO tasks (user_id_t, text_t) VALUES(:user_id, :text);";
        $sth = $db->prepare($query);
        $sth->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
        $sth->bindValue(':text', $data['text'], PDO::PARAM_STR);
        $sth->execute();
        return $db->lastInsertId();
    }

    function getCountAllTasks()
    {
        $db = $this->db;
        $query = "SELECT COUNT(*) as 'count' FROM tasks;";
        $sth = $db->prepare($query);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }

    public function updateTaskStatus($taskID, $status)
    {
        $db = $this->db;
        $query = "UPDATE tasks SET status_t = :status WHERE id_t = :taskID;";
        $sth = $db->prepare($query);
        $sth->bindValue(':taskID', $taskID, PDO::PARAM_INT);
        $sth->bindValue(':status', $status, PDO::PARAM_INT);
        $sth->execute();
    }

    public function updateTaskText($taskID, $text)
    {
        $db = $this->db;
        $query = "UPDATE tasks SET text_t = :text, is_edit_t = 'Y' WHERE id_t = :taskID;";
        $sth = $db->prepare($query);
        $sth->bindValue(':taskID', $taskID, PDO::PARAM_INT);
        $sth->bindValue(':text', $text, PDO::PARAM_STR);
        $sth->execute();
    }

    ################################################
    #################### USERS #####################
    ################################################

    public function addUser($data)
    {
        $db = $this->db;
        $query = "INSERT INTO users (group_u, name_u, email_u) VALUES(:group_id, :name, :email);";
        $sth = $db->prepare($query);
        $sth->bindValue(":group_id", $data['group_id'], PDO::PARAM_INT);
        $sth->bindValue(":name", $data['name'], PDO::PARAM_STR);
        $sth->bindValue(":email", $data['email'], PDO::PARAM_STR);
        $sth->execute();
        return $db->lastInsertId();
    }

    public function getUserByLogin($login)
    {
        $group = 1;
        $db = $this->db;
        $query = "SELECT * FROM users WHERE login_u = :login AND group_u = :group;";
        $sth = $db->prepare($query);
        $sth->bindValue(":login", $login, PDO::PARAM_STR);
        $sth->bindValue(":group", $group, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }




























    public function getAllUsers()
    {
        $db = $this->db;
        $query = "SELECT * FROM users;";
        $sth = $db->prepare($query);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getUserByID($uid)
    {
        $db = $this->db;
        $query = "SELECT * FROM users WHERE users.id_u = :uid;";
        $sth = $db->prepare($query);
        $sth->bindValue(':uid', $uid, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }

    public function getUserByIP($ip)
    {
        $db = $this->db;
        $query = "SELECT * FROM users WHERE users.ip_u = :ip;";
        $sth = $db->prepare($query);
        $sth->bindValue(':ip', $ip, PDO::PARAM_STR);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }

    
    
    ################################################
    ################### PERSONS ####################
    ################################################

    public function getPersonByID($id)
    {
        $db = $this->db;
        $query = "SELECT * FROM persons WHERE persons.id_p = :id;";
        $sth = $db->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }

    ################################################
    ################### AVATARS ####################
    ################################################

    public function getAvatarByPersonID($id)
    {
        $db = $this->db;
        $query = "SELECT * FROM avatars WHERE id_p = :id;";
        $sth = $db->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }

    ################################################
    ################### PHOTOS ####################
    ################################################

    public function getPhotosByPersonID($id)
    {
        $db = $this->db;
        $query = "SELECT * FROM photos WHERE person_id_ph = :id;";
        $sth = $db->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getPhotoByPhotoID($id)
    {
        $db = $this->db;
        $query = "SELECT * FROM photos WHERE id_ph = :id;";
        $sth = $db->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }

    ################################################
    ################## PHOTOLIKE ###################
    ################################################

    public function getPhotosFavoriteByUserID_PersonID($uid, $pid)
    {
        $db = $this->db;
        $query = "SELECT photo_id_pl FROM photolike WHERE user_id_pl = :uid AND person_id_pl = :pid AND is_like_pl = 'Y';";
        $sth = $db->prepare($query);
        $sth->bindValue(':uid', $uid, PDO::PARAM_INT);
        $sth->bindValue(':pid', $pid, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getCountLikesByPhotoID($id)
    {
        $db = $this->db;
        $query = "SELECT COUNT(*) as count_row FROM photolike WHERE photo_id_pl = :id AND is_like_pl = 'Y';";
        $sth = $db->prepare($query);
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }

    public function getLikeByUserID_PhotoID($uid, $phid)
    {
        $db = $this->db;
        $query = "SELECT id_pl, is_like_pl FROM photolike WHERE user_id_pl = :uid AND photo_id_pl = :phid;";
        $sth = $db->prepare($query);
        $sth->bindValue(':uid', $uid, PDO::PARAM_INT);
        $sth->bindValue(':phid', $phid, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_LAZY);
    }

    public function updateLikePhotoStatus($photoLikeID, $status)
    {
        $db = $this->db;
        $query = "UPDATE photolike SET is_like_pl = :status WHERE id_pl = :photoLikeID;";
        $sth = $db->prepare($query);
        $sth->bindValue(':photoLikeID', $photoLikeID, PDO::PARAM_INT);
        $sth->bindValue(':status', $status, PDO::PARAM_STR);
        $sth->execute();
    }

    public function addPhotoLike($photoID, $personID, $userID, $status)
    {
        $db = $this->db;
        $query = "INSERT INTO photolike (photo_id_pl, person_id_pl, user_id_pl, is_like_pl) VALUES(:photoID, :personID, :userID, :status);";
        $sth = $db->prepare($query);
        $sth->bindValue(':photoID', $photoID, PDO::PARAM_INT);
        $sth->bindValue(':personID', $personID, PDO::PARAM_INT);
        $sth->bindValue(':userID', $userID, PDO::PARAM_INT);
        $sth->bindValue(':status', $status, PDO::PARAM_STR);
        $sth->execute();
        return $db->lastInsertId();
    }
}
?>