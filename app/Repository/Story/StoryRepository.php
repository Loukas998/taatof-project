<?php

namespace App\Repository\Story;

use App\Models\Story;
use App\Models\Tag;
use App\Http\Filters\V1\StoryFilter;
use App\Http\Resources\V1\StoryResource;
use App\Traits\ApiResponses;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StoryRepository implements StoryRepositoryInterface
{
    public function create(array $data)
    {
        $data['written_at'] = Carbon::parse($data['written_at']);
        $newStory = Story::create($data);
        $newStory->tags()->attach($data['tags']);
        return $newStory;
    }

    public function update(array $data, $id)
    {
        $data['written_at'] = Carbon::parse($data['written_at']);
        $story = Story::find($id);
        $story->update($data);

        if (array_key_exists('tags', $data))
            $story->tags()->sync($data['tags']);
    }

    public function delete($id)
    {
        $story = Story::find($id);
        $story->tags()->detach();
        $story->delete();
    }

    public function find($id, $hasAuthHeader)
    {
        $story = Story::find($id);

        if (!$hasAuthHeader && $story->visible == true) {
            $story->clicks++;
            $story->save();
        }

        return new StoryResource($story);
    }


    public function all(StoryFilter $filters, bool $isAuth)
    {
        if ($isAuth === false) {
            return StoryResource::collection(Story::filter($filters)->where('visible', true)->whereNotNull('body')->get());
        } else
            return StoryResource::collection(Story::filter($filters)->get());
    }
}
