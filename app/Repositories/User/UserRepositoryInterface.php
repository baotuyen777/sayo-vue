<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getUser($s, $pageSize, $rolesLabel, $selectStatus);
    public function showUser($userName);
    public function getUserWith($arr);
}
