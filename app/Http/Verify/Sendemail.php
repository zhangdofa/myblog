<?php

namespace App\Http\Verify;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
/**
 * 
 */
class Sendemail extends Controller
{
	
	//发送邮件
	public function sendmail($email,$name,$token){
		// 实例化PHPMailer核心类
		$mail = new PHPMailer();
		// 使用smtp鉴权方式发送邮件
		$mail->isSMTP();
		// smtp需要鉴权 这个必须是true
		$mail->SMTPAuth = true;
		// 链接qq域名邮箱的服务器地址
		$mail->Host = 'smtp.qq.com';
		// 设置使用ssl加密方式登录鉴权
		$mail->SMTPSecure = 'ssl';
		// 设置ssl连接smtp服务器的远程服务器端口号
		$mail->Port = 465;
		// 设置发送的邮件的编码
		$mail->CharSet = 'UTF-8';
		// 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
		$mail->FromName = 'The fourth blog';
		// smtp登录的账号 QQ邮箱即可
		$mail->Username = '2631193744@qq.com';
		// smtp登录的密码 使用生成的授权码
		$mail->Password = 'vwimrcbcbgeudiih';
		// 设置发件人邮箱地址 同登录账号
		$mail->From = '2631193744@qq.com';
		// 邮件正文是否为html编码 注意此处是一个方法
		$mail->isHTML(true);
		// 设置收件人邮箱地址
		$mail->addAddress($email);
		// 添加多个收件人 则多次调用方法即可
		// 添加该邮件的主题
		$mail->Subject = "找回密码";

		$name = encrypt($name);
		$url = url("index/resetpwd?name=".$name."&token=".$token);
		// 添加邮件正文
		$mail->Body = "尊敬的用户您好："."<br>"."&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;"."重置密码链接：".$url."。请点击链接修改密码！注意本链接仅限本次修改！";
		// 发送邮件 返回状态
		$status = $mail->send();
		return redirect('index/login');
	}
}
