<?php

namespace App\Repositories;


abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
        $this->boot();
    }

    public function boot()
    {
        // TODO: Implement boot() method.
    }

    public function find($conditions, $columns = ['*'])
    {
        $query = $this->getQueryByConditions($conditions);

        return $query->first($columns);
    }

    public function update($conditions = [], $attributes = [])
    {
        $query = $this->getQueryByConditions($conditions);
        $result = $query->get();
        if ($result->count() > 0) {
            $query->update($attributes);
            return true;
        }
        return false;
    }

    public function updateDataWithConditions($updateData, $conditions)
    {
        $query = $this->model;
        foreach ($conditions as $condition => $value) {
            if (is_array($value) && !empty($value)) {
                $query = $query->whereIn($condition, $value);
            } else {
                $query = $query->where($condition, $value);
            }
        }
        return $query->update($updateData);
    }

    public function getDataWithConditions($selectData, $conditions, $orders = [], $limit = 0, $joins = [], $from = null)
    {
        $query = $this->model->select($selectData);
        if (!empty($from)) {
            $query = $query->from($from);
        }

        foreach ($joins as $join) {
            if (isset($join['table']) && isset($join['condition']) && is_array($join['condition'])) {
                $table = $join['table'];
                $condition = $join['condition'];
                $type = @$join['type'] ?: "join";
                $query->$type($table, function ($joinClause) use ($condition) {
                    foreach ($condition as $field => $value) {
                        if ($field === 'join_where') {
                            $k = array_key_first($value);
                            if (is_array($value[$k])) {
                                $joinClause->whereIn($k, $value[$k]);
                            } else {
                                $joinClause->where($k, '=', $value[$k]);
                            }
                        } else {
                            $joinClause->on($field, '=', $value);
                        }
                    }
                });
            }
        }

        foreach ($conditions as $condition => $value) {
            if (is_array($value) && !empty($value)) {
                $query->whereIn($condition, $value);
            } else {
                $query->where($condition, $value);
            }
        }

        foreach ($orders as $field => $dir) {
            if (is_numeric($field) && !empty($dir)) {
                $query->orderBy(strtolower($dir));
            }
            if (is_string($field) && in_array(strtolower($dir), ['desc', 'asc'])) {
                $query->orderBy(strtolower($field), strtolower($dir));
            }
        }

        if ($limit > 0) {
            return $query->limit($limit);
        }

        return $query;
    }

    public function insert($data)
    {
        return $this->model->insert($data);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function count($conditions)
    {
        $query = $this->getQueryByConditions($conditions);

        return $query->count();
    }

    public function delete($conditions = [])
    {
        return $this->model->where($conditions)->delete();
    }

    public function getQueryByConditions($conditions = [])
    {

        if (empty($conditions)) {
            return null;
        }
        $query = $this->model->newQuery();
        $keys = $this->model->getKeyName();
        if (!is_array($keys)) {
            if (!isset($conditions[$keys])) {
                return null;
            } elseif (!is_array($conditions[$keys])) {
                return $query->where($keys, $conditions[$keys]);
            } else {
                return $query->whereIn($keys, $conditions[$keys]);
            }
        }

        foreach ($keys as $key) {
            if (!isset($conditions[$key])) {
                continue;
            }
            $query->where($key, $conditions[$key]);
        }
        return $query;
    }

    abstract protected function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll()
    {
        return $this->model->all();
    }
}
