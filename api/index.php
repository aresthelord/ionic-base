<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';
require 'phpmailer/PHPMailerAutoload.php';
require 'v1/model/ModelMessage.php';
require 'v1/model/ModelUser.php';
require 'v1/model/ModelContent.php';
require 'v1/model/jwt_helper.php';
require 'v1/model/ResponseCode.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();
/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route
$app->get(
    '/',
    function () {
        $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Slim Framework for PHP 5</title>
            <style>
                html,body,div,span,object,iframe,
                h1,h2,h3,h4,h5,h6,p,blockquote,pre,
                abbr,address,cite,code,
                del,dfn,em,img,ins,kbd,q,samp,
                small,strong,sub,sup,var,
                b,i,
                dl,dt,dd,ol,ul,li,
                fieldset,form,label,legend,
                table,caption,tbody,tfoot,thead,tr,th,td,
                article,aside,canvas,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section,summary,
                time,mark,audio,video{margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;}
                body{line-height:1;}
                article,aside,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section{display:block;}
                nav ul{list-style:none;}
                blockquote,q{quotes:none;}
                blockquote:before,blockquote:after,
                q:before,q:after{content:'';content:none;}
                a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent;}
                ins{background-color:#ff9;color:#000;text-decoration:none;}
                mark{background-color:#ff9;color:#000;font-style:italic;font-weight:bold;}
                del{text-decoration:line-through;}
                abbr[title],dfn[title]{border-bottom:1px dotted;cursor:help;}
                table{border-collapse:collapse;border-spacing:0;}
                hr{display:block;height:1px;border:0;border-top:1px solid #cccccc;margin:1em 0;padding:0;}
                input,select{vertical-align:middle;}
                html{ background: #EDEDED; height: 100%; }
                body{background:#FFF;margin:0 auto;min-height:100%;padding:0 30px;width:440px;color:#666;font:14px/23px Arial,Verdana,sans-serif;}
                h1,h2,h3,p,ul,ol,form,section{margin:0 0 20px 0;}
                h1{color:#333;font-size:20px;}
                h2,h3{color:#333;font-size:14px;}
                h3{margin:0;font-size:12px;font-weight:bold;}
                ul,ol{list-style-position:inside;color:#999;}
                ul{list-style-type:square;}
                code,kbd{background:#EEE;border:1px solid #DDD;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:0 4px;color:#666;font-size:12px;}
                pre{background:#EEE;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:5px 10px;color:#666;font-size:12px;}
                pre code{background:transparent;border:none;padding:0;}
                a{color:#70a23e;}
                header{padding: 30px 0;text-align:center;}
            </style>
        </head>
        <body>
            <header>
                <a href="http://www.slimframework.com"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHIAAAA6CAYAAABs1g18AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABRhJREFUeNrsXY+VsjAMR98twAo6Ao4gI+gIOIKOgCPICDoCjCAjXFdgha+5C3dcv/QfFB5i8h5PD21Bfk3yS9L2VpGnlGW5kS9wJMTHNRxpmjYRy6SycgRvL18OeMQOTYQ8HvIoJKiiz43hgHkq1zvK/h6e/TyJQXeV/VyWBOSHA4C5RvtMAiCc4ZB9FPjgRI8+YuKcrySO515a1hoAY3nc4G2AH52BZsn+MjaAEwIJICKAIR889HljMCcyrR0QE4v/q/BVBQva7Q1tAczG18+x+PvIswHEAslLbfGrMZKiXEOMAMy6LwlisQCJLPFMfKdBtli5dIihRyH7A627Iaiq5sJ1ThP9xoIgSdWSNVIHYmrTQgOgRyRNqm/M5PnrFFopr3F6B41cd8whRUSufUBU5EL4U93AYRnIWimCIiSI1wAaAZpJ9bPnxx8eyI3Gt4QybwWa6T/BvbQECUMQFkhd3jSkPFgrxwcynuBaNT/u6eJIlbGOBWSNIUDFEIwPZFAtBfYrfeIOSRSXuUYCsprCXwUIZWYnmEhJFMIocMDWjn206c2EsGLCJd42aWSyBNMnHxLEq7niMrY2qyDbQUbqrrTbwUPtxN1ZZCitQV4ZSd6DyoxhmRD6OFjuRUS/KdLGRHYowJZaqYgjt9Lchmi3QYA/cXBsHK6VfWNR5jgA1DLhwfFe4HqfODBpINEECCLO47LT/+HSvSd/OCOgQ8qE0DbHQUBqpC4BkKMPYPkFY4iAJXhGAYr1qmaqQDbECCg5A2NMchzR567aA4xcRKclI405Bmt46vYD7/Gcjqfk6GP/kh1wovIDSHDfiAs/8bOCQ4cf4qMt7eH5Cucr3S0aWGFfjdLHD8EhCFvXQlSqRrY5UV2O9cfZtk77jUFMXeqzCEZqSK4ICkSin2tE12/3rbVcE41OBjBjBPSdJ1N5lfYQpIuhr8axnyIy5KvXmkYnw8VbcwtTNj7fDNCmT2kPQXA+bxpEXkB21HlnSQq0gD67jnfh5KavVJa/XQYEFSaagWwbgjNA+ywstLpEWTKgc5gwVpsyO1bTII+tA6B7BPS+0PiznuM9gPKsPVXbFdADMtwbJxSmkXWfRh6AZhyyzBjIHoDmnCGaMZAKjd5hyNJYCBGDOVcg28AXQ5atAVDO3c4dSALQnYblfa3M4kc/cyA7gMIUBQCTyl4kugIpy8yA7ACqK8Uwk30lIFGOEV3rPDAELwQkr/9YjkaCPDQhCcsrAYlF1v8W8jAEYeQDY7qn6tNGWudfq+YUEr6uq6FZzBpJMUfWFDatLHMCciw2mRC+k81qCCA1DzK4aUVfrJpxnloZWCPVnOgYy8L3GvKjE96HpweQoy7iwVQclVutLOEKJxA8gaRCjSzgNI2zhh3bQhzBCQQPIHGaHaUd96GJbZz3Smmjy16u6j3FuKyNxcBarxqWWfYFE0tVVO1Rl3t1Mb05V00MQCJ71YHpNaMcsjWAfkQvPPkaNC7LqTG7JAhGXTKYf+VDeXAX9IvURoAwtTFHvyYIxtnd5tPkywrPafcwbeSuGVwFau3b76NO7SHQrvqhfFE8kM0Wvpv8gVYiYBlxL+fW/34bgP6bIC7JR7YPDubcHCPzIp4+cum7U6NlhZgK7lua3KGLeFwE2m+HblDYWSHG2SAfINuwBBfxbJEIuWZbBH4fAExD7cvaGVyXyH0dhiAYc92z3ZDfUVv+jgb8HrHy7WVO/8BFcy9vuTz+nwADAGnOR39Yg/QkAAAAAElFTkSuQmCC" alt="Slim"/></a>
            </header>
            <h1>Welcome to Slim!</h1>
            <p>
                Congratulations! Your Slim application is running. If this is
                your first time using Slim, start with this <a href="http://docs.slimframework.com/#Hello-World" target="_blank">"Hello World" Tutorial</a>.
            </p>
            <section>
                <h2>Get Started</h2>
                <ol>
                    <li>The application code is in <code>index.php</code></li>
                    <li>Read the <a href="http://docs.slimframework.com/" target="_blank">online documentation</a></li>
                    <li>Follow <a href="http://www.twitter.com/slimphp" target="_blank">@slimphp</a> on Twitter</li>
                </ol>
            </section>
            <section>
                <h2>Slim Framework Community</h2>

                <h3>Support Forum and Knowledge Base</h3>
                <p>
                    Visit the <a href="http://help.slimframework.com" target="_blank">Slim support forum and knowledge base</a>
                    to read announcements, chat with fellow Slim users, ask questions, help others, or show off your cool
                    Slim Framework apps.
                </p>

                <h3>Twitter</h3>
                <p>
                    Follow <a href="http://www.twitter.com/slimphp" target="_blank">@slimphp</a> on Twitter to receive the very latest news
                    and updates about the framework.
                </p>
            </section>
            <section style="padding-bottom: 20px">
                <h2>Slim Framework Extras</h2>
                <p>
                    Custom View classes for Smarty, Twig, Mustache, and other template
                    frameworks are available online in a separate repository.
                </p>
                <p><a href="https://github.com/codeguy/Slim-Extras" target="_blank">Browse the Extras Repository</a></p>
            </section>
        </body>
    </html>
EOT;
        echo $template;
    }
);

// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);


/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */


/*Login işlemleri*/
$app->post('/auth', function () {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    try {
        $modelUser = new ModelUser();
        $db = getConnection();
        $user = $modelUser->get($data->user, $db);
        if ($user[0]['uid']) {
            $user[0]['token'] = createXToken($user);
        }

        $db = null;
        serviceResponse($user);
    } catch (PDOException $e) {
       $db = null;
        throw $e;
    } catch (Exception $e) {
		$db = null;
        throw $e;
    }
});


/**
 *kullanıcıdan gönderilen mesajlar ile ilgili işlemler
 */

$app->post('/message', function () {
    $request = \Slim\Slim::getInstance()->request();
    $post = json_decode($request->getBody());
    try {

        $modelMessage = new ModelMessage();
        $db = getConnection();
        $db->beginTransaction();
        $message = $modelMessage->save($post, $db);
        $db->commit();
        $db = null;
        serviceResponse($message);
    } catch (PDOException $e) {
        $db->rollBack();
		$db = null;
        throw $e;
    } catch (Exception $e) {
		$db = null;
        throw $e;
    }
});

$app->get('/message', function () {
    try {
        if (validateXToken()) {


            $modelMessage = new ModelMessage();
            $db = getConnection();
            $list = $modelMessage->getAll($db);
            $db = null;
            serviceResponse($list);
			$db = null;
        } else {
            throw new Exception("Unauthorized Access", 401);
        }
    	
    } catch (PDOException $e) {
		$db = null;
        throw $e;
    } catch (Exception $e) {
		$db = null;
        throw $e;
    } 
});

$app->get('/message/:id', function ($id) {
    try {
        if (validateXToken()) {
            $modelMessage = new ModelMessage();
            $db = getConnection();
            $message = $modelMessage->get($id, $db);
            $db = null;
            serviceResponse($message);
      
			$db = null;
        } else {
            throw new Exception("Unauthorized Access", 401);
        }
    	
    } catch (PDOException $e) {
		$db = null;
        throw $e;
    } catch (Exception $e) {
		$db = null;
        throw $e;
    } 
});
$app->get('/message/name/:name', function ($name) {
    try {
        if (validateXToken()) {
            $modelMessage = new ModelMessage();
            $db = getConnection();
            $list = $modelMessage->filterByName($name, $db);
        serviceResponse($list);
			$db = null;
        } else {
            throw new Exception("Unauthorized Access", 401);
        }
    	
    } catch (PDOException $e) {
		$db = null;
        throw $e;
    } catch (Exception $e) {
		$db = null;
        throw $e;
    } 
});

$app->get('/message/:begin/:end', function ($begin, $end) {
    try {
        if (validateXToken()) {
            $modelMessage = new ModelMessage();
            $db = getConnection();
            $list = $modelMessage->filterByRange($begin, $end, $db);
            serviceResponse($list);
			$db = null;
        } else {
            throw new Exception("Unauthorized Access", 401);
        }
    	
    } catch (PDOException $e) {
		$db = null;
        throw $e;
    } catch (Exception $e) {
		$db = null;
        throw $e;
    } 
});

/**
 *kullanıcıdan gönderilen mesajlar ile ilgili işlemler sonu
 */

/**
 *sayfa içerikleri ile ilgili işlemler
 */

$app->get('/contents', function () {
    try {

            $modelContent = new ModelContent();
            $db = getConnection();
            $list = $modelContent->getAll($db);
            serviceResponse($list);

    	$db = null;
    } catch (PDOException $e) {
		$db = null;
        throw $e;
    } catch (Exception $e) {
		$db = null;
        throw $e;
    } 
});
$app->get('/content/:contentId/', function ($contentId) {
    try {

        $modelContent = new ModelContent();
        $db = getConnection();
        $list = $modelContent->get($contentId,$db);
        serviceResponse($list);
		$db = null;
    } catch (PDOException $e) {
		$db = null;
        throw $e;
    } catch (Exception $e) {
		$db = null;
        throw $e;
    } 
});

$app->error(function (Exception $exc) use ($app) {
    // custom exception codes used for HTTP status
    if ($exc->getCode() !== 0) {
        $app->response->setStatus($exc->getCode());
    }

    $app->response->headers->set('Content-Type', 'application/json');
    //$app->halt($exc->getCode(), $exc->getMessage());
    //$app->stop();
    serviceResponse(null, $exc->getMessage());


});

$app->run();


/*sending mail*/

function sendMail()
{
    $request = \Slim\Slim::getInstance()->request();
    $post = json_decode($request->getBody());
    date_default_timezone_set('Etc/UTC');


//Create a new PHPMailer instance
    $mail = new PHPMailer();
//Tell PHPMailer to use SMTP
    $mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

//Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "denizdemirci156@gmail.com";

//Password to use for SMTP authentication
    $mail->Password = "vxjeipehqaptexmp";

//Set who the message is to be sent from
    $mail->setFrom($post->email, $post->username);

//Set an alternative reply-to address
    $mail->addReplyTo('info@kralfarukkirdugunu.com', 'Kral Faruk Kır Düğünü');

//Set who the message is to be sent to
// $post->username
    $mail->addAddress('ddemirci@windowslive.com', 'Deniz Demirci');

//Set the subject line
    $mail->Subject = 'Kral Faruk Kır Düğün Salonu | Yorum';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    $mailBody = 'Kimden :' . $post->username . ' email: ' . $post->email . ' Tel: ' . $post->phone . ' Mesaj : ' . $post->message;
    $mail->msgHTML($mailBody);

//Replace the plain text body with one created manually
    $mail->AltBody = 'Kral Faruk Kır Düğün Salonundan Gönderilmiştir';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
    if (!$mail->send()) {
        serviceResponse(null, $mail->ErrorInfo);
        //echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        $request = \Slim\Slim::getInstance()->request();
        $post = json_decode($request->getBody());
        serviceResponse($post);
    }

}


/*sending mail end*/

function serviceResponse($data = null, $error = null)
{
    //var_dump($data);
    if (is_null($error)) {
        echo '{"success": true , "data": ' . json_encode($data ,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP ) . '}';
    } else {
        echo '{"success": false ,"error":"' . $error . '"}';
    }
}

function getConnection()
{
    $istest = false;
    $dbh = null;
    if ($istest) {
        $dbhost = "localhost";
        $dbuser = "db2admin";
        $dbpass = "Ankara12";
        $dbname = "kralfaruk";
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
        $dbh->exec("set names utf8");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } else {
        $dbhost = "94.73.149.189";
        $dbuser = "db2admin";
        $dbpass = "Ankara12";
        $dbname = "kralfaruk";
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbh->exec("set names utf8");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $dbh;
}


function getXToken()
{
    $headers = apache_request_headers();
    if (array_key_exists('X-Access-Token', $headers)) {
        return ($headers['X-Access-Token']);
    } else {
        return null;
    }

}

function getCookie()
{
    $headers = apache_request_headers();
    if (array_key_exists('Cookie', $headers)) {
        return str_replace("\"", '', $_COOKIE['token']);
        //return ($headers['Cookie']);
    } else {
        return null;
    }

}

function validateXToken()
{
    $xToken = getXToken();
    if (is_null($xToken)) {
        return false;
    } else {
        $token = JWT::decode($xToken, 'YZuK*{$i.', true);
        if ($token) {
            $cookieToken = JWT::decode(getCookie(), 'YZuK*{$i.', true);
            if ($token == $cookieToken) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

function createXToken($user)
{
    $token = array();
    $token['id'] = $user[0]['uid'];
    $JWTToken = JWT::encode($token, 'YZuK*{$i.');
    return $JWTToken;
}

;
