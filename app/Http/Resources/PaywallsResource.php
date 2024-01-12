<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaywallsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     public static $wrap = null;
    public function toArray(Request $request): array
    {
        return [
            'paywallID'=>$this->custom_id,
            'json'=>json_decode($this->json),
            'appID'=>$this->appID
        ];
    }
}
