<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    // define property
    public $status;
    public $message;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function __construct($status, $message, $resource) {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }
    public function toArray(Request $request)
    {
        return [
            'success' => $this->status,
            'message' => $this->message,
            'resource' => $this->resource
        ]; 
    }
}
