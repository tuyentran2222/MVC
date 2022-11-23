<?php
    $notify = \core\Application::$app->session->getFlashSession("notify");
?>
<div class="container">
    <div class="login__container">
        <div class="login__wrapper">
            <div class="login__logo">
                <a href="/" class="text-center login__logo-link">
                    <img src="/images/logo.full.png" alt="Logo" srcset="">
                </a>
            </div>
            <form action="/verifyCode" method="post">
                <h3 class="login__header text-center">
                    Verify Code
                </h3>
                <p class="login__desc text-center text-muted">Verify Code</p>
                <div class="login__form">
                    <div class="login__group-input">
                        <div class="login__label text-bold">Code</div>
                        <input class="login__form-input" type="text" name="verify_code" id="code" placeholder="Your code">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    </div>
                    <button class="login__button bg-success">Submit</button>
                </div>
            </form>
            <div class="login__as-guest">
                <a href="/login" class="text-center">Already have an account?</a>
            </div>
        </div>
    </div>
    <div class="background__container">

    </div>
</div>