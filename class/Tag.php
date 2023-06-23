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
     * 使用するメソッドの分岐
     */
    public function process_post(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $action = filter_input(INPUT_GET, 'action');
        
        switch ($action){
            case 'add_tag':
            $this->add_tag();
            break;
            case 'change_tag':
            $this->change_tag();
            break;
            case 'delete_tag':
            $this->delete_tag();
            break;
            default:
            exit;
        }

        exit;
        }
    }

    /**
     * タグ追加フォームを打ち込んだとき
     * @param void
     * @return void
     */
    public function add_tag(){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO tag (tag_name) VALUES (:tag_name)");
            $stmt->bindValue('tag_name', $_POST['tag_name'], \PDO::PARAM_STR);//(文字列として)
            $stmt->execute();
            header('Location: index.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    /**
     * タグを取得
     * @param void
     * @return array $tags
     */
    public function get_tag(){
        $stmt = $this->pdo->query("SELECT * FROM tag");
        $tags = $stmt->fetchAll();
        return $tags;
    }
}