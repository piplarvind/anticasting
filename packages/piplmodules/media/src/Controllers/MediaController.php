<?php

namespace Piplmodules\Media\Controllers;

use Illuminate\Http\Request;
use Piplmodules\Media\Controllers\MediaApiController as API;
use Piplmodules\Media\Models\Media;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Auth;

class MediaController extends MediaApiController
{

    /*
   |--------------------------------------------------------------------------
   | Piplmodules Media Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles Media for the application.
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
        $items = $this->api->listAll($request);
        return view('Media::index', compact('items'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function upload()
    {
        return view('Media::upload');
    }


    /**
     *
     *
     * @param
     * @return
     */
    public function storeFile(Request $request)
    {
        $storeFile = $this->api->uploadFile($request);

        /*if(isset($storeFile['errors'])){
            return back()->with('errors', $store['errors']);
        }*/
        $storeFile = $storeFile->getData();
        if (isset($storeFile->errors)) {
            return back()->withInput()->withErrors($storeFile->errors);
        }

        session()->flash('alert-class', 'alert-success');
        session()->flash('message', 'Image uploaded successfully.');
        return redirect()->route('admin.media');
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function edit($id)
    {
        $media = Media::findOrFail($id);
        return view('Media::edit', compact('media'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function update(Request $request, $id)
    {
        $updateFile = $this->api->updateFile($request, $id);
        if(isset($updateFile['errors'])){
            return back()->with('errors', $updateFile['errors']);
        }

        session()->flash('alert-class', 'alert-success');
        session()->flash('message', $updateFile['message']);
        return redirect()->route('admin.media');
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function confirmDelete($id)
    {
        $media = Media::findOrFail($id);
        return view('Media::confirm-delete', compact('media'));
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function delete($id)
    {
        $deleteFile = $this->api->deleteFile($id);
        if(isset($deleteFile['errors'])){
            return back()->with('errors', $deleteFile['errors']);
        }

        session()->flash('alert-class', 'alert-success');
        session()->flash('message', $deleteFile['message']);
        return redirect('/media');
    }


    /**
     * Created a new function to fetch image from url
     */
    public function fetchImageUrlToGallery(Request $req){
        $img = $req->url;
        $imgData = @file_get_contents($img);

        if($imgData){
            $arrFileName = explode('/',$img);
            $fileOriName = end($arrFileName);
            $arrFileName = explode('.',$fileOriName);
            $ext=end($arrFileName);

            $destinationPath = public_path('uploads');
            $randomName = date('Y-M-d--h--i--sa') . '-' . str_random(5) . '-' . $fileOriName;

            // Move file to destination
            $fp=@fopen($destinationPath."/".$randomName,"w+");
            @fwrite($fp,$imgData);
            @fclose($fp);

            $file = new \Illuminate\Http\File($destinationPath."/".$randomName);

            $media = new Media;
            $media->title = $fileOriName;
            $media->mime_type = $file->getMimeType();
            $media->extension = $ext;
            $media->filename = $fileOriName;
            $media->file_size = $this->formatSizeUnits(\filesize($destinationPath."/".$randomName));

            $movedFile = $destinationPath."/".$randomName;

            $media->file = $movedFile;

            $options = $media->options;

            if (getimagesize($movedFile)) {
                list($media->width, $media->height) = getimagesize($movedFile);

                // Styles
                $styles = ['thumbnail', 'medium', 'large'];

                foreach ($styles as $style) {
                    $options['styles'][$style] = '/' . $style . '/' . $randomName;
                }
                // create an image manager instance with favored driver
                // Small style
                $smallPath = 'uploads/small/' . $randomName;
                $small = Image::make($movedFile)->fit(150);
                File::exists(public_path('uploads/small')) or File::makeDirectory(public_path('uploads/small'));
                $small->save(public_path('uploads/small/'). $randomName, 100);
                $options['styles']['small'] = $smallPath;

                // Thumbnail style
                $thumbnailPath = 'uploads/thumbnail/' . $randomName;
                $thumbnail = Image::make($movedFile)->fit(300);
                File::exists(public_path('uploads/thumbnail')) or File::makeDirectory(public_path('uploads/thumbnail'));
                $thumbnail->save(public_path('uploads/thumbnail/'). $randomName, 100);
                $options['styles']['thumbnail'] = $thumbnailPath;

                // Medium style
                $mediumPath = 'uploads/medium/' . $randomName;
                $medium = Image::make($movedFile)->fit(380, 180);
                File::exists(public_path('uploads/medium')) or File::makeDirectory(public_path('uploads/medium'));
                $medium->save(public_path('uploads/medium/'). $randomName, 100);
                $options['styles']['medium'] = $mediumPath;

                // Large style
                $largePath = 'uploads/large/' . $randomName;
                $large = Image::make($movedFile)->fit(652, 470);
                File::exists(public_path('uploads/large')) or File::makeDirectory(public_path('uploads/large'));
                $large->save(public_path('uploads/large/'). $randomName, 100);
                $options['styles']['large'] = $largePath;
            }

            $media->options = $options;

            if (auth()->user()) {
                $media->uploaded_by = auth()->user()->id;
            }
//            
            $media->save();
            $media->url = url($media->file);

            $data[] = $media;

        }

        rsort($data);
        $response = [
            'status' => 1,
            'message' => 'Uploaded successfully'
        ];
        return $data;


    }
}