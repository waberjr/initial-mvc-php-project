<?php

namespace Source\Support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * Class Email
 * @package Source\Support
 */
class Email
{
    /** @var array */
    private $data;

    /** @var PHPMailer */
    private PHPMailer $mail;

    /** @var Message */
    private Message $message;

    /**
     * Email constructor.
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->data = new \stdClass();
        $this->message = new Message();

        //setup
        $this->mail->isSMTP();
        $this->mail->setLanguage(CONF_MAIL_OPTION_LANG);
        $this->mail->SMTPAuth = CONF_MAIL_OPTION_AUTH;
        $this->mail->CharSet = CONF_MAIL_OPTION_CHARSET;
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $recipient
     * @param string|null $recipientName
     * @return Email
     */
    public function bootstrap(string $subject, string $body, string $recipient, ?string $recipientName): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient_email = $recipient;
        $this->data->recipient_name = $recipientName;
        return $this;
    }

    /**
     * @param mixed|string $from
     * @param mixed|string $name
     * @param string $replyTo
     * @param string $host
     * @param string $port
     * @param string $username
     * @param string $password
     * @param string $secure
     * @return bool
     */
    public function send(
        string $from = CONF_MAIL_SENDER["email"],
        string $name = CONF_MAIL_SENDER["name"],
        string $replyTo = CONF_MAIL_REPLY,
        string $host = CONF_MAIL_HOST,
        string $port = CONF_MAIL_PORT,
        string $username = CONF_MAIL_USER,
        string $password = CONF_MAIL_PASS,
        string $secure = CONF_MAIL_OPTION_SECURE
    ): bool
    {
        //auth
        $this->mail->Host = $host;
        $this->mail->Port = $port;
        $this->mail->Username = $username;
        $this->mail->Password = $password;

        if(!$secure){
            $this->mail->SMTPSecure = false;
            $this->mail->SMTPAutoTLS = false;
        }else{
            $this->mail->SMTPSecure = $secure;
        }

        if (empty($this->data)) {
            $this->message->error("Erro ao enviar, favor verifique os dados");
            return false;
        }

        if (!is_email($this->data->recipient_email)) {
            $this->message->warning("O e-mail de destinatário não é válido");
            return false;
        }

        if (!is_email($from)) {
            $this->message->warning("O e-mail de remetente não é válido");
            return false;
        }

        try {
            $this->mail->setFrom($from, $name);
            $this->mail->addReplyTo($replyTo);
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name ??  null);
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);

            if($this->mail->send()){
                return true;
            }
        } catch (Exception $exception) {
            $this->message->error($exception->getMessage());
            return false;
        }
    }

    /**
     * @return PHPMailer
     */
    public function mail(): PHPMailer
    {
        return $this->mail;
    }

    /**
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }
}