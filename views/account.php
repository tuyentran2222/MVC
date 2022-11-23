<div class="account__container">
	<header>
		<div class="header__info">
			<div>
				<div class="header__icon-return ">
					<i class="bx bx-left-arrow-alt"></i>
				</div>
				<div class="header__details">
					<div class="header__title">Tài khoản</div>
					<div class="header__subtitle"><?= $user->first_name . " ". $user->last_name ?> - <?=  $user ? $user->job_title: "" ?> </div>
				</div>
			</div>
			<div>

				<button class="button edit-profile-btn">
					<i class="bx bx-up-arrow-alt" ></i>
					<div>
						Chỉnh sửa tài khoản
					</div>
				</button>
			</div>
		</div>
	</header>
	<section class="body">
		<div class="body__container">
			<div class="profile">
				<form action="/updateAvatar" method="post" enctype="multipart/form-data">
					<div class="profile__img">
						<input type="file" name="avatar" id="avatar" accept="image/*">
						<img src="../<?= $user? $user->avatar:"" ?>" alt="logo" srcset="" class="avatarImage" />
					</div>
				</form>
				<div>
					<div class="profile__name">
						<?= $user->first_name . " ". $user->last_name ?>
					</div>
					<div class="profile__pos text-muted">
						<?= $user? $user->job_title:"" ?>
					</div>
					<div class="profile__email">
						<span>Địa chỉ email</span>
						<span><?= $user? $user->email:"" ?></span>
					</div>

					<div class="profile__phone">
						<span>Số điện thoại</span>
						<span>0834925098</span>
					</div>

					<div class="profile__company">
						<span>Công ty</span>
						<span><?= $user? $user->company:"" ?></span>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="overlay <?= isset($popup) && $popup ? 'active' : ''?>">
		<div class="profile__edit-container">
			<div class="profile__edit-wrapper">
				<form action="/updateUser" method="post" class="profile__form">
					<div class="profile__title">
						Chỉnh sửa thông tin cá nhân
						<div class="profile__edit-btn">
							<i class="bx bx-x"></i>
						</div>
					</div>

					<div class="profile__form-group">
						<div class="profile__form-label">
							<div class="profile__form-name text-bold">Tên của bạn</div>
							<div class="profile__form-desc text-muted">Tên của bạn</div>
						</div>
						<div style="width: 100%;">
							<div class="profile__form-input">
								<input type="text" value="<?= $user ? $user->last_name :""?>" name="last_name" >
							</div>
							<div class="invalid-input">
								<?= $user && $user->getErrors("last_name") ? $user->getErrors("last_name")[0] : "" ?>
							</div>
						</div>
					</div>
					<div class="profile__form-group">
						<div class="profile__form-label text-bold">
							<div class="profile__form-name">Họ của bạn</div>
							<div class="profile__form-desc text-muted">Họ của bạn</div>
						</div>
						<div style="width: 100%;">
							<div class="profile__form-input">
								<input type="text" value="<?= $user ? $user->first_name: "" ?>" name="first_name" >
							</div>
							<div class="invalid-input">
								<?= $user && $user->getErrors("first_name") ? $user->getErrors("first_name")[0] : "" ?>
							</div>
						</div>
					</div>
					<div class="profile__form-group">
						<div class="profile__form-label text-bold">
							<div class="profile__form-name">Tên công ty</div>
							<div class="profile__form-desc text-muted">Tên công ty</div>
						</div>
						<div style="width: 100%;">
							<div class="profile__form-input">
								<input type="text" value="<?= $user ? $user->company :"" ?>" name="company" >
							</div>
							<div class="invalid-input">
								<?= $user && $user->getErrors("company") ? $user->getErrors("company")[0] : "" ?>
							</div>
						</div>
	
					</div>
					<div class="profile__form-group">
						<div class="profile__form-label text-bold">
							<div class="profile__form-name">Tên công việc</div>
							<div class="profile__form-desc text-muted">Tên công việc</div>
						</div>
						<div style="width: 100%;">
							<div class="profile__form-input">
								<input type="text" value="<?= $user ? $user->job_title:""?>" name="job_title" >
							</div>
							<div class="invalid-input">
								<?= $user && $user->getErrors("job_title") ? $user->getErrors("job_title")[0] : "" ?>
							</div>
						</div>
					</div>
					<div class="profile__form-group">
						<div class="profile__form-label text-bold">
							<div class="profile__form-name">Email</div>
							<div class="profile__form-desc text-muted">Email của bạn</div>
						</div>
						<div class="profile__form-input">
							<input type="text" value="<?= $user ? $user->email:"" ?>" disabled name="email">
						</div>
					</div>
					<input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
					<div class="profile__form-buttons">
						<button class="profile__button-return">
							Bỏ qua
						</button>
						<button class="profile__button-update bg-success">
							Cập nhật
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
