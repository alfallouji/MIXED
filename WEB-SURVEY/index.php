<?php
   define('DATA_DIR', __DIR__ . '/data/');
   define('LOGO_IMG', null);
   
   session_start();
   if (!isset($_SESSION['ok'])) { 
	$_SESSION['ok'] = false;
   }

    // Save survey 
    if(isset($_REQUEST['surveyResult'])) { 
        header('Content-Type: application/json');
        
        $data = isset($_REQUEST['surveyResult']) ? $_REQUEST['surveyResult'] : null;
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;
        if (($_SESSION['ok'] == false) && $data && $token) { 
             $data = json_decode($data, true);
             $data['time'] = date('Y-m-d H:i:s');
             $date = date('Ymd_H_i_s');
             file_put_contents(DATA_DIR . $date . '-data-' . $token . '.php', '<?php return ' . var_export($data, true) . ';');
            $success = true;
            $_SESSION['ok'] = true;
        } else { 
             $success = false;
        }
        echo json_encode(array('success' => $success));
        die();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hackathon Survey</title><meta name="viewport" content="width=device-width"/>
        <script src="https://unpkg.com/jquery"></script>
        <script src="https://unpkg.com/survey-jquery@1.8.37/survey.jquery.min.js"></script>
        <link rel="stylesheet" href="./index.css"><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/><link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous"/>
        <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $('body').bootstrapMaterialDesign();
            });
        </script>
        <style>
    		#img  {
    		    width: 400px;
    		    top: 0px;
    		    margin: auto;
    		    display: block;
    		    margin-top:20px;
    		    border-radius:20px;
    		}
    
    		.sv_main.sv_main .sv-boolean__label.sv-boolean__label--disabled {
    		    color: rgba(64, 64, 64, 0.5);
    		    font-weight: normal;
    		}
    
    		.sv_main.sv_main .sv-boolean__label {
    		    color: rgb(64, 64, 64);
    		    font-weight: bolder;
    		}
	    </style>
    </head>
    <body>
        <?php if (LOGO_IMG) { echo '<img id="img" src="' . LOGO_IMG . '" />'; } ?>
        <div id="surveyElement" style="display:inline-block;width:100%;"></div>
        <form name="frm" id="frm" action="collect.php" method="post">
            <input type="hidden" name="surveyResult" id="surveyResult" value="" />
	    <input type="hidden" name="token" id="token" value="<?php echo uniqid(); ?>" />
        </form>
        <script type="text/javascript" src="./index.js"></script>
    </body>
</html>
