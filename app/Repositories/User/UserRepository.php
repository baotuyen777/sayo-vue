<?php

namespace App\Repositories\User;

use App\Models\Departments;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    private $userTable;
    private $departmentTable;

    public function boot()
    {
        $this->userTable = with(new User())->getTable();
        $this->departmentTable = with(new Departments())->getTable();
    }

    public function getModel()
    {
        return User::class;
    }

    public function getUser($s, $pageSize, $rolesLabel, $selectStatus)
    {
        $select = [
            'u.*',
            'dpm.name as departments_name',
            $rolesLabel,
            $selectStatus
        ];

        return $this->model->from("$this->userTable as u")
            ->join("$this->departmentTable as dpm", 'u.departments_id', '=', 'dpm.id')
            ->where('u.name', 'like', "%{$s}%")
            ->select($select)
            ->paginate($pageSize);
    }

    public function getOne($userName)
    {
        return $this->model->from("$this->userTable as u")
            ->where('u.username', $userName)
            ->with('province')
            ->with('district')
            ->with('ward')
            ->first();
    }

    public function getUserWith($arr = [])
    {
        return $this->model->from("$this->userTable")->with($arr);
    }
}
