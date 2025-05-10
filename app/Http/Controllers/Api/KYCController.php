<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Kyc;

class KYCController extends Controller
{
    public function index(Request $request){
        $kyc = Kyc::where('user_id', $request->user()->id)->first();

        if (!$kyc) {
            return apiResponse(false, 'KYC not submitted yet.', null, 404);
        }

        return apiResponse(true, 'KYC get successfully.', ['kyc' => $kyc,'proofs' => $kyc->getAllProofs()], 200);
    }
    
    public function upload(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'identy_proof_type' => 'required|string',
            'address_proof_type' => 'required|string',
            'bank_proof_type'    => 'required|string',

            'identityFile'   => 'nullable|string',
            'addressFile'    => 'nullable|string',
            'bankFile'       => 'nullable|string',
            'panProofFile'   => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }

        $kyc = Kyc::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 0]
        );

        $kyc->status = 0;
        $kyc->update();

        $proofs = [
            'identityFile' => ['collection' => 'identity_proof', 'type' => $request->identy_proof_type],
            'addressFile'  => ['collection' => 'address_proof',  'type' => $request->address_proof_type],
            'bankFile'     => ['collection' => 'bank_proof',     'type' => $request->bank_proof_type],
            'panProofFile' => ['collection' => 'pan_proof',      'type' => 'PAN'],
        ];

        foreach ($proofs as $field => $data) {
            if (!empty($request->$field)) {
                $kyc->uploadProof($data['collection'], $request->$field, $data['type'], 0);
            }
        }

        return apiResponse(true, 'KYC submitted successfully.', null, 200);
    }

}