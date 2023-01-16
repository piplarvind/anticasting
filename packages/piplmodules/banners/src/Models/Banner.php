<?php

namespace Piplmodules\Banners\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class Banner extends Model {

    protected $table = 'banners';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
//    protected $with = ['trans'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $hidden = ['options', 'created_by', 'updated_by'];
    protected $with = ['trans', 'author', 'lastUpdateBy'];

    protected $casts = [
        'options' => 'array',
    ];
    /**
     * Translation relation.
     *
     *
     */
    public function trans()
    {
        return $this->hasOne('\Piplmodules\Banners\Models\BannerTrans', 'banner_id')->where('lang', Lang::getlocale())->select(['banner_id', 'name', 'banner_img','url']);
    }

    /**
     * Author relation.
     */
    public function author() {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'created_by')->select(['id', 'name']);
    }

    /**
     * Get author attribute
     */
    public function getlastUpdateByAttribute() {
        return $this->lastUpdateBy();
    }

    /**
     * lastUpdateBy relation.
     */
    public function lastUpdateBy() {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'updated_by')->select(['id', 'name']);
    }

    /**
     * Main image relation.
     */
    public function mainImage() {
        $mediaOptions = '';
        $options = $this->options;

        if ($options && $options['media'] && isset($options['media']['main_image_id'])) {
            $mainImageId = $options['media']['main_image_id'];
            $media = \Piplmodules\Media\Models\Media::find($mainImageId);
            if ($media) {
                $id = $media->id;
                $styles = $media->options['styles'];
                $mediaOptions = ['id' => $id, 'styles' => $styles];
            }
        }

        return (object) $mediaOptions;
    }

    /**
     * Gallery relation.
     */
    public function gallery() {
        $mediaOptions = [];
        $options = $this->options;

        if ($options && $options['media'] && isset($options['media']['gallery_images'])) {
            $galleryImagesIds = $options['media']['gallery_images'];
            $media = \App\Media::whereIn('id', $galleryImagesIds)->get();

            if ($media) {
                foreach ($media as $image) {
                    $id = $image->id;
                    $styles = $image->options['styles'];
                    $mediaOptions[] = ['id' => $id, 'styles' => $styles];
                }
            }
        }

        return (object) $mediaOptions;
    }

    /**
     * Get media attribute.
     */
    public function getMediaAttribute() {

        return (object) ['main_image' => $this->mainImage(), 'gallery' => $this->gallery()];
    }

    /**
     * Scope a query to only include filterd ads name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterName($query) {
        $getName = '';
        if(isset($_GET['name']) && !empty($_GET['name'])){
            $getName = $_GET['name'];
            return $query->whereHas('trans', function($q) use ($getName){
                $q->where('name', 'LIKE', '%'.$getName.'%');
            });
        }
    }

    /**
     * Scope a query to only include filterd ads status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterStatus($query) {
        $getStatus = '';
        //dd($_GET['status']);
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $getStatus = $_GET['status'];
            if ($getStatus == 2) {
                $getStatus = false;
            }
            return $query->where('active', $getStatus);
        }
    }

}
