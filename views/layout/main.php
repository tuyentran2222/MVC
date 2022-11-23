<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://share-gcdn.basecdn.net/apps/account.png" type="image/x-icon">
    <title></title>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/_reset.css">
    <!-- <link rel="stylesheet" href="/css/<?= $view ?>.css"> -->
</head>
<body>
    {{content}}
    <?php if ($notify) {?>
        <div class="alert__container">
            <div class="alert <?= $notify ? $notify["status"]: "" ?>">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                <strong></strong> <?= $notify ? $notify["message"]: "";?>
            </div>
        </div>
    <?php } ?>
    <script src="/js/index.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>
</html>