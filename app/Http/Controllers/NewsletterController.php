<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter; 

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // 1. Validate inputs
        $request->validate([
            'email' => 'required|email',
            'first_name' => 'nullable|string|max:255', // Allow empty
            'last_name' => 'nullable|string|max:255',  // Allow empty
        ]);

        try {
            if (! Newsletter::isSubscribed($request->email)) {
                
                // 2. Subscribe with Merge Fields (Names)
                Newsletter::subscribe($request->email, [
                    'FNAME' => $request->first_name ?? '', // Mailchimp uses 'FNAME'
                    'LNAME' => $request->last_name ?? '',  // Mailchimp uses 'LNAME'
                ]);
                
                return redirect()->back()->with('success', 'Đăng ký thành công! Kiểm tra email của bạn.');
            }

            return redirect()->back()->with('error', 'Email này đã được đăng ký trước đó.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi kết nối: ' . $e->getMessage());
        }
    }
}