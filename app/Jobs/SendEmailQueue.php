<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmailQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $template_name;
    private $arr_keyword_values;
    private $user_email;
    private $email_subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($template_name,$arr_keyword_values,$user_email,$email_subject)
    {
        $this->template_name =  $template_name;
        $this->arr_keyword_values =  $arr_keyword_values;
        $this->user_email =  $user_email;
        $this->email_subject =  $email_subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $template_name = $this->template_name;
        $arr_keyword_values = $this->arr_keyword_values;
        $user_email = $this->user_email;
        $email_subject = $this->email_subject;
        $site_email = env('MAIL_FROM_EMAIL', 'test.developer202@gmail.com');
        $site_title = env('MAIL_FROM_NAME','PAYzz');
        @Mail::send($template_name, $arr_keyword_values, function ($message) use ($user_email, $email_subject, $site_email, $site_title) {
            $message->to($user_email)->subject($email_subject)->from($site_email, $site_title);
        });
    }
}
