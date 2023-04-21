<?php

namespace App\Mails;

use Libraries\Mail\Mailable;
use PHPMailer\PHPMailer\Exception;

class HelloUser extends Mailable
{
    public function __construct($data)
    {
        $this->cc = $data['cc'];
        $this->bcc = $data['bcc'];
        $this->to = $data['to'];
        $this->view_name = $data['view_name'];
        $this->view_data = $data['view_data'];

        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function handle(): HelloUser
    {
        return $this->to($this->to)
            ->bcc($this->bcc)->cc($this->cc)
            ->view($this->view_name, $this->view_data);
    }
}