<?php 
$mensagem_alert = false;

if(isset($_POST['email'])) {

include('lib/conexao.php');
include('lib/generateRandomString.php');

$email = $_POST['email'];

$sql_query = $mysqli->query("SELECT * FROM usuarios WHERE email = '$email'") or die($mysqli->error);

$usuario = $sql_query->fetch_assoc();

    if($usuario['id']) {
        $nova_senha = generateRandomString($length = 6);
        
        $id_usuario = $usuario['id'];

        $nova_senha_cript = password_hash($nova_senha, PASSWORD_DEFAULT);

        $mysqli->query("UPDATE usuarios SET senha = '$nova_senha_cript' WHERE id = '$id_usuario'");
        
        $nome		= $usuario["nome"];	// Pega o valor do campo Nome
        $email		= $usuario["email"];	// Pega o valor do campo Email

        // Variável que junta os valores acima e monta o corpo do email

        $mensagem 	= 'Olá ' . $nome . '! <br><br> Segue a nova senha para acessar a plataforma EAD: ' . $nova_senha;

        require_once("phpmailer/class.phpmailer.php");

        define('GUSER', 'calvireis@gmail.com');	// <-- Insira aqui o seu GMail
        define('GPWD', 'Vp.cew*12345@');		// <-- Insira aqui a senha do seu GMail
        $de_nome = "Plataforma EAD";
        $assunto = "Alteração de Senha";

        function smtpmailer($email, $dono, $de_nome, $assunto, $mensagem) { 
	        global $error;
	        $mail = new PHPMailer();
	        $mail->IsSMTP();		// Ativar SMTP
	        $mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	        $mail->SMTPAuth = true;		// Autenticação ativada
	        $mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	        $mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	        $mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	        $mail->Username = GUSER;
	        $mail->Password = GPWD;
	        $mail->SetFrom($dono, $de_nome);
	        $mail->Subject = $assunto;
	        $mail->Body = $mensagem;
	        $mail->AddAddress($email);

	        if(!$mail->Send()) {
		        echo $error = 'Mail error: '.$mail->ErrorInfo; 
		        return false;
	        } else {
		        echo $error = 'Mensagem enviada!';
		        return true;
	        }
        }

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

        if (smtpmailer($email, $dono, $de_nome, $assunto, $mensagem)) {
	        $mensagem_alert = "Se o seu e-mail foi encontrado em nosso banco de dados, uma nova senha foi enviada para ele !!"; 
        }

        if (!empty($error)) {
            $mensagem_alert = "Se o seu e-mail foi encontrado em nosso banco de dados, uma nova senha foi enviada para ele !!";
        }        
        
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Alterar a senha</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="CodedThemes">
    <meta name="keywords" content=" Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="CodedThemes">
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body class="fix-menu">
    <!-- Pre-loader start -->
    <div class="theme-loader">
    <div class="ball-scale">
        <div class='contain'>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
            <div class="ring"><div class="frame"></div></div>
        </div>
    </div>
</div>
    <!-- Pre-loader end -->

    <section class="login p-fixed d-flex text-center bg-primary common-img-bg">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <div class="login-card card-block auth-body mr-auto ml-auto">
                        <form method="POST" class="md-float-material">
                            <div class="text-center">
                                <img src="assets/images/logo_acesso.png" alt="logo.png" height="100px">
                            </div>
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left txt-primary">Esqueceu sua Senha?</h3>
                                    </div>
                                </div>
                                <hr/>

                                <?php if($mensagem_alert !== false) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo "$mensagem_alert";?>
                                </div>
                                <?php } ?>

                                <p style="color: #666666;">Digite seu e-mail para ser enviado a nova senha!</p>
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control" placeholder="E-mail">
                                    <span class="md-line"></span>
                                </div>
                                
                                    <div class="col-sm-12 col-xs-12 forgot-phone text-right">
                                        <a href="login.php" class="text-right f-w-600 text-inverse"> Voltar</a>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Enviar Senha</button>
                                    </div>
                                </div>
                                
                            </div>

                            </div>
                        </form>
                        <!-- end of form -->
                    </div>
                    <!-- Authentication card end -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 9]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="assets/js/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="assets/js/modernizr/modernizr.js"></script>
    <script type="text/javascript" src="assets/js/modernizr/css-scrollbars.js"></script>
    <script type="text/javascript" src="assets/js/common-pages.js"></script>
</body>

</html>