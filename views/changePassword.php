<?php $user= $user ?? null ?>
<div class="container">
    <div class="login__container">
        <div class="login__wrapper">
            <div class="login__logo">
                <a href="/login" class="text-center login__logo-link">
                    <img src="/images/logo.full.png" alt="Logo" srcset="">
                </a>
            </div>
            <form action="/changePassword" method="post">
                <h3 class="login__header text-center">
                    Change Password
                </h3>
                <div class="text-center" style="width: 100%;margin-top: 20px; margin-bottom: 10px; color: var(--success)"><?php echo \core\Application::$app->session->getFlashSession("login") ?></div>
                <p class="login__desc text-center text-muted">Please create a new password that you don't use on any other site.</p>
                <div class="login__form">

                    <div class="login__group-input">
                        <div class="login__label-container">
                            <div class="login__label text-bold">Password</div>
                        </div>
                        <input class="login__form-input" type="password" name="password" id="password" placeholder="Your password" value="<?php echo $user ? $user->password : "" ?>" autocomplete="off">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("password") ? $user->getErrors("password")[0] : "" ?>
                        </div>
                    </div>
                    <div class="login__group-input">
                        <div class="login__label-container">
                            <div class="login__label text-bold">Confirm Password</div>
                        </div>
                        <input class="login__form-input" type="password" name="confirm_password" id="confirmPassword" placeholder="Your confirm password" value="<?php echo $user ? $user->confirm_password : "" ?>" autocomplete="off">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("password") ? $user->getErrors("confirm_password")[0] : "" ?>
                        </div>
                    </div>
                    <button class="login__button bg-success">Change</button>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                </div>
            </form>
            <div class="login__as-guest">
                <a href="/register" class="text-center">Need an account?</a>
            </div>
        </div>
    </div>
    <div class="background__container"></div>
</div>

