<?php

namespace Piplmodules\Banners\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Piplmodules\Banners\Models\Banner;
use Piplmodules\Banners\Models\BannerTrans;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class BannersApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | piplmodules Banners API Controller
      |--------------------------------------------------------------------------
      |
     */

    /**
     * @param
     * @return
     */
    public function storeValidation($request)
    {
        $rules = [];
        $messages = [];
        $rules['name'] = 'required|max:255';
        $rules['banner_img'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096';
        $messages['name.required'] = 'Please enter banner title.';
        $messages['banner_img.required'] = 'Please select a banner image.';

        return \Validator::make($request->all(), $rules, $messages);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listItems(Request $request)
    {
        $banners = Banner::FilterName()->FilterStatus()->orderBy('id', 'DESC')->paginate($request->get('paginate'));
        return $banners;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function storeBanner(Request $request)
    {
        $validator = $this->storeValidation($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $banner = new Banner;
        if ($request->author) {
            $author = $request->author;
        } else {
            $author = auth()->user()->id;
        }

        $banner->created_by = $author;
        $banner->updated_by = $author;
        $banner->active = false;
        if ($request->active) {
            $banner->active = true;
        }
        /*$banner->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
        $banner->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));*/
        $banner->save();
//        $banner->order_id = $banner->id;
//        $banner->save();
        // Translation
        $image = $request->file('banner_img');

        $input['banner_img'] = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/img/banners');

        $img = Image::make($image->getRealPath());
//        $img->resize(100, 100, function ($constraint) {
        //$img->resize(544, 600, function ($constraint) {
        $img->resize(555, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $input['banner_img']);

        $destinationPath = public_path('img/banners/thumbs');
        $image->move($destinationPath, $input['banner_img']);

        $bannerTrans = new BannerTrans;
        $bannerTrans->banner_id = $banner->id;
        $bannerTrans->name = $request->name;
        $bannerTrans->banner_img = $input['banner_img'];
//            $bannerTrans->url = $request->banner_object_url;
        $bannerTrans->lang = 'en';
        $bannerTrans->save();
        $response = ['message' => trans('Banners::banners.saved_successfully')];
        return response()->json($response, 201);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::find($id);
        if ($request->author) {
            $author = $request->author;
        } else {
            $author = auth()->user()->id;
        }
        $banner->updated_by = $author;
        $banner->active = false;
        if ($request->active) {
            $banner->active = true;
        }
        $banner->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
        $banner->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
        $banner->save();
        $bannerImg = "";
        $image = $request->file('banner_img');
        if ($image != NULL) {
            $input['banner_img'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/img/banners');
            $img = Image::make($image->getRealPath());

            //$img->resize(544, 600, function ($constraint) {
            $img->resize(555, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['banner_img']);
//        $img->resize(100, 100, function ($constraint) {
            /* $img->resize(544, 600, function ($constraint) {
              $constraint->aspectRatio();
              })->save($destinationPath.'/'.$input['banner_img']); */

//            $img->resize(544, 600)->save($destinationPath . '/' . $input['banner_img']);
            $img->resize(555, 600)->save($destinationPath . '/' . $input['banner_img']);
            $destinationPath = public_path('/img/banners/thumbs');
            $image->move($destinationPath, $input['banner_img']);
            if ($input['banner_img'] != '') {
                if (file_exists(public_path('/img/banners') . '/' . $request->banner_img_old)) {
                    unlink(public_path('/img/banners') . '/' . $request->banner_img_old); // correct
                    unlink(public_path('/img/banners/thumbs') . '/' . $request->banner_img_old); // correct
                }
                $bannerImg = $input['banner_img'];
            }
        }

        $bannerTrans = BannerTrans::where('banner_id', $banner->id)->where('lang', 'en')->first();
        if (empty($bannerTrans)) {
            $bannerTrans = new BannerTrans;
            $bannerTrans->banner_id = $banner->id;
            $bannerTrans->lang = 'en';
        }
        if(empty($bannerImg)){
            $bannerTrans->banner_img = $bannerTrans->banner_img;
        }else{
            $bannerTrans->banner_img = $bannerImg;
        }
        $bannerTrans->name = $request->name;
        $bannerTrans->save();

        $response = ['message' => trans('Banners::banners.updated_successfully')];
        return response()->json($response, 201);
    }

}
