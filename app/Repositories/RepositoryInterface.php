<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function boot();

    public function getAll();

    public function find($conditions, $columns = ['*']);

    public function update($conditions = [], $attributes = []);

    public function getQueryByConditions($conditions);

    public function updateDataWithConditions($updateData, $conditions);

    public function getDataWithConditions($selectData, $conditions, $orders = [], $limit = 0, $joins = [], $from = null);

    public function insert($data);

    public function create($data);

    public function count($conditions);

    public function delete($conditions = []);
}
