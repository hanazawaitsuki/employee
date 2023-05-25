<?php

class EmployeeApplication extends Application
{
    protected $login_action = [];

    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    protected function registerRoutes()
    {
        return [
            '/'
            => ['controller' => 'employee', 'action' => 'index',],
            '/employee/index'
            => ['controller' => 'employee', 'action' => 'index',],
            '/employee/edit'
            => ['controller' => 'employee', 'action' => 'edit',],
            '/employee/new'
            => ['controller' => 'employee', 'action' => 'new',],
            '/employee/delete'
            => ['controller' => 'employee', 'action' => 'delete',],
            //追加実装
            '/department/index'
            => ['controller' => 'department', 'action' => 'index',],
            '/department/edit'
            => ['controller' => 'department', 'action' => 'edit',],
            '/department/new'
            => ['controller' => 'department', 'action' => 'new',],

        ];
    }

    protected function configure()
    {
        $this->db_manager->connect('master', [
            'dsn' => 'mysql:dbname=employee;host=localhost;charset=utf8',
            'user' => 'root',
            'password' => '',
        ]);
    }
}
