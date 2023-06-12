<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @var null
     */
    protected $message = null;

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id, 
 			'name' => $this->name, 
 			'email' => $this->email, 
 			'email_verified_at' => $this->email_verified_at, 
 			'password' => $this->password, 
 			'two_factor_secret' => $this->two_factor_secret, 
 			'two_factor_recovery_codes' => $this->two_factor_recovery_codes, 
 			'two_factor_confirmed_at' => $this->two_factor_confirmed_at, 
 			'remember_token' => $this->remember_token, 
 			'profile_photo_path' => $this->profile_photo_path, 
 			'facebook_id' => $this->facebook_id, 
 			'linkedin_id' => $this->linkedin_id, 
 			'twitter_id' => $this->twitter_id, 
 			'google_id' => $this->google_id, 
 			'deleted_at' => $this->deleted_at, 
 			'created_at' => $this->created_at, 
 			'updated_at' => $this->updated_at, 
 			
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'success' => true,
            'message' => $this->message,
            'meta' => null,
            'errors' => null
        ];
    }
}
