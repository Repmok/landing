<?php
session_start(); 
if(!$_SESSION['logged']){ 
    header("Location: loginpage.php"); 
    exit; 
} 
require_once "Report/Paginated.php";
require_once "Report/DoubleBarLayout.php";
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Ticompare</title>

    <!--[if (gt IE 8) | (IEMobile)]><!-->
    <link rel="stylesheet" href="css/main.css">
    <!--<![endif]-->
    <!--[if (lt IE 9) & (!IEMobile)]>
    <link rel="stylesheet" href="css/ie.css">
    <![endif]-->

     <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    
</head>
<body>
    <div id="inner-wrap">
        <div class="content">
            <div class="report">
                <h1>Reporte de correos</h1>
                <?php
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
                    // Lista de registros
                    $Records = array();
                    $loopControl = 0;
                    $sql = mysql_query("SELECT * FROM Users", $conection) or die(mysql_error());
                        while($row = mysql_fetch_array($sql)){
                            //echo $row['name']." - ".$row['email'];
                            $Records[$loopControl] = $row['name'].' - '.$row['email'];
                            $loopControl++;
                    }
        
                    $page = $_GET['page'];
                    //constructor takes three parameters
                    //1. array to be paged
                    //2. number of results per page (optional parameter. Default is 10)
                    //3. the current page (optional parameter. Default  is 1)
                    $pagedResults = new Paginated($Records, 100, $page);

                    echo "<ul>";
                        while($row = $pagedResults->fetchPagedRow()) {  //when $row is false loop terminates
                            echo "<li>{$row}</li>";
                        }
                    echo "</ul>";
        
                    $pagedResults->setLayout(new DoubleBarLayout());
                    echo $pagedResults->fetchPagedNavigation();
                ?>
            </div>       
        </div>
    </div>
    <footer>
        <div class="content">
            <ul>
                <li><p>Follow Us</p></li>
                <li><a href="https://www.facebook.com/Ticompare" target="_blank" title="facebook" class="facebook"><span>Facebook</span></a></li>
                <li><a href="https://twitter.com/Ticompare" target="_blank" title="twitter" class="twitter"><span>Twitter</span></a></li>
                <li><a href="http://ticompare.com/blog/" target="_blank" title="blog" class="blog"><span>Blog</span></a></li>
            </ul>
        </div>
    </footer>
</body>
</html>