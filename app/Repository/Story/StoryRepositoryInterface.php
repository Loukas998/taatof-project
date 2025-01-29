<?php

namespace App\Repository\Story;

use App\Http\Filters\V1\StoryFilter;

interface StoryRepositoryInterface
{
    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $hasAuthHeader);

    public function all(StoryFilter $filters, bool $isAuth);
}
