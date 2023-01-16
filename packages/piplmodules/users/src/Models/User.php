<?php

namespace Piplmodules\Users\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Special data types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'middle_name', 'email', 'password', 'user_type', 'account_status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'active', 'created_by', 'updated_by', 'confirmation_code', 'created_at', 'updated_at', 'main_image_id', 'options'];

    /**
     * The relationships attributes that are needed.
     *
     * @var array
     */
    protected $with = ['userRole'];

    /**
     * Roles relation.
     *
     *
     */
    public function userRole()
    {
        return $this->hasOne('Piplmodules\Users\Models\UserRole', 'user_id');
    }

    public function getProfileImage()
    {
        return $this->hasOne('Piplmodules\Users\Models\UserRole', 'uploaded_by');
    }


    /**
     * Main image relation.
     */
    public function mainImage()
    {
        $mediaOptions = '';
        $options = $this->options;

        if($options && $options['media'] && isset($options['media']['main_image_id'])){
            $mainImageId = $options['media']['main_image_id'];


            $media = \Piplmodules\Media\Models\Media::find($mainImageId);


            if($media){
                $id = $media->id;
                $file = $media->file;
                $styles = $media->options['styles'];
                $mediaOptions = ['id' => $id, 'styles' => $styles, 'file' => $file];

            }
        }

//        return $this->mediaOptions;
        return (object) $mediaOptions;
    }

    /**
     * Get media attribute.
     */
    public function getMediaAttribute()
    {

        return (object) ['main_image' => $this->mainImage()];
    }

    /**
     * Author relation.
     */
    public function author()
    {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'created_by')->select(array('id', 'name'));
    }

    /**
     * Author relation.
     *
     *
     */
    public function lastUpdatedBy()
    {
        return $this->belongsTo('Piplmodules\Users\Models\User', 'updated_by')->select(array('id', 'name'));
    }

    /**
     * Account Relation.
     *
     *
     */
    // public function userAccount()
    // {
    //     return $this->hasOne('App\Account', 'user_id');
    // }

    /**
     * Scope a query to only include filterd ads name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterName($query)
    {
        $getName = '';
        if(isset($_GET['name']) && !empty($_GET['name'])){
            $getName = $_GET['name'];
            return $query->where('first_name', 'LIKE', '%'.$getName.'%')->orwhere('last_name', 'LIKE', '%'.$getName.'%');
        }
    }
    public function scopeFilterStatus($query) {
        $getStatus = '';
        //dd($_GET['status']);
        if(isset($_GET['status']) && !empty($_GET['status'])){
            if($_GET['status'] == 1){
                $getStatus = '1';
            }else{
                $getStatus = '0';
            }
            return $query->where('account_status', $getStatus);
        }
    }

    /**
     * Scope a query to only include filterd ads name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterRole($query, $roleId)
    {
        if($roleId == 3) {
            return $query->whereHas('userRole', function ($query) use ($roleId) {
                $query->where('role_id', $roleId);
            });
        }
        elseif($roleId == 4)
        {
            return $query->whereHas('userRole', function ($query) use ($roleId) {
                $query->where('role_id', $roleId);
            });
        }
        else{
            return $query->whereHas('userRole', function ($query) use ($roleId) {
                $query->where('role_id', '!=', 3);
            });
        }
    }

    public function scopeFilterSubAdmin($query)
    {
        return $query->whereHas('userRole', function ($query) {
            $query->where('role_id', 2);
        });
    }


    /*public function hasPermission()
    {
        return $this->hasMany('Piplmodules\Users\Models\PermissionUser', 'user_id');
    }*/

    public function hasRole()
    {
        return $this->hasOne('Piplmodules\Users\Models\UserRole', 'user_id')->select("role_id");

    }

    public function userInformation()
    {
        return $this->hasOne('App\Models\UserInformation', 'user_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }   
}
