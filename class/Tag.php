<?php

class Tag{
    private $pdo;

    /**
     * コンストラクタ 
     */
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    /**
     * 使用するメソッドのを判別
     */
    public function process_post(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $action = filter_input(INPUT_GET, 'action');
        switch ($action){
            case 'add_tag':
                $this->add_tag();
                break;
            case 'change_or_delete':
                if($_POST['change_or_delete']==='変更') $this->change_tag();
                if($_POST['change_or_delete']==='削除') $this->delete_tag();
                break;
            default:
                break;
        }

        }
    }

    /**
     * タグを追加
     * @param void
     * @return void
     */
    public function add_tag(){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO tag (tag_name) VALUES (:tag_name)");
            $stmt->bindValue('tag_name', $_POST['tag_name'], \PDO::PARAM_STR);
            $stmt->execute();
            header('Location: index.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * タグの削除
     * @param void
     * @return void
     */
    public function delete_tag(){
        try {
            $stmt = $this->pdo->prepare("UPDATE tag SET deleted = 1 WHERE id = :tag_id");
            $stmt->bindValue('tag_id', $_POST['tag_id'], \PDO::PARAM_INT);
            $stmt->execute();
            header('Location: index.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * タグの変更
     * @param void
     * @return void
     */
    public function change_tag(){
        try {
            $stmt = $this->pdo->prepare("UPDATE tag SET tag_name = :tag_name WHERE id = :tag_id");
            $stmt->bindValue('tag_name', $_POST['tag_name'], \PDO::PARAM_STR);
            $stmt->bindValue('tag_id', $_POST['tag_id'], \PDO::PARAM_INT);
            $stmt->execute();
            header('Location: index.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    /**
     * 削除されていないタグを取得
     * @param void
     * @return array $tags
     */
    public function get_tag(){
        $stmt = $this->pdo->query("SELECT * FROM tag WHERE deleted = 0");
        $tags = $stmt->fetchAll();
        return $tags;
    }
}