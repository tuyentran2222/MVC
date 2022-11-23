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
            <form action="/forgetPassword" method="post">
                <h3 class="login__header text-center">
                    Password Recovery
                </h3>
                <p class="login__desc text-center text-muted">Please enter your information. A password recovery hint will be sent to your email.</p>
                <div class="login__form">
                    <div class="login__group-input">
                        <div class="login__label text-bold">Email</div>
                        <input class="login__form-input" type="text" name="email" id="email" placeholder="Your email" value="<?php echo $user ? $user->email : "" ?>" autocomplete="off">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("email") ? $user->getErrors("email")[0] : "" ?>
                        </div>
                    </div>
                    <button class="login__button bg-success">Recover password</button>
                </div>
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            </form>
            <div class="login__as-guest">
                <a href="/register" class="text-center">Need an account?</a>
            </div>
        </div>
    </div>
    <div class="background__container"></div>
</div>
