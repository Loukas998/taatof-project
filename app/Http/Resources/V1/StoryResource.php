<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'story',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'body' => $this->body,
                'teller' => $this->teller,
                'clicks' => $this->clicks,
                'written_at' => $this->written_at,
                'visible' => $this->visible
            ],
            'link' => $this->when(
                    $request->routeIs('stories'),
                    route('stories.show', $this->id)
                )
            ,
            'relationships' =>[
                'place' => [
                    'data' => [
                        'type' => 'state',
                        'id' => $this->state_id
                    ],
                    'link' => route('states.show', $this->id)
                ],
            ],
            'includes' => [
                'place' => new StateResource($this->state),
                'category' => TagResource::collection($this->tags)
            ],
        ];
    }
}
