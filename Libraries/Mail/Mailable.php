<?php

namespace Libraries\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

abstract class Mailable
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mail->SMTPAuth = true;
        $this->mail->isSMTP();
        $this->mail->Host = env('MAIL_HOST') ?? 'smtp.gmail.com';
        $this->mail->SMTPSecure = env('MAIL_ENCRYPTION') ?? 'tls';
        $this->mail->Port = env('MAIL_PORT') ?? '587';
        $this->mail->Username = env('MAIL_USERNAME');
        $this->mail->Password = env('MAIL_PASSWORD');

        $this->handle();
    }

    abstract protected function handle(): Mailable;

    /**
     * @throws Exception
     */
    public function send(): bool
    {
        return $this->mail->send();
    }

    /**
     * @throws Exception
     */
    public function to($email): static
    {
        $this->mail->AddAddress($email);

        return $this;
    }

    /**
     * @throws Exception
     */
    public function from($email, $name = ''): static
    {
        $this->mail->setFrom($email, $name);

        return $this;
    }

    public function subject($subject): static
    {
        $this->mail->Subject = $subject;

        return $this;
    }

    public function view($view_name, $data = []): static
    {
        ob_start();
        view($view_name, $data);
        $html = ob_get_clean();
        $this->mail->Body = $html;
        $this->mail->AltBody = strip_tags($html);

        return $this;
    }

    /**
     * @throws Exception
     */
    public function bcc($emails): static
    {
        foreach ($emails as $email) {
            $this->mail->addBCC($email);
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    public function cc($emails): static
    {
        foreach ($emails as $email) {
            $this->mail->addCC($email);
        }

        return $this;
    }



}