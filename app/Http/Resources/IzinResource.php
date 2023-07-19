<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IzinResource extends JsonResource
{

    public $status;
    public $message;
    public function __construct($status, $message, $resource) {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }
    
    public function toArray(Request $request)
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'resource' => $this->resource,
        ];
    }
}
