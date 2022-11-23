<?php
$user = $user ?? null;
?>
<div class="container">
    <div class="login__container">
        <div class="login__wrapper">
            <div class="login__logo">
                <a href="/register" class="text-center login__logo-link">
                    <img src="/images/logo.full.png" alt="Logo" srcset="">
                </a>
            </div>
            <form action="/register" method="post">
                <h3 class="login__header text-center">
                    Sign up
                </h3>
                <p class="login__desc text-center text-muted">Welcome back. Login to start working.</p>
                <div class="login__form">
                    <div class="login__group-input">
                        <div class="login__label text-bold">Email</div>
                        <input class="login__form-input" type="text" name="email" id="email" placeholder="Your email" value="<?php echo $user ? $user->email : "" ?>">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("email") ? $user->getErrors("email")[0] : "" ?>
                        </div>
                    </div>
    
                    <div class="login__group-input">
                        <div class="login__label-container">
                            <div class="login__label text-bold">Password</div>
                        </div>
                        <input class="login__form-input" type="password" name="password" id="password" placeholder="Your password" value="<?php echo $user ? $user->password : "" ?>">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("password") ? $user->getErrors("password")[0] : "" ?>
                        </div>
                    </div>
    
                    <div class="login__group-input">
                        <div class="login__label-container">
                            <div class="login__label text-bold">Confirm Password</div>
                        </div>
                        <input class="login__form-input" type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm your password" value="<?php echo $user ? $user->confirm_password : "" ?>">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("confirm_password") ? $user->getErrors("confirm_password")[0] : "" ?>
                        </div>
                    </div>

                    <div class="login__group-input">
                        <div class="login__label-container">
                            <div class="login__label text-bold">First Name</div>
                        </div>
                        <input class="login__form-input" type="text" name="first_name" id="firstName" placeholder="Enter first name" value="<?php echo $user ? $user->first_name : "" ?>">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("first_name") ? $user->getErrors("first_name")[0] : "" ?>
                        </div>
                    </div>

                    <div class="login__group-input">
                        <div class="login__label-container">
                            <div class="login__label text-bold">Last Name</div>
                        </div>
                        <input class="login__form-input" type="text" name="last_name" id="lastName" placeholder="Enter last name" value="<?php echo $user ? $user->first_name : "" ?>">
                        <div class="invalid-input">
                            <?= $user && $user->getErrors("last_name") ? $user->getErrors("last_name")[0] : "" ?>
                        </div>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <button class="login__button bg-success">Register</button>
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