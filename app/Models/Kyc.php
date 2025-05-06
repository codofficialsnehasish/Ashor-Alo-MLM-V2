<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Illuminate\Support\Str;

class Kyc extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'status' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get custom property "status" from first media in given collection.
     */
    public function getProofStatus(string $collection): int
    {
        $media = $this->getFirstMedia($collection);
        return $media?->getCustomProperty('status') ?? 0;
    }

    /**
     * Get custom property "remarks" from first media in given collection.
     */
    public function getProofRemarks(string $collection): ?string
    {
        $media = $this->getFirstMedia($collection);
        return $media?->getCustomProperty('remarks');
    }

    /**
     * Upload new proof and set custom properties (status and remarks).
     */
    public function uploadProof(string $collection, string $base64Image, string $type, int $status = 0): void
    {
        $this->clearMediaCollection($collection);

        $this->addMediaFromBase64($base64Image)
            ->usingFileName(Str::random(10) . '.png')
            ->withCustomProperties([
                'type' => $type, 
                'status' => $status, 
                'remarks' => null,
            ])
            ->toMediaCollection($collection);
    }

    public function getAllProofs(): array
    {
        $collections = ['identity_proof', 'address_proof', 'bank_proof', 'pan_proof'];
        $data = [];

        foreach ($collections as $collection) {
            $media = $this->getFirstMedia($collection);
            $data[$collection] = [
                'url'     => $media?->getFullUrl(),
                'type'  => $media?->getCustomProperty('type'),
                'status'  => $media?->getCustomProperty('status') ?? 0,
                'remarks' => $media?->getCustomProperty('remarks'),
            ];
        }

        return $data;
    }


}
