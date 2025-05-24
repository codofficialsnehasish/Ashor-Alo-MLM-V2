<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Certificate;
use App\Models\PhotoGallary;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Storage;

class WebsiteApiController extends Controller
{
    public function photo_gallary(){
        $photo_gallary = PhotoGallary::where('is_active', 1)
                                        ->orderBy('id', 'desc')
                                        ->get()
                                        ->map(function ($item) {
                                            return [
                                                'title' => $item->title,
                                                'description' => $item->description,
                                                'image_link' => $item->getFirstMediaUrl('gallery_images')
                                            ];
                                        });
        return apiResponse(true, 'All Active Photos', ['photo_gallary'=>$photo_gallary], 200);
    }

    public function certificates(){
        // $certificates = Certificate::where('is_active',1)->orderBy('id','desc')->get();
        $certificates = Certificate::where('is_active', 1)
                                        ->orderBy('id', 'desc')
                                        ->get()
                                        ->map(function ($item) {
                                            return [
                                                'title' => $item->title,
                                                'description' => $item->description,
                                                'image_link' => $item->getFirstMediaUrl('certificate_images')
                                            ];
                                        });
        return apiResponse(true, 'All Active Certificates', ['certificates'=>$certificates], 200);
    }

    public function website_settings(){
        $setting = WebsiteSetting::select([
                                    'site_name',
                                    'site_description',
                                    'contact_email',
                                    'contact_number',
                                    'contact_address',
                                    'maintenance_mode',
                                    'maintenance_message',
                                    'header_scripts',
                                    'footer_scripts',
                                    'seo_meta_description',
                                    'seo_meta_keywords'
                                ])->first();

        return apiResponse(true, 'Site Settings', ['setting'=>$setting], 200);
    }

    public function privacy_policy(){
        $setting = WebsiteSetting::select([
                                    'privacy_policy'
                                ])->first();

        return apiResponse(true, 'Privacy Policy', ['privacy_policy'=>$setting->privacy_policy], 200);
    }

    public function terms_and_conditions(){
        $setting = WebsiteSetting::select([
                                    'terms_and_conditions'
                                ])->first();

        return apiResponse(true, 'Terms And Conditions', ['terms_and_conditions'=>$setting->terms_and_conditions], 200);
    }

    // public function business_plan(){
    //     return apiResponse(true, 'Business Plan', ['plan_pdf'=>asset('web_directory/business_plan/Ashor Alo Print New Plan.pdf')], 200);
    // }

    public function business_plan(){
        $filePath = 'business_plan/Ashor-Alo-Business-Plan.pdf';
        
        // Check if file exists (optional)
        if (!file_exists(public_path($filePath))) {
            return apiResponse(false, 'Business plan not found', null, 404);
        }

        return apiResponse(
            true,
            'Business Plan',
            ['plan_pdf' => asset($filePath)],
            200
        );
    }
 
    public function about_us(){
        return apiResponse(
            true,
            'About Us',
            ['text' => asset($filePath)],
            200
        );
    }
}