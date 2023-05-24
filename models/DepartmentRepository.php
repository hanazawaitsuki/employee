<?php

class DepartmentRepository extends DbRepository
{
    public function getAll()
    {
        $sql = "select * from department";
        return $this->fetchAll($sql);
    }
}
