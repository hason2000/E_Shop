<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    protected $model;

    public function store(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function show($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}

?>
