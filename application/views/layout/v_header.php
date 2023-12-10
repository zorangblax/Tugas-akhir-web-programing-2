<body>


	<!-- Header -->

	<header class="header">

		<!-- Top Bar -->
		<div class="top_bar">
			<div class="top_bar_container">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
								<ul class="top_bar_contact_list">
									<li>
										<div class="question">Ada Pertanyaan?</div>
									</li>

									<li>
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
										<div>Portalberita@gmail.com</div>
									</li>
								</ul>
								<?php if (isset($email)) : ?>
									<div class="top_bar_login ml-auto">
										<div class="login_button"><a href="<?= base_url("user"); ?>"><?= $user['name']; ?></a></div>
									</div>
								<?php else : ?>
									<div class="top_bar_login ml-auto">
										<div class="login_button"><a href="<?= base_url("auth"); ?>">Login</a></div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>