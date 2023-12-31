<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;


class UserResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'full_name' => $this->firstname . " " . $this->lastname,
            'email' => $this->email,
            'is_admin' => (bool)($this->is_admin),
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
