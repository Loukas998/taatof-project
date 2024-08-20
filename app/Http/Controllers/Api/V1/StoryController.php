<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CreateStoryRequest;
use App\Http\Requests\Api\V1\UpdateStoryRequest;
use App\Http\Controllers\Controller;
use App\Repository\Story\StoryRepositoryInterface;

class StoryController extends Controller
{
    public function __construct(protected StoryRepositoryInterface $storyRepository) {}
        
    public function create(CreateStoryRequest $data)
    {
        return $this->storyRepository->create($data->toArray());
    }

    public function update(UpdateStoryRequest $data, $id)
    {
       return $this->storyRepository->update($data->toArray(), $id);
    }

    public function destroy($id)
    {
        return $this->storyRepository->delete($id);
    }

    public function show($id)
    {
       return $this->storyRepository->find($id);
    }

    public function index()
    {
        return $this->storyRepository->all();
    }
}
