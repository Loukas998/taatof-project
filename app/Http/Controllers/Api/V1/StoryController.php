<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CreateStoryRequest;
use App\Http\Requests\Api\V1\UpdateStoryRequest;
use App\Http\Controllers\Controller;
use App\Http\Filters\V1\StoryFilter;
use App\Repository\Story\StoryRepositoryInterface;
use App\Traits\ApiResponses;

class StoryController extends ApiController
{
    use ApiResponses;
    public function __construct(protected StoryRepositoryInterface $storyRepository)
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'edit', 'destroy');
    }
        
    public function store(CreateStoryRequest $data)
    {
        $newStory = $this->storyRepository->create($data->input());
        return $this->createdAt('story created', route('stories.show', ['story' => $newStory->id]));
    }

    public function update(UpdateStoryRequest $data, $id)
    {
       $this->storyRepository->update($data->input(), $id);
       return $this->noContent();
    }

    public function destroy($id)
    {
        $this->storyRepository->delete($id);
        return  $this->noContent();
    }

    public function show($id)
    {
        if(request()->header('Authorization')) $hasAuthHeader = true;
        else $hasAuthHeader = false;
        
        $story = $this->storyRepository->find($id, $hasAuthHeader);
        return $this->ok('Retrieved successfully', $story); 
    }

    public function index(StoryFilter $filters)
    {
        $stories = $this->storyRepository->all($filters);
        return $this->ok('Retrieved successfully', $stories); 
    }
}
