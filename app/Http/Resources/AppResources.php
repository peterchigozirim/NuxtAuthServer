<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $base_url = $request->root();
        return [
            'id' => $this->id,
            'app_name' => $this->app_name,
            'app_logo' => $base_url.'/storage/app/'.$this->app_logo,
            'app_favicon' => $base_url.'/storage/app/'.$this->app_favicon,
            'app_description' => $this->app_description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
