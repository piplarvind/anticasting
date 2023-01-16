<?php
namespace Piplmodules\Emailtemplates\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EmailTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        #1
        \DB::table('email_templates')->insert([
            'created_by' => 1,
            'updated_by' => 1,
            'active' => 1
        ]);

        \DB::table('email_templates_trans')->insert([
            'etemplate_id' => 1,
            'subject' => 'Registration Successful',
            'lang' => 'en',
            'html_content' => '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="height:80px">
                                <p>&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><a href="https://rakeshmandal.com" target="_blank"><img alt="logo" src="http://payzz.com/public/backend/images/logo.png" style="width:150px" /> </a></td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:95%">
                                    <tbody>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <p>Hi {{$FIRST_NAME}} {{$LAST_NAME}}</p>
        
                                            <p>Welcome you in {{$SITE_TITLE}} Family!</p>
        
                                            <p>Please <a href="{{$ACTIVATION_LINK}}"><em>&nbsp;</em><strong>click here</strong><em>&nbsp;</em></a> to activate your account to login and send money.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">
                                <p>&copy; <strong>www.PAYzz.com</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!--/100% body table-->',
            'template_key' => 'active-user',
            'template_keywords' => null,
            'status' =>1
        ]);

        #2
        \DB::table('email_templates')->insert([
            'created_by' => 1,
            'updated_by' => 1,
            'active' => 1
        ]);

        \DB::table('email_templates_trans')->insert([
            'etemplate_id' => 2,
            'subject' => 'Forgot Password',
            'lang' => 'en',
            'html_content' => '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><a href="https://rakeshmandal.com" target="_blank"><img alt="logo" src="http://payzz.com/public/backend/images/logo.png" style="width:150px" /> </a></td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:95%">
                                    <tbody>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <h1>You have requested to reset your password</h1>
        
                                            <p>Hi {{$FIRST_NAME}} {{$LAST_NAME}}<br />
                                            We cannot simply send you your old password. A unique link to reset your password has been generated for you. To reset your password, click the following link and follow the instructions.</p>
                                            <a href="{{$RESET_LINK}}">Reset Password</a></td>
                                        </tr>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">
                                <p>&copy; <strong>www.PAYzz.com</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!--/100% body table-->>',
            'template_key' => 'forgot-password',
            'template_keywords' => null,
            'status' =>1
        ]);

        #3
        \DB::table('email_templates')->insert([
            'created_by' => 1,
            'updated_by' => 1,
            'active' => 1
        ]);

        \DB::table('email_templates_trans')->insert([
            'etemplate_id' => 3,
            'subject' => 'Admin Contacted',
            'lang' => 'en',
            'html_content' => '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><a href="https://rakeshmandal.com" target="_blank"><img alt="logo" src="http://payzz.com/public/backend/images/logo.png" style="width:150px" /> </a></td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:95%">
                                    <tbody>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <p>Hi {{$userName }}</p>
        
                                            <p>Reply from {{$SITE_TITLE}}</p>
        
                                            <p>{{ $messageContent }}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">
                                <p>&copy; <strong>www.PAYzz.com</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!--/100% body table-->',
            'template_key' => 'admin-contacted',
            'template_keywords' => null,
            'status' =>1
        ]);

        #4
        \DB::table('email_templates')->insert([
            'created_by' => 1,
            'updated_by' => 1,
            'active' => 1
        ]);

        \DB::table('email_templates_trans')->insert([
            'etemplate_id' => 4,
            'subject' => 'Contact Request',
            'lang' => 'en',
            'html_content' => '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><a href="https://rakeshmandal.com" target="_blank"><img alt="logo" src="http://payzz.com/public/backend/images/logo.png" style="width:150px" /> </a></td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:95%">
                                    <tbody>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <p>Hi,</p>
        
                                            <p>{{$userName}} has contacted you on {{$contactDate}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">
                                <p>&copy; <strong>www.PAYzz.com</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!--/100% body table-->',
            'template_key' => 'contact-request-reply',
            'template_keywords' => null,
            'status' =>1
        ]);

        #5
        \DB::table('email_templates')->insert([
            'created_by' => 1,
            'updated_by' => 1,
            'active' => 1
        ]);

        \DB::table('email_templates_trans')->insert([
            'etemplate_id' => 5,
            'subject' => 'User Contacted',
            'lang' => 'en',
            'html_content' => '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
            <tbody>
                <tr>
                    <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center"><a href="https://rakeshmandal.com" target="_blank"><img alt="logo" src="http://payzz.com/public/backend/images/logo.png" style="width:150px" /> </a></td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:95%">
                                    <tbody>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <p>Hi,</p>
        
                                            <p>{{$userName}} has contacted you on {{$contactDate}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:40px">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">
                                <p>&copy; <strong>www.PAYzz.com</strong></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:80px">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!--/100% body table-->',
            'template_key' => 'user-contacted',
            'template_keywords' => null,
            'status' =>1
        ]);



    }
}
