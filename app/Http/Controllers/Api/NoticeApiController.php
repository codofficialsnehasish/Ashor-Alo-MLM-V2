<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Notice;

class NoticeApiController extends Controller
{
    public function index()
    {
        $notices = Notice::where('is_active', true)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->orderBy('created_at', 'desc')
                    ->get();

        return apiResponse(true, 'All Notices.', ['notices'=>$notices], 200);
    }
}