<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base Account</title>
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="https://share-gcdn.basecdn.net/apps/account.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/_reset.css">
    <link rel="stylesheet" href="/css/account.css">
    <!-- <link rel="stylesheet" href="/css/<?= $css?>"> -->
</head>
<body>
    {{content}}
    <?php if ($notify) {?>
        <div class="alert__container">
            <div class="alert <?= $notify ? $notify['status']: "" ?>">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <strong></strong> <?= $notify ? $notify['message']: "";?>
            </div>
        </div>
    <?php } ?>
    <div class="sidebar__left">
        <div>
            <div class="sidebar__left-item">
                <img src="<?= $user ? $user->avatar : "" ?>" alt="">
            </div>
            <div class="sidebar__left-item active">
                <div class="sidebar__left-icon">
                    <i class='bx bxs-user-circle'></i>
                </div>
                <div class="sidebar__left-title">
                    Cá nhân
                </div>
            </div>
            <div class="sidebar__left-item">
                <div class="sidebar__left-icon">
                    <i class='bx bx-user-pin'></i>
                </div>
                <div class="sidebar__left-title">
                    Thành Viên
                </div>
            </div>
            <div class="sidebar__left-item">
                <div class="sidebar__left-icon">
                    <i class='bx bxs-group' ></i>
                </div>
                <div class="sidebar__left-title">
                    Nhóm
                </div>
            </div>
            <div class="sidebar__left-item">
                <div class="sidebar__left-icon">
                    <i class='bx bx-shape-triangle'></i>
                </div>
                <div class="sidebar__left-title">
                    TK Khách
                </div>
            </div>
            <div class="sidebar__left-item">
                <div class="sidebar__left-icon">
                    <i class='bx bx-bookmark'></i>
                </div>
                <div class="sidebar__left-title">
                    Ứng dụng
                </div>
            </div>
        </div>

        <button class="logout-btn">Đăng xuất</button>
    </div>
    <div class="sidebar__right">
        <div class="sidebar__right-user">
            <div class="sidebar__right-name"><?= $user->first_name . " ". $user->last_name ?></div>
            <div class="sidebar__right-info">
                <div>@tuyentran</div> <div> <?=$user->email?></div>
            </div>
        </div>
        <div class="sidebar__right-account sidebar__right-group">
            <div class="sidebar__group-title">
                Thông tin tài khoản
            </div>
            <div class="sidebar__right-item active">
                <div class="sidebar__right-icon">
                    <i class='bx bxs-cog'></i>
                </div>
                <div class="sidebar__right-title">
                    Tài khoản
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-pencil'></i>
                </div>
                <div class="sidebar__right-title">
                    Chỉnh sửa
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-compass'></i>
                </div>
                <div class="sidebar__right-title">
                    Ngôn ngữ
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-error-alt' ></i>
                </div>
                <div class="sidebar__right-title">
                    Đổi mật khẩu
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-palette' ></i>
                </div>
                <div class="sidebar__right-title">
                    Đổi màu hiển thị
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-calendar' ></i>
                </div>
                <div class="sidebar__right-title">
                    Lịch làm việc
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bxl-product-hunt'></i>
                </div>
                <div class="sidebar__right-title">
                    Bảo mật hai lớp
                </div>
            </div>
        </div>
        <div class="sidebar__right-account sidebar__right-group">
            <div class="sidebar__group-title">
                Ứng dụng bảo mật
            </div>
        </div>
        <div class="sidebar__right-account sidebar__right-group">
            <div class="sidebar__group-title">
                TÙy chỉnh nâng cao
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-time' ></i>
                </div>
                <div class="sidebar__right-title">
                    Lịch sử đăng nhập
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bxs-devices' ></i>
                </div>
                <div class="sidebar__right-title">
                    Quản lý thiết bị
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-envelope' ></i>
                </div>
                <div class="sidebar__right-title">
                    Tùy chỉnh email thông báo
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-time' ></i>
                </div>
                <div class="sidebar__right-title">
                    Chỉnh sửa múi giờ
                </div>
            </div>
            <div class="sidebar__right-item">
                <div class="sidebar__right-icon">
                    <i class='bx bx-share-alt' ></i>
                </div>
                <div class="sidebar__right-title">
                    Ủy quyền tạm thời
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/js/index.js"></script>
<script src="/js/account.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
</html>