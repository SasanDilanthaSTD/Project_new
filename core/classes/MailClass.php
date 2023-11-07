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
    private $verify_key;

    public function __construct($receiver_mail, $receiver_name, $message_subject, $mail_usage)
    {
        $this->con = DbConnector::getConnection();
        $this->receiver_mail = $receiver_mail;
        $this->receiver_name = $receiver_name;
        $this->message_subject = $message_subject;
        $this->mail_usage = $mail_usage;
    }

    public function set_verify_key($key)
    {
        $this->verify_key = $key;
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
                    $link = "../../check_mail.php";
                    //header("Location: ../check_mail.php");
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
        $msg .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"ffffff\"><tr><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr><tr><td align=\"center\" height=\"70\" style=\"height:70px;\"><a style=\"display: block; border-style: none !important; border: 0 !important;\"><img width=\"100\" border=\"0\" style=\"display: block; width: 100px;\" src=\"http://localhost/test_mail/img/logo.png\"/></a></td></tr><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr></tr></table>";
        $msg .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"ffffff\" class=\"bg_color\"><tr><td align=\"center\"><table border=\"0\" align=\"center\" width=\"590\" cellpadding=\"0\" cellspacing=\"0\" class=\"container590\"><tr><td align=\"center\" style=\"color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;\" class=\"main-header\"><div style=\"line-height: 35px\">Welcome to the <span style=\"color: #5caad2;\">Mental Health Service</span></div></td></tr><tr><td height=\"10\" style=\"font-size: 10px; line-height: 10px;\">&nbsp;</td></tr><tr><td align=\"center\"><table border=\"0\" width=\"40\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"eeeeee\"><tr><td height=\"2\" style=\"font-size: 2px; line-height: 2px;\">&nbsp;</td></tr></table></td></tr><tr><td height=\"20\" style=\"font-size: 20px; line-height: 20px;\">&nbsp;</td></tr><tr><td align=\"left\"><table border=\"0\" width=\"590\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"container590\"><tr><td align=\"left\" style=\"color: #888888; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;\">";
        $msg .= "<p style=\"line-height: 24px; margin-bottom:15px;\">" . $this->receiver_name . "</p>";
        $msg .= $this->mail_body_content();
        $msg .= "<table border=\"0\" align=\"center\" width=\"180\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"5caad2\" style=\"margin-bottom:20px;\"><tr><td height=\"10\" style=\"font-size: 10px; line-height: 10px;\">&nbsp;</td></tr><tr><td align=\"center\" style=\"color: #ffffff; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;\"><div style=\"line-height: 22px;\">";
        $msg .= ($this->mail_usage == "verify") ? "<a href=\"http://localhost/Project_new/process/signupProcess.php?key={$this->verify_key}\" style=\"color: #ffffff; text-decoration: none;\">VERIFY</a>" : "<a href=\"http://localhost/test_mail/process/visit.php\" style=\"color: #ffffff; text-decoration: none;\">VIEW PROFILE</a>";
        $msg .= "</div></td></tr><tr><td height=\"10\" style=\"font-size: 10px; line-height: 10px;\">&nbsp;</td></tr></table><p style=\"line-height: 24px\">Warm regards,<br>Mental Health Service</p></td></tr></table></td></tr></table></td></tr><tr><td height=\"40\" style=\"font-size: 40px; line-height: 40px;\">&nbsp;</td></tr></table>";
        $msg .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"2a2e36\"><tr><td align=\"center\" style=\"background-image: url(http://localhost/test_mail/img/mail_bg.jpg); background-size: cover; background-position: top center; background-repeat: no-repeat;\" background=\"http://localhost/Project_new/assets/img/mail_bg.jpg\"><table border=\"0\" align=\"center\" width=\"590\" cellpadding=\"0\" cellspacing=\"0\" class=\"container590\"><tr><td height=\"50\" style=\"font-size: 50px; line-height: 50px;\">&nbsp;</td></tr><tr><td align=\"center\"><table border=\"0\" width=\"380\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\" class=\"container590\"><tr><td align=\"center\"><table border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"container580\"><tr><td align=\"center\" style=\"color: #cccccc; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 26px;\"><div style=\"line-height: 26px\">Welcome to our Mental Health Service website, where you'll find a sanctuary for your mental well-being. Discover support, resources, and a caring community committed to your journey toward better mental health. Let's walk this path together, one step at a time, towards a brighter, more resilient future.</div></td></tr></table></td></tr></table></td></tr><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr><tr><td align=\"center\"><table border=\"0\" align=\"center\" width=\"250\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:2px solid #ffffff;\"><tr><td height=\"10\" style=\"font-size: 10px; line-height: 10px;\">&nbsp;</td></tr><tr><td align=\"center\" style=\"color: #ffffff; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;\"><div style=\"line-height: 22px;\"><span style=\"color: #fff;\">Embrace Healing, Embrace Hope</span></div></td></tr><tr><td height=\"10\" style=\"font-size: 10px; line-height: 10px;\">&nbsp;</td></tr></table></td></tr><tr><td height=\"50\" style=\"font-size: 50px; line-height: 50px;\">&nbsp;</td></tr></table></td></tr></table>";
        $msg .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"ffffff\" class=\"bg_color\"><tr><td height=\"60\" style=\"font-size: 60px; line-height: 60px;\">&nbsp;</td></tr><tr><td align=\"center\"><table border=\"0\" align=\"center\" width=\"590\" cellpadding=\"0\" cellspacing=\"0\" class=\"container590 bg_color\"><tr><td align=\"center\"><table border=\"0\" align=\"center\" width=\"590\" cellpadding=\"0\" cellspacing=\"0\" class=\"container590 bg_color\"><tr><td><table border=\"0\" width=\"300\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\" class=\"container590\"><tr><td align=\"left\"><a style=\"display: block; border-style: none !important; border: 0 !important;\"><img width=\"80\" border=\"0\" style=\"display: block; width: 80px;\" src=\"http://localhost/test_mail/img/logo.png\"></a></td></tr><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr><tr><td align=\"left\" style=\"color: #888888; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 23px;\" class=\"text_color\"><div style=\"color: #333333; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;\">Email us: <br/> <a style=\"color: #888888; font-size: 14px; font-family: 'Hind Siliguri', Calibri, Sans-serif; font-weight: 400;\">project1.mhs@gmail.com</a></div></td></tr></table><table border=\"0\" width=\"2\" align=\"left\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\" class=\"container590\"><tr><td width=\"2\" height=\"10\" style=\"font-size: 10px; line-height: 10px;\"></td></tr></table><table borde\r=\"0\" width=\"200\" align=\"right\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\" class=\"container590\"><tr><td class=\"hide\" height=\"45\" style=\"font-size: 45px; line-height: 45px;\">&nbsp;</td></tr><tr><td height=\"15\" style=\"font-size: 15px; line-height: 15px;\">&nbsp;</td></tr><tr><td><table border=\"0\" align=\"right\" cellpadding=\"0\" cellspacing=\"0\"><tr><td><a href=\"https://www.facebook.com/mdbootstrap\" style=\"display: block; border-style: none !important; border: 0 !important;\"><img width=\"24\" border=\"0\" style=\"display: block;\" src=\"http://i.imgur.com/Qc3zTxn.png\"></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><a href=\"https://twitter.com/MDBootstrap\" style=\"display: block; border-style: none !important; border: 0 !important;\"><img width=\"24\" border=\"0\" style=\"display: block;\" src=\"http://i.imgur.com/RBRORq1.png\"></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><a href=\"https://plus.google.com/u/0/b/107863090883699620484/107863090883699620484/posts\" style=\"display: block; border-style: none !important; border: 0 !important;\"><img width=\"24\" border=\"0\" style=\"display: block;\" src=\"http://i.imgur.com/Wji3af6.png\"></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr><tr><td height=\"60\" style=\"font-size: 60px; line-height: 60px;\">&nbsp;</td></tr></table>";
        $msg .= "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"f4f4f4\"><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr><tr><td align=\"center\"><p class=\"mb-0\">Copyright © 2023 Mental Health Service</p></td></tr><tr><td height=\"25\" style=\"font-size: 25px; line-height: 25px;\">&nbsp;</td></tr></table>";
        $msg .= "</body>";
        $msg .= "</html>";

        return $msg;
    }

    public function send_mail_verify_key()
    {
        $this->send_mail();
    }

}