<?php

namespace Piplmodules\Emailtemplates\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

class EmailTemplateTrans extends Model {

    protected $table = 'email_templates_trans';
    protected $hidden = ['etemplate_id'];


}
