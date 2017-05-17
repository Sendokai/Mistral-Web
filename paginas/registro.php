<?php

require_once("config.php");
require_once("SOAPRegistration.php");

$messages = Array();
$showForm = true;

if(!empty($_POST["submit"]))
{
    $reg = new SOAPRegistration();
    $messages = $reg -> getMessages();
    $showForm = $reg -> showForm();
}

$messagesDisplay = '';
foreach($messages as $msg)
{
    $messagesDisplay .= '<div class="errors">'.$msg.'</div>';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../css/registro.css" />
        <meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
        <meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
        <meta name="robots" content="<?php echo META_ROBOTS; ?>" />
        <title><?php echo SITE_TITLE; ?></title>
    </head>
    <body>
        <table class="reg">
            <tr>
                <td>
                    <a href="<?php echo $_SERVER["PHP_SELF"]; ?>"><img src="../imagenes/logo.png" alt="<?php echo SITE_TITLE; ?>" /></a>
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
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
                                    Nombre de Cuenta:
                                </td>
                                <td align="left">
                                    <input name="accountname" type="text" maxlength="32" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    Contraseña:
                                </td>
                                <td align="left">
                                    <input name="password" type="password" maxlength="16" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    Confirma Contraseña:
                                </td>
                                <td align="left">
                                    <input name="password2" type="password" maxlength="16" />
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    Correo Eletronico:
                                </td>
                                <td align="left">
                                    <input name="email" type="text" maxlength="254" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" class="sbm" value="Crear Cuenta" name='submit' />
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php
                    }
                    ?>
					<br />
                    <div class="copy">
                        set realmlist <?php echo REALMLIST; ?><br />
						<br />
						 <a href="../index.html" target="_blank">Volver al Menu Principal</a>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>