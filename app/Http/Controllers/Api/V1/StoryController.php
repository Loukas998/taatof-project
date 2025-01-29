<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\CreateStoryRequest;
use App\Http\Requests\Api\V1\UpdateStoryRequest;
use App\Http\Controllers\Controller;
use App\Http\Filters\V1\StoryFilter;
use App\Repository\Story\StoryRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Log;

class StoryController extends ApiController
{
    use ApiResponses;
    public function __construct(protected StoryRepositoryInterface $storyRepository)
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'edit', 'destroy', 'visible');
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
        $hasAuthHeader = false;
        if (request()->header('Authorization')) $hasAuthHeader = true;

        $story = $this->storyRepository->find($id, $hasAuthHeader);
        return $this->ok('Retrieved successfully', $story);
    }

    public function index(StoryFilter $filters)
    {
        $query_parameters = request()->all();
        if (array_key_exists('visible', $query_parameters) && $query_parameters['visible'] == 0 && !request()->header('Authorization')) {
            return response()->json([
                'message' => 'Unauthorized to use this filter'
            ], 401);
        }
        $hasAuthHeader = false;
        if (request()->header('Authorization')) $hasAuthHeader = true;

        $stories = $this->storyRepository->all($filters, $hasAuthHeader);
        return $this->ok('Retrieved successfully', $stories);
    }

    public function visible(StoryFilter $filters)
    {
        $stories = $this->storyRepository->all($filters, true);
        return $this->ok('Retrieved successfully', $stories);
    }
}
