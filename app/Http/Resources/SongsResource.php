<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'song_name' => $this->song_name ,
            'description' => $this->description,
            'lyrics' => $this->lyrics,
            'song_image' => $this->song_image,
            'release_day' => $this->release_day,
            'listen_count' => $this->listen_count,
            'provider' => $this->provider,
            'composer' => $this->composer,
            'download_count' => $this->download_count,
            'category_name' => $this->category_name,
            'category_id' => $this->category_id,
            'country_name' => $this->country_name,
            'country_id' => $this->country_id,
            'singer_name' => $this->singer_name,
            'singer_id' => $this->singer_id,
            'file_paths' => $this->file_paths,
        ];
    }
}
