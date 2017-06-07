<?php

require_once("../config/config.php");
require_once("../config/SOAPRegistration.php");

$messages = Array();
$showForm = true;

if(!empty($_POST["submit"])){
    $reg = new SOAPRegistration();
    $messages = $reg -> getMessages();
    $showForm = $reg -> showForm();
}

$messagesDisplay = '';

foreach($messages as $msg){
    $messagesDisplay .= '<div class="errors">'.$msg.'</div>';
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
        <link rel="stylesheet" type="text/css" href="../css/site.css" />
		<link rel="shortcut icon" type="image/x-icon" href="../imagenes/favicon.png" />
        <title><?php echo SITE_TITLE; ?></title>
    </head>
    <body>
		<header>
			<nav>
				<ul>
					<li><a href="../index.html">Inicio</a></li>
					<li><a href="registro.php">Registro</a></li>
				</ul>
			</nav>
		</header>
		
		<div class="logotipo">
			<img src="../imagenes/logo.png"></a>
		</div>
		
        <table class="reg">
            <tr>
                <td>
                    <?php
                    echo $messagesDisplay;
                    
                    if ($showForm)
                    { ?>
                    <form action="" method="post" name="reg">
                        <table class="form">
                            <tr>
                                <td align="right">
                                    Usuario:
                                </td>
                                <td align="left">
                                    <input name="accountname" type="text" maxlength="32" placeholder="Username"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    Contraseńa:
                                </td>
                                <td align="left">
                                    <input name="password" type="password" maxlength="16" placeholder="Password"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    Repite Contraseńa:
                                </td>
                                <td align="left">
                                    <input name="password2" type="password" maxlength="16" placeholder="Repit Password" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    Correo Eletronico:
                                </td>
                                <td align="left">
                                    <input name="email" type="text" maxlength="254" placeholder="E-Mail" />
                                </td>
                            </tr>
							<tr></tr>
							<tr></tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" class="sbm" value="Registrarme" name='submit' />
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php
                    }
                    ?>
                    <div class="copy">
                        set realmlist <?php echo REALMLIST; ?><br />
                    </div>
                </td>
            </tr>
        </table>
		
		<footer>
			<p>Copyryght xxx-xxx</p>
		</footer>
    </body>
</html>