<?php

namespace MyApp;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require '../lib/PHPMailer-master/src/PHPMailer.php';
require '../lib/PHPMailer-master/src/SMTP.php';
require '../lib/PHPMailer-master/src/Exception.php';

class MailClass
{
    private $SYSTEM_MAIL = "project1.mhs@gmail.com";
    private $SYSTEM_MAIL_PASS = "jnfo vxrb lbcs rftq";


    private $con;
    private $receiver_mail;
    private $receiver_name;
    private $message_subject;
    private $mail_usage;
    private $key;

    private $additional;

    private $msg;

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $additional
     */
    public function setAdditional($additional)
    {
        $this->additional = $additional;
    }

    public function __construct($receiver_mail, $receiver_name, $message_subject, $mail_usage)
    {
        $this->con = DbConnector::getConnection();
        $this->receiver_mail = $receiver_mail;
        $this->receiver_name = $receiver_name;
        $this->message_subject = $message_subject;
        $this->mail_usage = $mail_usage;
    }

    public function set_key($key)
    {
        $this->key = $key;
    }

    private function send_mail()
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $this->SYSTEM_MAIL;
            $mail->Password = $this->SYSTEM_MAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('project1.mhs@gmail.com', 'Mental Health Service (MHS)');
            $mail->addAddress($this->receiver_mail, $this->receiver_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $this->message_subject;
            $mail->Body = $this->get_mail_message();
            $mail->AltBody = 'This is a plain text email, please use an HTML-compatible email client to view.';

            if ($mail->send()) {
                //Redirect to the appropriate page
                if ($this->mail_usage == "verify") {
                    $link = "../check_mail.php";
                    //header("Location: ../check_mail.php");
                } elseif ($this->mail_usage == "reset"){
                    $link = "../login.php?msg=3";
                
                }elseif ($this->mail_usage == "appointment"){
                    $link = "../doctors.php?msg=1";
                } elseif ($this->mail_usage == "pay"){
                    $link = "../doctorprofile.php?msg=5";
                } elseif ($this->mail_usage == "aboutus"){
                    $link = "../contactUs.php?msg=1";
                } else {
                    $link = "../reg.php?M=VF1";
                    //header("Location: ../reg.php?M=VF1");
                }
                header("Location: $link");
                exit();
            } else {
                echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
        }
    }

    private function mail_body_content()
    {
        if ($this->mail_usage == "verify") {
            $msg_body = "<p style=\"line-height: 24px;margin-bottom:15px;\">We are delighted to welcome you to the Mental Health Service, a dedicated place of support and healing. Our committed team is here to guide you on your journey to improved mental health.</p><p style=\"line-height: 24px; margin-bottom:20px;\"><b>To verify your account or explore the various ways we can assist you, please click the <span style=\"color: #5caad2;\">\"Verify\"</span>  button below.</b></p><p style=\"line-height: 24px;margin-bottom:15px;\">We understand that your mental well-being is a priority, and we are here for you every step of the way.</P>";
        }elseif ($this->mail_usage == "appointment"){
            $msg_body = "<p style=\"line-height: 24px;margin-bottom:15px;\">You have an appointment for mental health therapy From our MHS system. </p><p style=\"line-height: 24px; margin-bottom:20px;\"><b>So schedule time and date for therapy, please click the <span style=\"color: #5caad2;\">\"SCHEDULE\"</span>  button below.</b></p>";
        }elseif ($this->mail_usage == "pay"){
            $msg_body = "<p style=\"line-height: 24px;margin-bottom:15px;\">Dear Sir/Madam,<br> <h1>$this->additional</h1> <br> Doctor has given this date and time for your therapy.</p><p style=\"line-height: 24px; margin-bottom:20px;\"><b>So to start the therapy, click <span style=\"color: #5caad2;\">\"PAY\"</span>  button below</b></p><p style=\"line-height: 24px;margin-bottom:15px;\">and complete the transaction</P>";
        }
        if ($this->mail_usage == "reset") {
            $msg_body = "To reset your account password";
//            $msg_body = "<p style=\"line-height: 24px;margin-bottom:15px;\">We are delighted to welcome you to the Mental Health Service, a dedicated place of support and healing. Our committed team is here to guide you on your journey to improved mental health.</p><p style=\"line-height: 24px; margin-bottom:20px;\"><b>To verify your account or explore the various ways we can assist you, please click the <span style=\"color: #5caad2;\">\"Verify\"</span>  button below.</b></p><p style=\"line-height: 24px;margin-bottom:15px;\">We understand that your mental well-being is a priority, and we are here for you every step of the way.</P>";
        }
        if ($this->mail_usage == "aboutus") {
            $msg_body = $this->getMsg();
        }

        return $msg_body;
    }

    private function get_mail_message()
    {
        $msg = "<html>";
        $msg .= "<head>";
        $msg .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
        $msg .= '<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />';
        $msg .= "<link href='https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700' rel=\"stylesheet\">";
        $msg .= "<link href='https://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel=\"stylesheet\">";
        $msg .= "<link rel=\"stylesheet\" href=\"mail.css\">";
        $msg .= "</head>";
        $msg .= "<body class=\"respond\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
        $msg .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"ffffff\" class=\"bg_color\"><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr><tr><td align=\"center\"><table border=\"0\" align=\"center\" width=\"590\" cellpadding=\"0\" cellspacing=\"0\" class=\"container590\"><tr><td align=\"center\" style=\"color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;\" class=\"main-header\"><div style=\"line-height: 35px\">Welcome to the <span style=\"color: #5caad2;\">Mental Health Service</span></div></td></tr><tr><td height=\"10\" style=\"font-size: 10px; line-height: 10px;\">&nbsp;</td></tr><tr><td align=\"center\"><table border=\"0\" width=\"40\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"eeeeee\"><tr><td height=\"2\" style=\"font-size: 2px; line-height: 2px;\">&nbsp;</td></tr></table></td></tr><tr><td height=\"20\" style=\"font-size: 20px; line-height: 20px;\">&nbsp;</td></tr><tr><td align=\"left\"><table border=\"0\" width=\"590\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"container590\"><tr><td align=\"left\" style=\"color: #888888; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;\">";
        $msg .= "<p style=\"line-height: 24px; margin-bottom:15px;\">" . $this->receiver_name . "</p>";
        $msg .= $this->mail_body_content();
        $msg .= "<table border=\"0\" align=\"center\" width=\"180\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"5caad2\" style=\"margin-bottom:20px;\"><tr><td height=\"10\" style=\"font-size: 10px; line-height: 10px;\">&nbsp;</td></tr><tr><td align=\"center\" style=\"color: #ffffff; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;\"><div style=\"line-height: 22px;\">";
        if ($this->mail_usage == "verify"){
            $msg .= "<a href=\"http://localhost/Project_new/process/signupProcess.php?key={$this->key}\" style=\"color: #ffffff; text-decoration: none;\">VERIFY</a>";
        } elseif ($this->mail_usage == "reset"){
            $msg .= "<a href=\"http://localhost/Project_new/resetPassword.php?mail={$this->receiver_mail}\" style=\"color: #ffffff; text-decoration: none;\">Click Here</a>";
        }elseif ($this->mail_usage == "appointment"){
            $msg .= "<a href=\"http://localhost/Project_new/set_appointment_time.php?key={$this->key}\" style=\"color: #ffffff; text-decoration: none;\">SCHEDULE</a>";
        }elseif ($this->mail_usage == "pay"){
            $msg .= "<a href=\"http://localhost/Project_new/payment.php?key={$this->key}\" style=\"color: #ffffff; text-decoration: none;\">PAY</a>";
        }
//        else{
//            $msg .= "<a href=\"http://localhost/test_mail/process/visit.php\" style=\"color: #ffffff; text-decoration: none;\">VIEW PROFILE</a>";
//        }

        $msg .= "</div></td></tr><tr><td height=\"10\" style=\"font-size: 10px; line-height: 10px;\">&nbsp;</td></tr></table><p style=\"line-height: 24px\">Warm regards,<br>Mental Health Service</p></td></tr></table></td></tr></table></td></tr><tr><td height=\"40\" style=\"font-size: 40px; line-height: 40px;\">&nbsp;</td></tr></table>";
        $msg .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"f4f4f4\"><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr><tr><td align=\"center\" class=\"text_color\"><div style=\"color: #333333; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;\">Email us: <br/><span style=\"color: #888888; font-size: 14px; font-family: 'Hind Siliguri', Calibri, Sans-serif; font-weight: 400;\">project1.mhs@gmail.com</span></div></td></tr><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr></table>";
        $msg .= "</body>";
        $msg .= "</html>";

        return $msg;
    }

    public function send_mail_verify_key(){
        $this->send_mail();
    }

    public function create_appointment(){
        $this->send_mail();
    }

    public function pay(){
        $this->send_mail();
    }


}