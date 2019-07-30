<style>
    div.action_view.login {
        padding-top: 1px;
    }

    div.login_box {
        /*width: 300px;*/
        /*margin: 130px auto 0 auto;*/
        padding: 20px;
        background: #FFF;
        border-radius: 10px;
    }

    div.login_box form img {
        display: block;
        margin: 30px auto;
    }

    div.login_box form h1 {
        text-align: center;
        font-family: "Neo Sans Arabic Medium" !important;
    }

    div.login_box form div.border {
        width: 60px;
        height: 5px;
        background-color: #408eba;
        margin: 10px auto;
    }

    div.login_box form input[type=text],
    div.login_box form input[type=password],
    div.login_box form input[type=submit] {
        border: solid 1px #f2f5f6;
        background: #f2f5f6;
        padding: 12px 10px 7px 10px;
        display: block;
        width: 100%;
        box-sizing: border-box;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    div.login_box form input[type=text],
    div.login_box form input[type=password] {
        padding-right: 35px;
    }

    div.login_box form input[type=submit] {
        background-color: #408eba;
        color: #FFF;
        transition: all 0.3s ease-in-out;
    }

    div.login_box form input[type=submit]:hover,
    div.login_box form input[type=submit]:active {
        background: #9eb2bd;
    }

    div.login_box form input[type=text]:focus,
    div.login_box form input[type=password]:focus {
        background-color: #f9f9fa;
        border: solid 1px #f1f1f1;
    }

    div.login_box form div.input_wrapper {
        position: relative;
    }

    div.login_box form div.input_wrapper.username::after {
        position: absolute;
        content: url(/img/usericon.png);
        z-index: 1;
        top: 13px;
        right: 12px;
    }

    div.login_box form div.input_wrapper.password::after {
        position: absolute;
        content: url(/img/passwordicon.png);
        z-index: 1;
        top: 10px;
        right: 12px;
    }

    div.login_box form input:-webkit-autofill {
        background-color: #f2f5f6 !important;
        -webkit-box-shadow: inset 0 0 0px 9999px #f2f5f6;
    }

    div.login_box form input:-webkit-autofill:focus {
        border-color: #f9f9fa;
        -webkit-box-shadow: inset 0 0 0px 9999px #f9f9fa;
        border-bottom: solid 1px #f9f9fa;
    }

    div.action_view.login {
        padding-top: 1px;
        height: calc(100% - 1px);
        backface-visibility: hidden;
        perspective: 3000px;
        transform: translate3d(0, 0, 0);
    }

    div.login_box {
        margin: 100px auto 0 auto;
        padding: 20px;
        background: #FFF;
        border-radius: 10px;
        transform: scale(0);
    }

    @keyframes login {
        from {
            transform: scale(0) rotateY(0deg)
        }
        to {
            transform: scale(1) rotateY(360deg)
        }
    }

    /* The element to apply the animation to */
    div.login_box.animate {
        animation-name: login;
        animation-duration: 1s;
        transform: scale(1);
    }


</style>


<div class="action_view login text-center">
    <div class="login_box animate ">
        <?php $messages = $this->messenger->getMessages();
        if (!empty($messages)): foreach ($messages as $message): ?>
            <p class="message t<?= $message[1] ?>"><?= $message[0] ?><a href="" class="closeBtn"><i
                            class="fa fa-times"></i></a></p>
        <?php endforeach;endif; ?>
        <form autocomplete="off" action="/auth/login" method="post" enctype="application/x-www-form-urlencoded">
            <div class="border"></div>
            <h1> Login to system </h1>
            <!--            <img src="/public/img/login-icon.png" width="120">-->
            <div class="  username">
                <input required type="text" name="ucname" id="ucname" maxlength="50" placeholder="<?= $login_ucname ?>">
            </div>
            <div class=" password">
                <input required type="password" id="ucpwd" name="ucpwd" maxlength="100"
                       placeholder="<?= $login_ucpwd ?>">
            </div>
            <input type="submit" name="login" value="<?= $login_button ?>">Or you don't have accoun <a
                    href="/auth/register"> new register</a>
        </form>
    </div>
</div>