<?php


class DepartmentController extends Controller
{
    //認証が必要なアクション名の配列
    //今回のアプリで認証が必要なアクションはない
    protected $auth_actions = [];

    //一覧アクション
    public function indexAction()
    {
        //部署情報を取得する
        $departments = $this->db_manager->get('Department')->getAll();

        //メッセージをセッションから取得
        $message = $this->session->get('message');
        $this->session->remove("message");

        //Viewテンプレートに渡すデータ配列作成
        $data = [
            "departments" => $departments,
            "message" => $message
        ];
        return $this->render($data);
    }

    //新規登録アクション
    public function newAction()
    {
        //モデルデータ取得  
        $department = $this->db_manager->get('Department')->getDepartmentModel();
        //エラー情報の配列を初期化
        $errors = [];
        //POSTリクエストは登録処理
        if ($this->request->isPost()) {

            $keys = array_keys($department);
            //モデルデータに該当するPOST値を取得
            foreach ($keys as $key) {
                $department[$key] = $this->request->getPost($key);
            }
            $errors = $this->validate($department, "insert");
            //エラーがない場合、一覧画面へリダイレクト
            if (!isset($errors)) {
                //新規追加時には不要なデータを削除
                unset($department["dept_id"]);
                //DB登録
                $this->db_manager->get('Department')->insert($department);
                //メッセージをセッションに格納
                $this->session->set("message", "新規追加されました");
                return $this->redirect('/department/index');
            }
        }

        $data = [
            // "employee" => $employee,
            "department" => $department,
            "errors" => $errors,
        ];
        return $this->render($data);
    }

    //値チェック
    private function validate($department, $action)
    {
        $errors = [];
        if ($action == "update") {
            //部署の必須チェック
            if (empty($department["dept_name"])) {
                $errors[] = "名前は必須です";
            }
        }
    }


    //編集アクション
    public function editAction()
    {
        //モデルデータ取得
        $department = $this->db_manager->get('Department')->getDepartmentModel();
        //エラー情報の配列を初期化  
        $errors = [];
        //POSTリクエストは登録処理
        if ($this->request->isPost()) {
            $keys = array_keys($department);
            //  モデルデータに登録するPOST値を取得
            foreach ($keys as $key) {
                $department[$key] = $this->request->getPost($key);
            }
            $errors = $this->validate($department, "update");
            //エラーがない場合、一覧画面へリダイレクト
            if (!isset($errors)) {
                
                //ＤＢ登録
                $this->db_manager->get('Department')->update($department);
                //メッセージをセッションに格納
                $this->session->set('message', '更新しました');
                return $this->redirect('/department/index');
            }
        } else {
            $param = ["ID" => $this->request->getGet("ID")];
            $department = $this->db_manager->get('Department')->getDepartmentByID($param);
            if (!$department) {
                $this->session->set('message', '該当のデータはありません');
                return $this->redirect('/department/index');
            }
        }
 
        $data = [
            // "employee" => $employee,
            "department" => $department,
            "errors" => $errors,
        ];
        return $this->render($data);
    }
}
