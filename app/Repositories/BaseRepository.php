<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface {
    protected $model;

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->find($id);
    }

    public function findAll() {
        return $this->model->all();
    }

    public function store(array $data, $id = null) {
        return $id ? $this->update($id, $data) : $this->create($data);
    }

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update($id, array $data) {
        $record = $this->find($id);
        $record->update($data);
        return $this->find($id);
    }

    public function delete($id) {
        return $this->model->destroy($id);
    }
}
