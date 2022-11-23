<?php
    $user = $user ?? null;
?>
<div class="container">
    <div class="login__container">
        <div class="login__wrapper">
            <div class="login__logo">
                <a href="/login" class="text-center login__logo-link">
                    <img src="/images/logo.full.png" alt="Logo" srcset="">
                </a>
            </div>
            <form action="/login" method="post">
                <h3 class="login__header text-center">
                    Login
                </h3>
                <p class="login__desc text-center text-muted">Welcome back. Login to start working.</p>
                <div class="login__form">
                    <div class="login__group-input">
                        <div class="login__label text-bold">Email</div>
                        <input class="login__form-input" type="text" name="email" id="email" placeholder="Your email" value="<?php echo $user ? $user->email : "" ?>" autocomplete="off">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("email") ? $user->getErrors("email")[0] : "" ?>
                        </div>
                    </div>
                    <div class="login__group-input">
                        <div class="login__label-container">
                            <div class="login__label text-bold">Password</div>
                            <div class="forget-btn">Forget your password?</div>
                        </div>
                        <input class="login__form-input" type="password" name="password" id="password" placeholder="Your password" value="<?php echo $user ? $user->password : "" ?>" autocomplete="off">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("password") ? $user->getErrors("password")[0] : "" ?>
                        </div>
                    </div>
                    <div class="login__group-input  remember-me">
                        <input type="checkbox" class="login__checkbox login-remember" name="remember">
                        <div class="text-muted">Keep me logged in</div>
                    </div>
                    <?php if ($failed_attempt_login >= 4) { ?>
                        <div class="login__captcha-container">
                            <div class="g-recaptcha brochure__form__captcha" data-sitekey="<?php echo $_ENV["RECAPTCHA_SITE_KEY"] ?>"></div>
                        </div>
                    <?php }?>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <button class="login__button bg-success">Login to start working</button>
                    <div class="login__others">
                        <div class="text-center text-muted login__others-title">Or, login via single sign-on</div>
                        <div class="login__buttons">
                            <button>Login with Google</button>
                            <button>Login with Microsoft</button>
                            <button>Login with SAML</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="login__as-guest">
                <a href="/register" class="text-center">Need an account?</a>
            </div>
        </div>
    </div>
    <div class="background__container">

    </div>
</div>
<script src="/js/login.js"></script>