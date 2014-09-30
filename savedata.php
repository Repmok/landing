<?php 
	
	  if (isset($_POST['submit'])) {
		/*Configuración de acceso a Base de Datos*/

			/*Crear Conexión a la Base de Datos*/
			$conection = mysql_connect('localhost', 'nrbkstud_kblog', 'Repmok');
				if(!$conection) {
					die("Error Conexión BD: ".mysql_error());
				} 
			
			/* Acceso a la Base de Datos */
			$dblink = mysql_select_db('nrbkstud_komper_blog', $conection);
				if(!$dblink) {
					die("Error de Access BD". mysql_error());
				}

		/*Fin de Configuración de Base de Datos*/

		/*Verificación de Datos de Correo*/
		$EmailCheck = (string)$_POST["Email"];
		$Email = (string)$_POST["Email"];
		$Name = (string)$_POST["Name"];
		$Content = (string)$_POST["Content"];
		$LastName = (string)$_POST["LastName"];
		$Language = (string)$_POST["Language"];
		$ReturnLang;

		///echo $Content;

		// Query to select the email
		$query = 'SELECT email FROM Users WHERE email = "'.$EmailCheck.'"';
		$result = mysql_query($query);
		$array = mysql_fetch_assoc($result);

		if(gettype($array['email']) == 'string')
		{ $Message = "exist"; }
	    else
		{ 
			//If Email Dont exist Save it on the DB
			$objDateTime = new DateTime('NOW');

			$result = mysql_query("INSERT INTO Users (`email`, `name`, `lastName`, `date`) 
					  VALUES 
 						('".$Email."', '".$Name."','".$LastName."', '". $objDateTime->format('Y-m-d H:i:s')."')") or die("Down");

			$Message = "saved"; 
		}

		/*Email Process*/
		$EmailFlag;
		$SendAddress;
		
		ob_start();
		if($Language == "spanish")
			{ 
				$Topic = "Bienvenido"; 
				$ReturnLang = "es";
				include('mailers/es/mailer.html');
			}
		else
			{ 
				$Topic = "Welcome";
				$ReturnLang = "en";
				include('mailers/en/mailer.html');
			 }

		$Content = ob_get_contents();
		ob_clean();

		$Topic;
		$Header = "MIME-Version: 1.0\r\n"; 
		$Header .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$Header .= "From: support@email.ticompare.com";
		$Message = "";

    	if(mail($Email,$Topic,$Content,$Header))
	        { 
	        	$EmailFlag = true;
	        	$Message = "email";
	         }
    	else
        	{ $EmailFlag = false; }
 

		/********************************/
	}
	else
	{
		$Message = "fill";
	}
		ob_start(); 
        header("Location: http://ticompare.com?action=".$Message."&lang=".$ReturnLang);
        ob_flush();
        exit();
?>

