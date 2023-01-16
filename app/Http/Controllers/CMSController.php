<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Pages\Models\Page;

class CMSController extends Controller
{
    public function index($page)
    {
        return view('cms.'.$page);
    }

    public function education()
    {
        return view('cms.education');
    }

    public function page($page)
    {
        $page_info = Page::with('trans')->where('page_url', $page)->first();
        return view('cms.cms',compact('page_info'));
    }

}
