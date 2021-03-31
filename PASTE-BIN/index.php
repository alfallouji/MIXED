<?php
/**
 * A simple pastebin page written in PHP
 * 
 * @author: bashar@alfallouji.com
 *
 * You may want to adjust the X_RF_KEY (secret) and the cache dir
 */
 
// Secret token to protect the page (set to null if you dont want to protect the page)
// otherwise, it must be provided as a "?x_rf=abcdef" query string parameter to access the page
define('X_RF_KEY', null);

// Cache folder storing data
define('CACHE_DIR', __DIR__ . '/cache/');
 
session_start();
if (X_RF_KEY === null || (isset($_SESSION['x_rf']) && $_SESSION['x_rf'] === X_RF_KEY)) { 
    // ... ok .. 
    
} else { 
    $xrf = isset($_REQUEST['x_rf']) ? $_REQUEST['x_rf'] : null;
    if ($xrf !== X_RF_KEY) { 
        die();
    } else { 
        $_SESSION['x_rf'] = $xrf;
    }
}
?>
<html>
    <head>
        <title>Pastebin</title>
        <style>
            body { 
                padding:20px;
                font-family: Arial;
                font-size: 1em;
                margin: auto;
                text-align: center;
            }
            
            textarea { 
                width: 80%;
                height: 30%;
            }
            
            hr { 
                margin: auto;
                margin-top: 20px;
                margin-bottom: 20px;
                border: none;
                background-color: #EEE;
                height: 20px;
                max-width: 80%;
                border-radius: 10px;
                align: center;
            }
            
            .small { 
                width:80%;
                font-size: 0.8em !important;
                padding: 0px !important;
            }
            
            .pink { 
                background-color: #FEE;
            }
            
            .green { 
                background-color: #EFE;
            }
            
            input, button { 
                padding:7px;
                font-size:1.2em;
                width: 80%;
                cursor: pointer;
                border-radius: 10px;
                border: thin solid #CCC;
            }
            
        </style>
        <script>
            function copy(id) {
                var copyText = document.getElementById(id);
                copyText.select();
                copyText.setSelectionRange(0, 99999); 
                document.execCommand("copy");
            }            
        </script>
    </head>
    <body>
    <?php
        $token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;
        $data = isset($_REQUEST['data']) ? $_REQUEST['data'] : null;
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
        $link = null;
        switch ($action) { 
            // Save data 
            case 'save':
                if ($data) { 
                    $token = uniqid();
                    if (!is_dir(CACHE_DIR)) { 
                        mkdir(CACHE_DIR);
                    }
                    $filename = CACHE_DIR . $token;                
                    file_put_contents($filename, $data);
                }
            break;
            
            // Load data if it exists
            default:
                if ($token && strpos($token, '..') === false) { 
                    $filename = CACHE_DIR . $token;
                    if (file_exists($filename)) { 
                        $data = file_get_contents($filename);
                    }
                }
            break;
        }
        
        if ($token && $data) {
            $link = '//' . $_SERVER['HTTP_HOST'] . '/?token=' . $token; 
            if (X_RF_KEY !== null) { 
                $link .= '&x_rf=' . X_RF_KEY;
            }
            echo '<input class="small" type="text"  id="link" name="link" value="' . $link . '" /><br/>';
            echo '<a href="' . $link . '">Link</a> | ';
            echo '<a href="#" onclick="copy(\'link\')">Copy link</a><br/><br/><br/><br/>';
        }
        
        echo '<form id="frm" action="?action=save" method="post">';
        echo '<textarea class="green" id="data" name="data">' . htmlentities($data) . '</textarea><br/><br/>';
        if ($data) { 
            echo '<button onclick="copy(\'data\')">Copy text</button><br/><br/>';
        }
        echo '<input type="submit" value="Create new" />';
        echo '</form>';
    ?>
    </body>
</html>
