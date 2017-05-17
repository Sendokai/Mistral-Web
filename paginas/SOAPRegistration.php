<?php

class SOAPRegistration
{
    protected $messages = Array();
    protected $db;
    protected $soap;
    protected $showForm = true;
    
    public function __construct()
    {
        try
        {
            $this -> dbConnect();
            if ($this -> validateInput())
            {
                $this -> soapConnect();
                $this -> showForm = false;
                $this -> soapCommand('account create '.$_POST["accountname"].' '.$_POST["password"]);
				$this -> soapCommand('account set gmlevel '.$_POST["accountname"].' 0 -1');
                $stmt = $this -> db -> prepare("UPDATE `account` SET `email` = ?, `expansion` = ? WHERE `username` = ?;");
                $stmt -> bind_param('sis', $_POST["email"], $_POST["expansion"], $_POST["accountname"]);
                $stmt -> execute();
            }
        }
        catch (Exception $e)
        {
            $this -> addMessage($e -> getMessage());
        }
    }
    
    protected function validateInput()
    {
        if (empty($_POST["accountname"]))
        {
            $this -> addMessage('Please fill in an account name.');
        }
        elseif (!preg_match('/^[a-z0-9]{5,32}$/i', $_POST["accountname"]))
        {
            $this -> addMessage('Tu nombre de cuenta debe de ser de 5 a 32 letras y solo puede contener letras o numeros.');
        }
        else
        {
            $stmt = $this -> db -> prepare("SELECT `username` FROM `account` WHERE `username` = ?;");
            $stmt -> bind_param('s', $_POST["accountname"]);
            $stmt -> execute();
            $stmt -> store_result();
            if ($stmt->num_rows > 0)
            {
                $this -> addMessage('El nombre de cuenta esta en uso. Porfavor escoje otro nombre.');
            }
        }
        
        if (empty($_POST["password"]))
        {
            $this -> addMessage('Escribe tu contraseña.');
        }
        else
        {
            if (!preg_match('/^[a-z0-9!"#$%]{8,16}$/i', $_POST["password"]))
            {
                $this -> addMessage('Tu Contraseña debe de ser de 5 a 32 letras y solo puede contener letras o numeros.');
            }
            
            if (empty($_POST["password2"]))
            {
                $this -> addMessage('Porfavor, confirta tu contraseña.');
            }
            elseif ($_POST["password"] !== $_POST["password2"])
            {
                $this -> addMessage('Las dos contraseñas NO coinciden.');
            }
        }
        
        if (empty($_POST["email"]))
        {
            $this -> addMessage('Porfavor escribe tu Correo.');
        }
        elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        {
            $this -> addMessage('El Formato del Correo no es valido.');
        }
        elseif (strlen($_POST["email"]) > 254)
        {
            $this -> addMessage('El correo es demasiado largo');
        }
        elseif (CHECK_FOR_DUPLICATE_EMAIL)
        {
            $stmt = $this -> db -> prepare("SELECT `email` FROM `account` WHERE `email` = ?;");
            $stmt -> bind_param('s', $_POST["email"]);
            $stmt -> execute();
            $stmt -> store_result();
            if ($stmt->num_rows > 0)
            {
                $this -> addMessage('El correo ya esta registrado. Plorfavor usa un correo distinto.');
            }
        }
        
        return empty($this -> messages);
    }
    
    protected function dbConnect()
    {
        $this -> db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno())
        {
            throw new Exception("Database connection failed: ". mysqli_connect_error());
        }
        return true;
    }
    
    protected function soapConnect()
    {
        $this -> soap = new SoapClient(NULL, Array(
            'location'=> 'http://'. SOAP_IP .':'. SOAP_PORT .'/',
            'uri' => 'urn:TC',
            'style' => SOAP_RPC,
            'login' => SOAP_USER,
            'password' => SOAP_PASS,
            'keep_alive' => false //keep_alive only works in php 5.4.
        ));
    }
    
    protected function soapCommand($command)
    {
        $result = $this -> soap -> executeCommand(new SoapParam($command, 'command'));
        $this -> addMessage($result);
        return true;
    }
    
    protected function addMessage($message)
    {
        $this -> messages[] = $message;
        return true;
    }
    
    public function getMessages()
    {
        return $this -> messages;
    }
    
    public function showForm()
    {
        return $this -> showForm;
    }
    
    public function __destruct()
    {
        $this -> db -> close();
    }
}