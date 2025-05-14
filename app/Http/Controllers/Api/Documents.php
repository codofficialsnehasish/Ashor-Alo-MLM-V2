<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\BinaryTree;

class Documents extends Controller
{
    public function welcome_letter(Request $request){
        return apiResponse(true, 'Welcome Letter.', ['url'=>route('my-documents.welcome-letter.view',$request->user()->member_number)], 200);
    }

    public function id_card(Request $request){
        return apiResponse(true, 'ID Card.', ['url'=>route('my-documents.id-card.view',$request->user()->member_number)], 200);
    }


    public function welcome_letter_view($user_id){
        $data['title'] = 'Welcome Letter';
        // $data['user'] = User::where('user_id',$user_id)->first();
        $BinaryTree = BinaryTree::where('member_number',$user_id)->first();
        $data['user'] = $BinaryTree->user;
        return view('user_dashboard.documents.welcome_letter')->with($data);
    }

    public function id_card_view($user_id){
        $data['title'] = 'ID Card';
        // $data['user'] = User::where('user_id',$user_id)->first();
        $BinaryTree = BinaryTree::where('member_number',$user_id)->first();
        $data['user'] = $BinaryTree->user;
        return view('user_dashboard.documents.id_card')->with($data);
    }
}