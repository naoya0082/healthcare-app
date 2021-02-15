<?php
require_once('DB.php');
class User extends DB
{
    // 管理者orユーザーを判定
    public function getPosition($userId)
    {
        $sql = 'SELECT position FROM user_info WHERE id=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $userId
        ));
        $result = $statement->fetch();
        return $result;
    }
    // ログイン処理
    public function login()
    {
        $sql = 'SELECT * FROM user_info WHERE user_name=? AND password=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_POST['name'],
            $_POST['password']
        ));
        $result = $statement->rowCount();
        return $result;
    }

    // プロフィール新規作成
    public function insertProfile($userId, $bmi, $date)
    {
        $sql = 'INSERT INTO profile SET user_id=?, name=?, age=?, sex=?, height=?, weight=?, BMI=?, goal=?, created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $userId,
            $_SESSION['member']['name'],
            $_POST['age'],
            $_POST['sex'],
            $_POST['height'],
            $_POST['weight'],
            $bmi,
            $_POST['goal'],
            $date
        ));
    }

    // プロフィール表示
    public function displayProfile($userId)
    {
        $sql = 'SELECT * FROM profile WHERE user_id=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array($userId));
        $result = $statement->fetch();
        return $result;
    }

    // プロフィール作成済みか否か
    public function checkProfile($userId, $userName)
    {
        $sql = 'SELECT * FROM profile WHERE user_id=? AND name=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $userId,
            $userName
        ));
        $result = $statement->rowCount();
        return $result;
    }

    // プロフィールの編集
    public function updateProfile($bmi, $userId, $userName)
    {
        $sql = 'UPDATE profile SET age=?, sex=?, height=?, weight=?, BMI=?, goal=?, created_at=? WHERE user_id=? AND name=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_POST['age'],
            $_POST['sex'],
            $_POST['height'],
            $_POST['weight'],
            $bmi,
            $_POST['goal'],
            date('Y-m-d'),
            $userId,
            $userName
        ));
    }

    // ユーザーIDを取得
    public function getUserId()
    {
        $sql = 'SELECT id FROM user_info WHERE user_name=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array($_SESSION['member']['name']));
        $result = $statement->fetch();
        return $result;
    }

    // メニューIDを取得
    public function getMenuId()
    {
        $sql = 'SELECT id FROM menu_info WHERE menu_name=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array($_POST['menu_name']));
        $result = $statement->fetch();
        return $result;
    }

    // 新規ユーザー登録処理
    public function insert()
    {
        $sql = 'INSERT INTO user_info SET position="user", user_name=?, email=?, password=?, created_at=NOW()';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_SESSION['user_info']['name'],
            $_SESSION['user_info']['email'],
            $_SESSION['user_info']['password']
        ));
    }

    // メニュー情報取得処理
    public function display($category)
    {
        $sql = 'SELECT * FROM menu_info WHERE category=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array($category));
        return $statement;
    }

    // カロリー取得取得処理
    public function display_cal($name)
    {
        $sql = 'SELECT calorie FROM menu_info WHERE menu_name=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array($name));
        $result = $statement->fetch();
        return $result;
    }

    // タンパク質取得処理
    public function display_pr($name)
    {
        $sql = 'SELECT protein FROM menu_info WHERE menu_name=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array($name));
        $result = $statement->fetch();
        return $result;
    }

    // 今日の記録を取得
    public function todays_record($date)
    {
        $sql = 'SELECT * FROM user_menu WHERE user_name=? AND created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_SESSION['member']['name'],
            $date
        ));
        $result = $statement->fetchAll();
        return $result;
    }

    // 選択したメニューの栄養素を取得する処理
    public function check_elements()
    {
        $sql = 'SELECT * FROM menu_info WHERE menu_name=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array($_POST['checkbox']));
        $result = $statement->fetch();
        return $result;
    }

    // 記録新規追加処理
    public function addrecord($userId, $menuId, $date)
    {
        $sql = 'INSERT INTO user_menu SET user_name=?, user_id=?, menu_name=?, menu_id=?, created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_SESSION['member']['name'],
            $userId,
            $_POST['menu_name'],
            $menuId,
            $date
        ));
    }

    // メニュー新規登録処理
    public function addmenu()
    {
        $sql = 'INSERT INTO menu_info SET menu_name=?, calorie=?, protein=?, category=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_SESSION['menu']['menu_name'],
            $_SESSION['menu']['calorie'],
            $_SESSION['menu']['protein'],
            $_SESSION['menu']['category']
        ));
    }

    // カロリー合計を取得
    public function total_cal($date)
    {
        $sql = 'SELECT SUM(calorie) FROM menu_info JOIN user_menu ON menu_info.id = user_menu.menu_id WHERE user_menu.user_name=? AND user_menu.created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_SESSION['member']['name'],
            $date
        ));
        $result = $statement->fetch();
        return $result;
    }

    // タンパク質合計を取得
    public function total_pr($date)
    {
        $sql = 'SELECT SUM(protein) FROM menu_info JOIN user_menu ON menu_info.id = user_menu.menu_id WHERE user_menu.user_name=? AND user_menu.created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_SESSION['member']['name'],
            $date
        ));
        $result = $statement->fetch();
        return $result;
    }

    // 記録したメニューを削除
    public function delete($id)
    {
        $sql = 'DELETE FROM user_menu WHERE id=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array($id));
    }

    // 体重を記録
    public function insertWeight($userId)
    {
        $sql = 'INSERT INTO weight_info SET user_id=?, user_name=?, weight=?, created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $userId,
            $_SESSION['member']['name'],
            $_SESSION['weight']['weight'],
            date('Y-m-d')
        ));
    }

    // 体重データを取得
    public function getWeight($userId, $date)
    {
        $sql = 'SELECT * FROM weight_info WHERE user_id=? AND created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $userId,
            $date
        ));
        $result = $statement->fetch();
        return $result;
    }
    // 体重データが記録済みか否か
    public function checkWeight($userId, $date)
    {
        $sql = 'SELECT * FROM weight_info WHERE user_id=? AND created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $userId,
            $date
        ));
        $result = $statement->rowCount();
        return $result;
    }

    // 体重を編集
    public function updateWeight($userId, $date)
    {
        $sql = 'UPDATE weight_info SET weight=? WHERE user_id=? AND created_at=?';
        $statement = $this->dbconnect->prepare($sql);
        $statement->execute(array(
            $_POST['weight'],
            $userId,
            $date
        ));
    }
}
