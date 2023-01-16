<?php

namespace Piplmodules\Media\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\File;
// use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Piplmodules\Media\Models\Media;

class MediaApiController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Piplmodules Media API Controller
      |--------------------------------------------------------------------------
      |
      |
     */

    /**
     * @apiDefine MediaNotFoundError [NotFound] [not found api]
     *
     * @apiError MediaNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "MediaNotFound"
     *     }
     */

    /**
     * @api {get} /api/media Media list.
     * @apiVersion 0.1.0
     * @apiName MediaList
     * @apiGroup Media
     *
     * @apiParam {Number} [id] Media unique ID.
     * @apiParam {Integer} [paginate] set number of items per page.
     *
     * @apiSuccess {Integer} total  total media items.
     * @apiSuccess {Integer} per_page  how many itemrs to show per page.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "total": 20,
     *       "per_page": 15
     *     }
     *
     * @apiUse MediaNotFoundError
     */
    public function listAll(Request $request) {
        $paginate = 40;
        if ($request->get('paginate')) {
            $paginate = $request->get('paginate');
        }
        $media = Media::select();
        if ($request->q) {
            //$media->where(\DB::raw("CONCAT(`title`, ' ', `caption`, ' ', `alt`, ' ', `description`)"), 'LIKE', '%' . $request->q . '%')
            // ->orWhere('caption', 'LIKE', '%'.$request->q.'%')
            // ->orWhere('alt', 'LIKE', '%'.$request->q.'%')
            // ->orWhere('description', 'LIKE', '%'.$request->q.'%');
            $media->orWhere('title', 'LIKE', '%'.$request->q.'%')
                ->orWhere('description', 'LIKE', '%'.$request->q.'%');
        }

        if(auth()->user() && (auth()->user()->userRole->role_id != '3' && auth()->user()->userRole->role_id != '4')){
            $media->where('uploaded_by',auth()->user()->id);
        }

        $media = $media->orderBy('id', 'desc')->paginate($paginate);
        foreach ($media as $item) {
            $item->url = url($item->file);
        }
//        dd($media);
        return $media;
    }

    /**
     * @api {post} /media/:id Media upload.
     * @apiVersion 0.1.0
     * @apiName UploadMedia
     * @apiGroup Media
     *
     * @apiParam {Number} id Medias unique ID.
     *
     * @apiSuccess {String} firstname  Firstname of the Media.
     * @apiSuccess {String} lastname   Lastname of the Media.
     * @apiSuccess {Date}   registered Date of Registration.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "firstname": "John",
     *       "lastname": "Doe"
     *     }
     *
     * @apiError (501) {String} var2 Some description.
     * @apiError (1501) {String} var3 Some description.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "MediaNotFound"
     *     }
     */
    public function uploadFile(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'file' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 0, 'errors' => $validation->errors()], 422);
        }

        $file = $request->file;
        $destinationPath = public_path('uploads');
        $randomName = date('Y-M-d--h--i--sa') . '-' . Str::random(5) . '-' . $file->getClientOriginalName();

        $media = new Media;
        $media->title = $file->getClientOriginalName();
        $media->mime_type = $file->getMimeType();
        $media->extension = $file->getClientOriginalExtension();
        $media->file_size = \filesize($file);

        $movedFile = $file->move($destinationPath, $randomName);
        $media->file = $movedFile;

        // Options
        $options = $media->options;
        $mainPath = 'uploads/' . $randomName;
        $options['styles']['main'] = $mainPath;
        // Languages
        $languages = [
            'en'
        ];
        foreach ($languages as $lang) {
            $options['trans'][$lang]['title'] = $media->name;
            $options['trans'][$lang]['caption'] = 'file caption';
            $options['trans'][$lang]['alt'] = 'image alt';
        }

        // Styles
        $styles = ['thumbnail', 'medium', 'large'];

        foreach ($styles as $style) {
            $options['styles'][$style] = '/' . $style . '/' . $randomName;
        }
        // create an image manager instance with favored driver
        //$imageManager = new ImageManager(array('driver' => 'GD'));
        //small
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


        $media->options = $options;
        if (auth()->user()) {
            $media->uploaded_by = auth()->user()->id;
        }
        $media->save();

        /*$response = [
            'status' => 1,
            'message' => 'Uploaded successfully'
        ];
        return $response;*/
        $response = ['message' => 'Uploaded successfully'];
        return response()->json($response, 201);
    }

    /*
     *
     */

    public function uploadFiles(Request $request, $user_id = "") {
        $data = [];
        foreach ($request->files as $file) {
            $destinationPath = public_path('uploads');
            $randomName = date('Y-M-d--h--i--sa') . '-' . Str::random(5) . '-' . $file->getClientOriginalName();

            $media = new Media;
            $media->title = $file->getClientOriginalName();
            $media->mime_type = $file->getMimeType();
            $media->extension = $file->getClientOriginalExtension();
            $media->filename = $file->getClientOriginalName();
            $media->file_size = $this->formatSizeUnits(\filesize($file));
            $movedFile = $file->move($destinationPath, $randomName);
            $media->file = $movedFile;

            // Options
            $options = $media->options;
            $mainPath = 'uploads/' . $randomName;
            $options['styles']['main'] = $mainPath;
            // Images only 
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

    public function uploadFrontFiles(Request $request, $user_id = "") {
        $data = [];

        foreach ($request->files as $file) {
            if (is_array($file)) {
                foreach ($file as $f) {

                    $destinationPath = public_path('uploads');
                    $randomName = date('Y-M-d--h--i--sa') . '-' . Str::random(5) . '-' . $f->getClientOriginalName();

                    $media = new Media;
                    $media->title = $f->getClientOriginalName();
                    $media->mime_type = $f->getMimeType();
                    $media->extension = $f->getClientOriginalExtension();
                    $media->filename = $f->getClientOriginalName();
                    $media->file_size = $this->formatSizeUnits(\filesize($f));
                    $movedFile = $f->move($destinationPath, $randomName);
                    $media->file = $movedFile;

                    // Options
                    $options = $media->options;
                    $mainPath = 'uploads/' . $randomName;
                    $options['styles']['main'] = $mainPath;
                    // Images only 
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
                    $media->multiple_images_present = true;

                    $data[] = $media;
                }
//                rsort($data);
                $response = [
                    'status' => 1,
                    'message' => 'Uploaded successfully'
                ];
//                }
            } else {

                $destinationPath = public_path('uploads');
                $randomName = date('Y-M-d--h--i--sa') . '-' . Str::random(5) . '-' . $file->getClientOriginalName();

                $media = new Media;
                $media->title = $file->getClientOriginalName();
                $media->mime_type = $file->getMimeType();
                $media->extension = $file->getClientOriginalExtension();
                $media->filename = $file->getClientOriginalName();
                $media->file_size = $this->formatSizeUnits(\filesize($file));
                $movedFile = $file->move($destinationPath, $randomName);
                $media->file = $movedFile;

//                foreach ($request->files as $file) {

                // Options
                $options = $media->options;

                // Images only
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
                $media->main_image_images_present = true;

                $data[] = $media;
                //}
//                rsort($data);
                $response = [
                    'status' => 1,
                    'message' => 'Uploaded successfully'
                ];

            }
        }
        return $data;
    }

    /**
     * Helper
     *
     * @param
     * @return
     */
    function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function updateFile(Request $request, $id)
    {
        $media = Media::find($id);
        $media->title = $request->title;
//        $media->caption = $request->caption;
//        $media->alt = $request->alt;
        $media->description = $request->description;
        $media->save();

        $response = [
            'status' => 1,
            'message' => 'Updated successfully'
        ];
        return $response;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function deleteFile($id) {
        $media = Media::findOrFail($id);
        // Delete all styles
        if (isset($media->options['styles'])) {
            foreach ($media->options['styles'] as $key => $value) {
                if (file_exists($value)) {
                    chmod($value, 0644);
                    unlink($value);
                }
            }
        }
        if (file_exists($media->file)) {
            // Delete original files
            chmod($media->file, 0644);
            unlink($media->file);
        }
        $media->delete();

        $response = [
            'status' => 1,
            'message' => 'Deleted successfully'
        ];
        return $response;
    }

}
