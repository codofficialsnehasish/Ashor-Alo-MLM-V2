<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\ContactUs;

class ContactUsApiController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email_or_phone' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', ['error' => $validator->errors()], 422);
        }

        // Create the contact message
        $contact = ContactUs::create([
            'name' => $request->name,
            'email_or_phone' => $request->email_or_phone,
            'message' => $request->message,
        ]);

        // Return success response
        return apiResponse(true, 'Contact message submitted successfully', null, 201);
    }
}