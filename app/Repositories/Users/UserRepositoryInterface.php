<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{
    public function list();
    public function employees();
    public function store(array $data);
    public function show($id);
    public function update(int $id, array $data);
    public function destroy(array $data);
    public function listTrashed();
    public function restore(array $data);
    public function delete(array $data);
}
