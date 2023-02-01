<?php

namespace App\Repositories;

interface AbstractRepositoryInterface
{
    public function store(array $data);

    public function update($id, $data);

    public function show($id);

    public function delete($id);

}
