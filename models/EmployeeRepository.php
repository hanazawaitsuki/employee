<?php

class EmployeeRepository extends DbRepository
{
    public function getEmployeeModel()
    {
        //社員の入力データモデル配列
        $data = [
            "ID" => "",
            "name" => "",
            "age" => "",
            "address" => "",
            "dept_id" => "",
        ];
        return $data;
    }

    public function getAll()
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
                order by e.ID asc
            ";
        return $this->fetchAll($sql);
    }

    public function insert($employee)
    {
        $sql = "
            insert into employee(name, age, address, dept_id)
                values(:name,:age,:address,:dept_id)
        ";
        $stmt = $this->execute($sql, $employee);
    }

    public function getEmployeeByID($param)
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

    public function update($employee)
    {
        $sql = "
            update employee set
                    name = :name,
                    age = :age,
                    address = :address,
                    dept_id = :dept_id,
                    updated_at = now()
            where ID = :ID
        ";
        $stmt = $this->execute($sql, $employee);
    }

    public function deleteEmployeeByID($param)
    {
        $sql = "
            delete from employee
             where ID = :ID
        ";
        $stmt = $this->execute($sql, $param);
        return $stmt->rowCount();
    }
}
