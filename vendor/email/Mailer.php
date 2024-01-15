<?php

namespace App\vendor\email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../email/PHPMailer/src/Exception.php';
require '../email/PHPMailer/src/PHPMailer.php';
require '../email/PHPMailer/src/SMTP.php';

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    public static function sendMail($emailuser, $title, $content, $address, $phone, $name)
    {
        $mail = new PHPMailer(true);

        try {
            // Cấu hình thông tin máy chủ email và tài khoản gửi
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Thay đổi nếu bạn sử dụng máy chủ email khác
            $mail->SMTPAuth = true;
            $mail->Username = 'thuongnapc04755@fpt.edu.vn'; // Thay đổi bằng địa chỉ email của bạn
            $mail->Password = 'lukzcrwufbiztubs';  // Thay đổi bằng mật khẩu của bạn
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;  // Thay đổi nếu máy chủ email của bạn yêu cầu cổng khác

            // Thiết lập người gửi và người nhận
            $mail->setFrom('thuongnapc04755@fpt.edu.vn', 'Thuong');  // Thay đổi bằng địa chỉ email và tên của bạn
            $mail->addAddress($emailuser);  // Sử dụng địa chỉ email người nhận được truyền vào hàm
            $mail->isHTML(true);

            // Đặt tiêu đề và nội dung của email
            $mail->Subject = $title;
            $mail->Body = $content;

            // Gửi email
            $mail->send();
            $_SESSION['mail']['success'] = 'ĐƠN HÀNG CỦA BẠN ĐÃ ĐƯỢC ĐẶT THÀNH CÔNG.';
            return true;
        } catch (Exception $e) {
            echo "Lỗi khi gửi email: " . $mail->ErrorInfo;
            return false;
        }
    }
}
