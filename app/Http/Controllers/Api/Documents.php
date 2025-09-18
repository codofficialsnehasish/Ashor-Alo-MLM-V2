<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\BinaryTree;
use Barryvdh\DomPDF\Facade\Pdf;

class Documents extends Controller
{
    public function welcome_letter(Request $request){
        $data = [
            'url'=>route('my-documents.welcome-letter.view',$request->user()->member_number),
            'download_url'=>route('my-documents.welcome-letter.download',$request->user()->member_number),
        ];
        return apiResponse(true, 'Welcome Letter.', $data, 200);
    }

    public function id_card(Request $request){
        $data = [
            'url'=>route('my-documents.id-card.view',$request->user()->member_number),
            'download_url'=>route('my-documents.id-card.download',$request->user()->member_number),
        ];
        return apiResponse(true, 'ID Card.', $data, 200);
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

    public function welcome_letter_download($user_id)
    {
        $BinaryTree = BinaryTree::where('member_number', $user_id)->firstOrFail();
        $data['title'] = 'Welcome Letter';
        $data['user'] = $BinaryTree->user;

        $pdf = Pdf::loadView('user_dashboard.documents.welcome_letter-download', $data)
                    ->setPaper('a4', 'portrait')
                    ->set_option('margin_top', 10)
                    ->set_option('margin_right', 10)
                    ->set_option('margin_bottom', 10)
                    ->set_option('margin_left', 10);

        return $pdf->download('welcome_letter_'.$user_id.'.pdf');
    }

    public function id_card_download($user_id)
    {
        $BinaryTree = BinaryTree::where('member_number', $user_id)->firstOrFail();
        $data['title'] = 'ID Card';
        $data['user'] = $BinaryTree->user;

        $pdf = Pdf::loadView('user_dashboard.documents.id_card-download', $data)
                    ->setPaper('a4', 'portrait')
                    ->setOptions(['isRemoteEnabled' => true]);
        return $pdf->download('id_card_'.$user_id.'.pdf');
    }
}