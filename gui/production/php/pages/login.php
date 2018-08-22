<?php
require_once '../middlewares/AuthenticationMiddleware.php';
verifySession(false);
require_once '../mgr/_MGR_FACTORY.php';

//Load languagepack
$LANG_PACK = _MGR_FACTORY::getMgrLanguage()->getLanguageJson();

function printCopyrightNotice($LANG_PACK) {
    echo "<div><h1>".$LANG_PACK["general"]["owner"]."</h1><p>".$LANG_PACK["general"]["copyright_notice"]."</p></div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $LANG_PACK["general"]["owner"]; ?></title>

    <!-- Bootstrap -->
    <link href="../../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../../../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../../build/css/custom.min.css" rel="stylesheet">

    <!-- Auth (login/registration procedures) -->
    <script type="text/javascript" src="../../js/modelupload/auth.js"></script>

    <!-- PNotify -->
    <link href="../../../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../../../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../../../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <style>
        /* Add lost pwd form as it is not considered in bootstrap */
        .lostpwd_form{position:absolute;top:0;width:100%}.lostpwd_form{z-index:21;opacity:0;width:100%}.login_form{z-index:22}#signin:target~.login_wrapper .login_form,#lostpwd:target~.login_wrapper .lostpwd_form{z-index:22;animation-name:fadeInLeft;animation-delay:.1s}#signin:target~.login_wrapper .lostpwd_form,#lostpwd:target~.login_wrapper .login_form{animation-name:fadeOutLeft}.animate{-webkit-animation-duration:.5s;-webkit-animation-timing-function:ease;-webkit-animation-fill-mode:both;-moz-animation-duration:.5s;-moz-animation-timing-function:ease;-moz-animation-fill-mode:both;-o-animation-duration:.5s;-o-animation-timing-function:ease;-o-animation-fill-mode:both;-ms-animation-duration:.5s;-ms-animation-timing-function:ease;-ms-animation-fill-mode:both;animation-duration:.5s;animation-timing-function:ease;animation-fill-mode:both}
    </style>
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="lostpwd"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form name="loginForm">
                    <h1><?php echo $LANG_PACK["pages"]["login_php"]["h_loginform"]; ?></h1>
                    <div>
                        <input type="text" class="form-control" placeholder="Username" required name="userName"
                               id="userName"/>
                    </div>
                    <div>
                        <input type="password" class="form-control" placeholder="Password" required
                               name="clearPassword" id="clearPassword"/>
                    </div>
                    <div>
                        <input class="btn btn-default submit" type="button" value="Log in" onclick="login(
                                document.getElementById('userName').value, document.getElementById('clearPassword').value);"/>

                        <p class="change_link">
                            <a href="#lostpwd" class="to_register reset_pass"> <?php echo $LANG_PACK["pages"]["login_php"]["lost_pwd"]; ?> </a>
                        </p>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link"><?php echo $LANG_PACK["pages"]["login_php"]["register_intro"]; ?>
                            <a href="#signup" class="to_register"> <?php echo $LANG_PACK["pages"]["login_php"]["a_register"]; ?> </a>
                        </p>

                        <div class="clearfix"></div>
                        <br/>

                        <?php printCopyrightNotice($LANG_PACK); ?>
                    </div>
                </form>
            </section>
        </div>

        <div id="register" class="animate form registration_form">
            <section class="login_content">
                <form>
                    <h1><?php echo $LANG_PACK["pages"]["login_php"]["a_register"]; ?></h1>
                    <div>
                        <input type="text" id="rUserName" class="form-control" placeholder="Username" required=""/>
                    </div>
                    <div>
                        <input type="email" id="rEMail" class="form-control" placeholder="Email" required=""/>
                    </div>
                    <div>
                        <input type="password" id="rClearPassword" class="form-control" placeholder="Password"
                               required=""/>
                    </div>
                    <div>
                        <input class="btn btn-default submit" type="button" value="Register" onclick="register(
                            document.getElementById('rUserName').value,document.getElementById('rEMail').value,document.getElementById('rClearPassword').value
                        );"/>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link"><?php echo $LANG_PACK["pages"]["login_php"]["register_login_intro"]; ?>
                            <a href="#signin" class="to_register"> <?php echo $LANG_PACK["pages"]["login_php"]["a_login"]; ?> </a>
                        </p>

                        <div class="clearfix"></div>
                        <br/>

                        <?php printCopyrightNotice($LANG_PACK); ?>
                    </div>
                </form>
            </section>
        </div>

        <div id="lostpwd" class="animate form lostpwd_form">
            <section class="login_content">
                <form>
                    <h1><?php echo $LANG_PACK["pages"]["login_php"]["h_lostpwd"]; ?></h1>
                    <div>
                        <input type="email" id="lEMail" class="form-control" placeholder="Email" required=""/>
                    </div>
                    <div>
                        <input class="btn btn-default submit" type="button" value="Send mail" onclick="lostpassword(
                            document.getElementById('lEMail').value
                        );"/>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">
                        <p class="change_link"><?php echo $LANG_PACK["pages"]["login_php"]["lostpwd_login_intro"]; ?>
                            <a href="#signin" class="to_register"> <?php echo $LANG_PACK["pages"]["login_php"]["a_login"]; ?> </a>
                        </p>

                        <div class="clearfix"></div>
                        <br/>

                        <?php printCopyrightNotice($LANG_PACK); ?>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../../../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- PNotify -->
<script src="../../../vendors/pnotify/dist/pnotify.js"></script>
<script src="../../../vendors/pnotify/dist/pnotify.buttons.js"></script>
<script src="../../../vendors/pnotify/dist/pnotify.nonblock.js"></script>

</body>
</html>