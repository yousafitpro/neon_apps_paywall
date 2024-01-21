<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class logPaywallViewResource extends JsonResource
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
            'api_key'=>$this->api_key,
            'userID'=>$this->userID,
            'appID'=>$this->appID,
            'paywallID'=>$this->custom_id,
            'productID'=>$this->productID,
            'type'=>$this->type,
            'date'=>$this->date,
            'amount'=>$this->amount,
            'appID'=>$this->appID,
        ];
    }
}
