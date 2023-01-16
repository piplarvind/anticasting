<?php
namespace Piplmodules\Pages\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Piplmodules\Pages\Models\Page;
use Piplmodules\Pages\Models\PageTrans;
use Illuminate\Support\Facades\Input;
use Auth;
use Image;

class PagesApiController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | piplmodules Pages API Controller
   |--------------------------------------------------------------------------
   |
   */

    /**
     *
     *
     * @param
     * @return
     */
    public function validatation($request)
    {

        $languages = config('piplmodules.locales');
       $rules['name_en'] = 'required';
       $rules['description_en'] = 'required';
//        $rules['page_status'] = 'required';
        $rules['page_url'] = 'unique:pages';
        $rules = [];
        if(count($languages)) {
            foreach ($languages as $key => $language) {
                $code = $language['code'];
                if($request->language){
                    foreach($request->language as $lang){
                        $rules['name_'.$code.''] = 'required|max:40';
                        $rules['description_'.$code.''] = 'required|min:10';
                    }
                }
            }
        }

        $rules['top_image_en'] = 'mimes:jpeg,jpg,png|max:10000';
        return \Validator::make($request->all(), $rules);
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function listStaticItems(Request $request)
    {
        $pages = Page::FilterName()->FilterCategory()->FilterSection()->FilterStatus()->orderBy('id', 'DESC')->paginate($request->get('paginate'));
        //$pages->appends(Input::except('page'));
        return $pages;
    }

    
      public function listItems(Request $request)
    {
        $pages = Page::FilterName()->FilterCategory()->FilterSection()->FilterStatus()->orderBy('id', 'DESC')->paginate($request->get('paginate'));
        //$pages->appends(Input::except('page'));
        return $pages;
    }
    
    
    /**
     *
     *
     * @param
     * @return
     */
    public function storePage(Request $request)
    {
        $validator = $this->validatation($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $page = new Page;
        if ($request->author) {
            $author = $request->author;
        } else {
            $author = Auth::user()->id;
        }
        $page->page_url = $this->seoUrl($request->name_en);
        $page->active = false;
        if ($request->active) {
            $page->active = true;
        }
        $page->static = true;
        $page->published = true;
        $page->created_by = $author;
        $page->updated_by = $author;
        $page->save();

        foreach ($request->language as $langCode) {
            $name = 'name_'.$langCode;
            $description = 'description_'.$langCode;
            $page_seo_title = 'page_seo_title_'.$langCode;
            $page_meta_keywords = 'page_meta_keywords_'.$langCode;
            $page_meta_description = 'page_meta_description_'.$langCode;
            //transaction entry
            $pageTrans = new PageTrans;
            $pageTrans->page_id = $page->id;
            $pageTrans->title = $request->$name;
            $pageTrans->body = $request->$description;
            $pageTrans->page_seo_title = $request->$page_seo_title;
            $pageTrans->page_meta_keywords = $request->$page_meta_keywords;
            $pageTrans->page_meta_descriptions = $request->$page_meta_description;
            $pageTrans->lang = $langCode;
            $pageTrans->save();
        }

        $response = ['message' => "Record updated successfully"];
        return response()->json($response, 201);
    }
// Get SEO URL function here
    function seoUrl($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updatePage(Request $request, $apiKey = '', $id)
    {
        $validator = $this->validatation($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = Page::find($id);
        if ($request->author) {
            $author = $request->author;
        } else {
            $author = Auth::user()->id;
        }
//        $page->page_url = strtolower($request->name_en);
        $page->active = false;
        if ($request->active) {
            $page->active = true;
        }
        //$page->static = true;
        //$page->published = true;
        $page->updated_by = $author;
        $page->save();


        // Translation
        foreach ($request->language as $langCode) {
            $name = 'name_' . $langCode;
            $description = 'description_' . $langCode;
            $page_seo_title = 'page_seo_title_' . $langCode;
            $page_meta_keywords = 'page_meta_keywords_' . $langCode;
            $page_meta_description = 'page_meta_description_' . $langCode;
            $pageTrans = PageTrans::where('page_id', $page->id)->where('lang', $langCode)->first();
            if (empty($pageTrans)) {
                $pageTrans = new ActivityTrans;
                $pageTrans->page_id = $page->id;
                $pageTrans->lang = $langCode;
            }
            $pageTrans->title = $request->$name;
            $pageTrans->body = $request->$description;
            $pageTrans->page_seo_title = $request->$page_seo_title;
            $pageTrans->page_meta_keywords = $request->$page_meta_keywords;
            $pageTrans->page_meta_descriptions = $request->$page_meta_description;

            if($request->has('top_image_en')) {
                $file = $request->top_image_en;
                //get file extension
                $extension = $file->getClientOriginalExtension();

                //filename to store
                $filenametostore = time() . '.' . $extension;

                $storage_path = public_path('/img/cms-images/');

                //Upload file
                $uploadpath = $storage_path . $filenametostore;
                $file->move($storage_path, $uploadpath);

                if (file_exists($storage_path . $pageTrans->top_image)) {
                    @unlink($storage_path . $pageTrans->top_image);
                    @unlink($storage_path . 'thumbnail/' . $pageTrans->top_image);
                    @unlink($storage_path . 'thumbnail/small/' . $pageTrans->top_image);
                }

                //Resize image here
                $thumbnailpath = $storage_path . 'thumbnail/' . $filenametostore;
                $image_resize = Image::make($uploadpath);
                $image_resize->resize(1000, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image_resize->save($thumbnailpath);

                //Small resize
                $thumbnailsmallpath = $storage_path . 'thumbnail/small/' . $filenametostore;
                $image_resize = Image::make($uploadpath);
                $image_resize->resize(150, 80, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image_resize->save($thumbnailsmallpath);

                $pageTrans->top_image = $filenametostore;

                @unlink($storage_path . $filenametostore);
            }

            $pageTrans->save();
        }
        $response = ['message' => "Record updated successfully"];
        return response()->json($response, 201);
    }

    
}