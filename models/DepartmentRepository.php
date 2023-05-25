<?php

class DepartmentRepository extends DbRepository
{
    //追加実装
    public function getDepartmentModel()
    {
        //部署の入力データモデル配列
        $data = [
            "dept_id" => "",
            "dept_name" => "",
        ];
        return $data;
    }

    public function getAll()
    {
        $sql = "select * from department";
        return $this->fetchAll($sql);
    }

    //追加実装部分
    public function insert($department)
    {
        $sql = "
            insert into department(dept_name)
                values(:dept_name)
        ";
        $stmt = $this->execute($sql, $department);
    }

    //このメソッドの役割は何？（SQL文の中の修正ができていない）
    public function getDepartmentByID($param)
    {
        $sql = "
            select 
            e.ID,e.name,e.age,e.address,e.dept_id,d.dept_name
            from 
            employee as e
            left join
            department as d
            on 
            e.dept_id = d.dept_id
            where
            e.ID = :ID
        ";
        return $this->fetch($sql, $param);
    }

    public function update($department)
    {
        $sql = "
            update department set
                    dept_name = :dept_name
                    where
                    dept_id = :dept_id
        ";
        $stmt = $this->execute($sql, $department);
    }
}
