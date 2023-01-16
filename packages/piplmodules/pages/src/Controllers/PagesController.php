<?php 
namespace Piplmodules\Pages\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Pages\Controllers\PagesApiController as API;
use Piplmodules\Pages\Models\Page;
use Piplmodules\Pages\Models\PageTrans;
use Illuminate\Support\Facades\Lang;
//use Piplmodules\Pages\Models\Section;

class PagesController extends PagesApiController
{

 	/*
    |--------------------------------------------------------------------------
    | piplmodules Pages Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles Pages for the application.
    |
    */
    public function __construct()
    {
        $this->api = new API;
    }

    /**
     * 
     *
     * @param  
     * @return 
     */
    public function index(Request $request)
    {
        $request->request->add(['paginate' => 20]);
        $items = $this->api->listStaticItems($request);
//        $sections = Section::get();
//        dd($items);
        return view('Pages::pages.index', compact('items'));
    }

     public function dynamic(Request $request)
    {
        $request->request->add(['paginate' => 20]);
        $items = $this->api->listItems($request);
//        $sections = Section::get();
        return view('Pages::pages.dynamic-index', compact('items', 'sections'));
    }
    
    
    /**
     * 
     *
     * @param  
     * @return 
     */
    public function create()
    {
//        $sections = Section::get();
        return view('Pages::pages.create-edit', compact('sections'));
    }


    /**
     * 
     *
     * @param  
     * @return 
     */
    public function store(Request $request)
    {
        $store = $this->api->storePage($request);
        $store = $store->getData();
        
        if(isset($store->errors)){
            return back()->withInput()->withErrors($store->errors);
        }

        \Session::flash('alert-success', $store->message);

        if($request->back){
            return back();
        } 
        return redirect(Lang::getlocale() . "/" . 'admin/pages/dynamic');
    }

    /**
     * 
     *
     * @param  
     * @return 
     */
    public function edit($id)
    {
        $item = Page::findOrFail($id);
//        $sections = Section::get();
        return view('Pages::pages.create-edit', compact('item'));
    }

    /**
     * 
     *
     * @param  
     * @return 
     */
    public function update(Request $request, $id)
    {

        $update = $this->api->updatePage($request, '', $id);
        $update = $update->getData();
        
        if(isset($update->errors)){
            return back()->withInput()->withErrors($update->errors);
        }
        \Session::flash('alert-success', $update->message);
        
        if($request->back){
            return back();
        } 
        return redirect( 'admin/pages');
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
        return view('Pages::ads.confirm-delete', compact('item'));
    }

    /**
     * 
     *
     * @param  
     * @return 
     */
    public function bulkOperations(Request $request)
    {
        if($request->ids){
            $items = Page::whereIn('id', $request->ids)->get();
            if($items->count()){
                foreach ($items as $item) {
                    // Do something with your model by filter operation
                    if($request->operation && $request->operation === 'activate'){
                        $item->active = true;
                        $item->save();
                        \Session::flash('alert-success', trans('Core::operations.activated_successfully')); 
                    }elseif($request->operation && $request->operation === 'deactivate'){
                        $item->active = false;
                        $item->save();
                        \Session::flash('alert-success', trans('Core::operations.deactivated_successfully')); 
                    }

                }
            }
            
        }else{
            \Session::flash('alert-danger', trans('Core::operations.nothing_selected')); 
        }
        return back();
    }

    public function removeCmsPageImage($id)
    {
        $langCode = 'en';
        $item = PageTrans::where('page_id', $id)->where('lang', $langCode)->first();
        
        if(isset($item)){
            $storage_path = public_path('/img/cms-images/');
            
            $item->top_image = null;
            $item->save();
            @unlink($storage_path . $item->top_image);
            @unlink($storage_path . 'thumbnail/' . $item->top_image);
            @unlink($storage_path . 'thumbnail/small/' . $item->top_image);
            
            \Session::flash('alert-success', "Image removed successfully"); 
        }else{
            \Session::flash('alert-danger', "Something went wrong. Please try again"); 
        }
        return back();
    }
}