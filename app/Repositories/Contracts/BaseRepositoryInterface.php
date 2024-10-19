<?php

namespace App\Repositories\Contracts;

interface BaseRepositoryInterface {
    public function find($id);
    public function findAll();
    public function store(array $data, $id = null);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}