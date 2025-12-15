<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /** @return array<string,mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'template' => new TemplateResource($this->whenLoaded('template')),
            'owner' => $this->whenLoaded('owner'),
            'content' => $this->content,
            'metadata' => $this->metadata,
            'status' => $this->status,
            'version' => $this->version,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
