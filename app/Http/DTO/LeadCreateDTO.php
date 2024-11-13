<?php

namespace App\Http\DTO;

use Illuminate\Http\Request;

class LeadCreateDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public int $phone,

    ) {

    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('phone'),
        );
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        return array_filter($data, function ($value) {
            return $value !== null;
        });
    }

}
