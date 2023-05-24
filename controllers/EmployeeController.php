<?php


class EmployeeController extends Controller
{
    //認証が必要なアクション名の配列
    //今回のアプリで認証が必要なアクションはない
    protected $auth_actions = [];

    //一覧アクション
    public function indexAction()
    {
        //社員情報を取得する
        $employees = $this->db_manager->get('Employee')->getAll();
        
        //メッセージをセッションから取得
        $message = $this->session->get('message');
        $this->session->remove("message");

        //Viewテンプレートに渡すデータ配列作成
        $data = [
            "employees" => $employees,
            "message" => $message
        ];
        return $this->render($data);
    }

    //新規登録アクション
    public function newAction()
    {
        //モデルデータ取得  
        $employee = $this->db_manager->get('Employee')->getEmployeeModel();
        //エラー情報の配列を初期化
        $errors = [];
        //POSTリクエストは登録処理
        if ($this->request->isPost()) {
            $keys = array_keys($employee);
            //モデルデータに該当するPOST値を取得
            foreach ($keys as $key) {
                $employee[$key] = $this->request->getPost($key);
            }
            $errors = $this->validate($employee, "insert");
            //エラーが場合、一覧画面へリダイレクト
            if (count($errors) === 0) {
                //新規追加時には不要なデータを削除
                unset($employee["ID"]);
                //DB登録
                $this->db_manager->get('Employee')->insert($employee);
                //メッセージをセッションに格納
                $this->session->set("message", "新規追加されました");
                return $this->redirect('/employee/index');
            }
        }

        //部署のデータ取得
        $department = $this->db_manager->get('Department')->getAll();

        $data = [
            "employee" => $employee,
            "department" => $department,
            "errors" => $errors,
        ];
        return $this->render($data);
    }

    //値チェック
    private function validate($employee, $action)
    {
        $errors = [];
        if ($action == "update") {
            //IDの必須チェック
            if (empty($employee["ID"])) {
                $errors[] = "IDは必須です";
            }
        }
        //名前の必須チェック
        if (empty($employee["name"])) {
            $errors[] = "名前は必須です";
        }

        //年齢の必須チェック
        if (empty($employee["age"])) {
            $errors[] = "年齢は必須です";
            //年齢の数値チェック
        } else if (!ctype_digit($employee["age"])) {
            $errors[] = "年齢は数値を入力して下さい";
        }

        //部署IDの必須チェック
        if (empty($employee["dept_id"])) {
            $errors[] = "部署は必須です";
            //部署IDの数値チェック
        } else if (!ctype_digit($employee["dept_id"])) {
            $errors[] = "部署は数値を入力して下さい";
        }
        return $errors;
    }

    //編集アクション
    public function editAction()
    {
        //モデルデータ取得
        $employee = $this->db_manager->get('Employee')->getEmployeeModel();
        //エラー情報の配列を初期化  
        $errors = [];
        //POSTリクエストは登録処理
        if ($this->request->isPost()) {
            $keys = array_keys($employee);
            //  モデルデータに岐東するPOST値を取得
            foreach ($keys as $key) {
                $employee[$key] = $this->request->getPost($key);
            }
            $errors = $this->validate($employee, "update");
            //エラーがない場合、一覧画面へリダイレクト
            if (count($errors) === 0) {
                //ＤＢ登録
                $this->db_manager->get('Employee')->update($employee);
                //メッセージをセッションに格納
                $this->session->set('message', '更新しました');
                return $this->redirect('/employee/index');
            }
        } else {
            $param = ["ID" => $this->request->getGet("ID")];
            $employee = $this->db_manager->get('Employee')->getEmployeeByID($param);
            if (!$employee) {
                $this->session->set('message', '該当のデータはありません');
                return $this->redirect('/employee/index');
            }
        }
        //部署のデータ取得 
        $department = $this->db_manager->get('Department')->getAll();

        $data = [
            "employee" => $employee,
            "department" => $department,
            "errors" => $errors,
        ];
        return $this->render($data);
    }
    //削除アクション
    public function deleteAction()
    {
        $param = [
            "ID" => $this->request->getGet("ID")
        ];
        $rowCount = $this->db_manager->get("Employee")->deleteEmployeeByID($param);
        $this->session->set("message", $rowCount . "件を削除しました");
        return $this->redirect('/employee/index');
    }
}
