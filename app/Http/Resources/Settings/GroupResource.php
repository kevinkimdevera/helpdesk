<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return [
        'id' => $this->id,
        'name' => $this->name,
        'users' => $this->users->count(),
        'status' => [
          'active' => $this->active,
          'color' => $this->active ? 'success' : '',
          'icon' => $this->active ? 'mdi-check-circle' : 'mdi-close-circle',
          'text' => $this->active ? 'Active' : 'Inactive'
        ]
      ];
    }
}
