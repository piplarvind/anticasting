<?php

namespace Piplmodules\Banners\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Banners\Controllers\BannersApiController as API;
use Piplmodules\Banners\Models\Banner;
use Piplmodules\Banners\Models\BannerTrans;

class BannersController extends BannersApiController
{

    /*
   |--------------------------------------------------------------------------
   | piplmodules Banners Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles Banners for the application.
   |
   */
    public function __construct()
    {
        $this->api = new API;
    }

    /**
     * @param
     * @return
     */
    public function index(Request $request)
    {
        $request->request->add(['paginate' => 10]);
        $items = $this->api->listItems($request);

        return view('Banners::banners.index', compact('items'));
    }

    /**
     * @param
     * @return
     */
    public function create()
    {
        return view('Banners::banners.create-edit');
    }


    /**
     * @param
     * @return
     */
    public function store(Request $request)
    {
        $store = $this->api->storeBanner($request);
        $store = $store->getData();

        if (isset($store->errors)) {
            return back()->withInput()->withErrors($store->errors);
        }

        session()->flash('alert-class', 'alert-success');
        session()->flash('message', $store->message);

        if($request->back){
            return back();
        }
        return redirect(action('\Piplmodules\Banners\Controllers\BannersController@index'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function edit($id)
    {
//        $item = Banner::findOrFail($id);
        $item = Banner::findOrFail($id);
        $trans = BannerTrans::where('banner_id', $id)->get()->keyBy('lang')->toArray();
        return view('Banners::banners.create-edit', compact('item','trans'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function update(Request $request, $id)
    {
        $update = $this->api->updateBanner($request, $id);
        $update = $update->getData();
        if (isset($update->errors)) {
            return back()->withInput()->withErrors($update->errors);
        }
        session()->flash('alert-class', 'alert-success');
        session()->flash('message', $update->message);

        if ($request->back) {
            return back();
        }
        return redirect(action('\Piplmodules\Banners\Controllers\BannersController@index'));
    }


    /**
     * Delete single banner
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function deleteBanner($id)
    {
        $banner = Banner::find($id);
        if (isset($banner)) {
            $banner->delete();
            request()->session()->flash('alert-class', 'alert-success');
            request()->session()->flash('message', 'Banner deleted successfully.');
        } else {
            request()->session()->flash('alert-class', 'alert-info');
            request()->session()->flash('message', 'No record found for selected item.');
        }
        return redirect()->route('admin.banners');
    }
    /**
     *
     *
     * @param
     * @return
     */
    public function confirmDelete($id)
    {
        $item = Page::findOrFail($id);
        return view('Banners::ads.confirm-delete', compact('item'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function bulkOperations(Request $request)
    {
        if ($request->ids) {
            $items = Banner::whereIn('id', $request->ids)->get();
            if ($items->count()) {
                foreach ($items as $item) {
                    // Do something with your model by filter operation
                    if ($request->operation && $request->operation === 'activate') {
                        $item->active = true;
                        $item->save();
                        session()->flash('message', trans('Core::operations.activated_successfully'));
                    } elseif($request->operation && $request->operation === 'deactivate') {
                        $item->active = false;
                        $item->save();
                        session()->flash('message', trans('Core::operations.deactivated_successfully'));
                    }

                }
            }
            session()->flash('alert-class', 'alert-success');
        } else {
            session()->flash('alert-class', 'alert-warning');
            session()->flash('message', trans('Core::operations.nothing_selected'));
        }
        return back();
    }

    //change banner status
    public function changeBannerStatus(Request $request)
    {
        if ($request->banner_id != "") {
            $banner = Banner::find($request->banner_id);
            if (isset($banner)) {
                $banner->active = $request->status;
                $banner->save();
                echo json_encode(array("error" => "0"));
            } else {
                echo json_encode(array("error" => "1"));
            }
        } else {
            /* if something going wrong providing error message.  */
            echo json_encode(array("error" => "1"));
        }
    }

}