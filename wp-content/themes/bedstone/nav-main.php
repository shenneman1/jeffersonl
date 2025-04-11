<?php
// Make $acf_options object available (from functions.php)
global $acf_options;
?>


<nav class="nav-main">
	<ul class="nav-main__list">
		<!-- ==================== Nav Item 1 ====================  -->
		<li id="nav1" class="nav-main__item nav-main__item--parent">

			<a href="#" aria-expanded="false" aria-controls="nav1_submenu"><?php echo $acf_options->nav1_label; ?><i
					class="fas fa-angle-down" aria-hidden="true"></i></a>

			<div class="nav-main__submenu submenu--bg-third" id="nav1_submenu">
				<div class="container">
					<div class="columns columns--flex">

						<div class="col col-3">
							<div class="submenu__ft">
								<?php $featured_image = get_field( 'nav1_ft_img', 'options' );
								if ( $featured_image['url'] ) : ?>
									<img class="submenu__ft__img submenu__img--shadow"
									     src="<?php echo esc_url( $featured_image['sizes']['desktop-nav'] ); ?>" alt="">
								<?php endif; ?>
							</div>
						</div>

						<?php if ( have_rows( 'nav1_columns', 'options' ) ) : ?>

							<?php while ( have_rows( 'nav1_columns', 'options' ) ) : the_row();
								$column_title = get_sub_field( 'column_title' );
								?>

								<div class="col col-3">
									<?php if ( ! empty( $column_title ) ) { ?>
										<h2 class="column_title"><?php echo esc_attr( $column_title ); ?></h2>
									<?php } else { ?>
										<!--<h2 class="column_title no-border" aria-hidden="true"></h2>-->
									<?php } ?>
									<ul class="submenu__nav-list">
										<?php if ( have_rows( 'links' ) ) : ?>

											<?php while ( have_rows( 'links' ) ) : the_row();
												$link_image  = get_sub_field( 'link_image' );
												$link        = get_sub_field( 'link' );
												$link_target = $link['target'] ? $link['target'] : '_self'; ?>

												<li>
													<?php if ( $link_image['url'] ) : ?>
														<a href="<?php echo esc_url( $link['url'] ); ?>"
														   target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_attr( $link['title'] ); ?>
														   <div class="img-container">
																<img class="submenu__img--shadow"
															     src="<?php echo esc_url( $link_image['sizes']['desktop-nav'] ); ?>"
															     alt="">
															</div>
														</a>
													<?php else : ?>
														<a href="<?php echo esc_url( $link['url'] ); ?>"
														   target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_attr( $link['title'] ); ?></a>
													<?php endif; ?>


												</li>

											<?php endwhile; ?>

										<?php endif; ?>
									</ul>
								</div>

							<?php endwhile; ?>

						<?php endif; ?>
					</div>
				</div>
			</div>

		</li>


		<!-- ==================== Nav Item 2 ====================  -->
		<li id="nav2" class="nav-main__item nav-main__item--parent">
			<?php $single_top_level = get_field( 'single_top_level', 'options' );
			if ( ! empty( $single_top_level ) ) { ?>
				<a href="<?php echo esc_url( $single_top_level['url'] ) ?>"><?php echo esc_attr( $single_top_level['title'] ) ?></a>
			<?php } else { ?>
				<a href="#" aria-expanded="false" aria-controls="nav2_submenu"><?php echo $acf_options->nav2_label; ?><i
						class="fas fa-angle-down" aria-hidden="true"></i></a>

				<div class="nav-main__submenu submenu--bg-half" id="nav2_submenu">
					<div class="container">
						<div class="columns columns--flex">

							<div class="col col-3">
								<div class="submenu__ft">
									<?php $featured_image = get_field( 'nav2_ft_img', 'options' );
									if ( $featured_image['url'] ) : ?>
										<img class="submenu__ft__img submenu__img--shadow"
										     src="<?php echo esc_url( $featured_image['sizes']['desktop-nav'] ); ?>"
										     alt="">
									<?php endif; ?>
								</div>
							</div>

							<?php if ( have_rows( 'nav2_columns', 'options' ) ) : ?>
								<ul class="submenu__nav-list col-9">
									<?php while ( have_rows( 'nav2_columns', 'options' ) ) : the_row();
										$column_title = get_sub_field( 'column_title' );
										?>

										<div class="col col-4">
											<?php if ( ! empty( $column_title ) ) { ?>
												<h2 class="column_title"><?php echo esc_attr( $column_title ); ?></h2>
											<?php } else { ?>
												<h2 class="column_title no-border" aria-hidden="true"></h2>
											<?php } ?>

											<?php if ( have_rows( 'links' ) ) : ?>

												<?php while ( have_rows( 'links' ) ) : the_row();
													$link = get_sub_field( 'link' );
													if ( ! empty( $link ) ) {
														$link_target = $link['target'] ? $link['target'] : '_self';
														$link_url    = $link['url'];
														$link_title  = $link['title'];
														?>
														<li>

															<a href="<?php echo esc_url( $link_url ); ?>"
															   target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_attr( $link_title ); ?></a>

														</li>
													<?php } ?>

												<?php endwhile; ?>

											<?php endif; ?>

										</div>

									<?php endwhile; ?>
								</ul>

							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</li>

		<!-- ==================== Nav Item 3 ====================  -->
		<li id="nav3" class="nav-main__item nav-main__item--parent">

			<a href="#" aria-expanded="false" aria-controls="nav3_submenu"><?php echo $acf_options->nav3_label; ?><i
					class="fas fa-angle-down" aria-hidden="true"></i></a>

			<div class="nav-main__submenu" id="nav3_submenu">
				<div class="container">
					<div class="columns columns--flex">



						<?php if ( have_rows( 'nav3_columns', 'options' ) ) : ?>

							<?php while ( have_rows( 'nav3_columns', 'options' ) ) : the_row();
								$column_title = get_sub_field( 'column_title' );
								?>

								<div class="col col-3 locations-cols">
									<?php if ( ! empty( $column_title ) ) { ?>
										<?php echo $column_title; ?>
									<?php } else { ?>
										<h2 class="column_title no-border" aria-hidden="true">&nbsp;</h2>
									<?php } ?>
									<ul class="submenu__nav-list">
										<?php if ( have_rows( 'links' ) ) : ?>

											<?php while ( have_rows( 'links' ) ) : the_row();

												$content_type = get_sub_field( 'link_or_title' );
												if ( 'link' === $content_type ) {
													$link        = get_sub_field( 'link' );
													$link_target = $link['target'] ? $link['target'] : '_self';
													$content     = '<a href="' . esc_url( $link['url'] ) . '" target="' . esc_attr( $link_target ) . '">' . esc_attr( $link['title'] ) . '</a>';
												} else {
													$title   = get_sub_field( 'title' );
													$content = '<h2 class="column_title">' . esc_attr( $title ) . '</h2>';
												}
												?>

												<li>

													<?php echo $content; ?>

												</li>

											<?php endwhile; ?>

										<?php endif; ?>
									</ul>
								</div>

							<?php endwhile; ?>

						<?php endif; ?>
					</div>
				</div>
			</div>

		</li>

		<!-- ==================== Nav Item 4 ====================  -->

		<li id="nav4" class="nav-main__item nav-main__item--parent">

			<?php $single_top_level_1 = get_field( 'single_top_level_1', 'options' );
			if ( ! empty( $single_top_level_1 ) ) { ?>
				<a href="<?php echo esc_url( $single_top_level_1['url'] ) ?>"><?php echo esc_attr( $single_top_level_1['title'] ) ?></a>
			<?php } else { ?>
				<a href="#" aria-expanded="false" aria-controls="nav4_submenu"><?php echo $acf_options->nav4_label; ?><i
						class="fas fa-angle-down" aria-hidden="true"></i></a>

				<div class="nav-main__submenu submenu--bg-half" id="nav4_submenu">
					<div class="container">
						<div class="columns columns--flex">

							<div class="col col-3">
								<div class="submenu__ft">
									<?php $featured_image = get_field( 'nav4_ft_img', 'options' );
									if ( $featured_image['url'] ) : ?>
										<img class="submenu__ft__img submenu__img--shadow"
										     src="<?php echo esc_url( $featured_image['sizes']['desktop-nav'] ); ?>"
										     alt="">
									<?php endif; ?>
								</div>
							</div>

							<?php if ( have_rows( 'nav4_columns', 'options' ) ) : ?>
								<ul class="submenu__nav-list col-9">
									<?php while ( have_rows( 'nav4_columns', 'options' ) ) : the_row();
										$column_title = get_sub_field( 'column_title' );
										?>

										<div class="col col-4">
											<?php if ( ! empty( $column_title ) ) { ?>
												<h2 class="column_title"><?php echo esc_attr( $column_title ); ?></h2>
											<?php } else { ?>
												<h2 class="column_title no-border" aria-hidden="true"></h2>
											<?php } ?>

											<?php if ( have_rows( 'links' ) ) : ?>

												<?php while ( have_rows( 'links' ) ) : the_row();
													$link = get_sub_field( 'link' );
													if ( ! empty( $link ) ) {
														$link_target = $link['target'] ? $link['target'] : '_self';
														$link_url    = $link['url'];
														$link_title  = $link['title'];
														?>
														<li>

															<a href="<?php echo esc_url( $link_url ); ?>"
															   target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_attr( $link_title ); ?></a>

														</li>
													<?php } ?>

												<?php endwhile; ?>

											<?php endif; ?>

										</div>

									<?php endwhile; ?>
								</ul>

							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</li>

		<!-- ==================== Nav Item 5 ====================  -->
		<li id="nav5" class="nav-main__item nav-main__item--parent">

			<a href="#" aria-expanded="false" aria-controls="nav5_submenu"><?php echo $acf_options->nav5_label; ?><i
					class="fas fa-angle-down" aria-hidden="true"></i></a>

			<div class="nav-main__submenu" id="nav5_submenu">
				<div class="container">
					<div class="columns columns--flex">

						<div class="col col-3">
							<div class="submenu__ft">
								<?php $featured_image = get_field( 'nav5_ft_img', 'options' );
								if ( $featured_image['url'] ) : ?>
									<img class="submenu__ft__img submenu__img--shadow"
									     src="<?php echo esc_url( $featured_image['sizes']['desktop-nav'] ); ?>" alt="">
								<?php endif; ?>
							</div>
						</div>

						<?php if ( have_rows( 'nav5_columns', 'options' ) ) : ?>

							<?php while ( have_rows( 'nav5_columns', 'options' ) ) : the_row();
								$column_title = get_sub_field( 'column_title' );
								?>

								<div class="col col-3">
									<?php if ( ! empty( $column_title ) ) { ?>
										<h2 class="column_title"><?php echo esc_attr( $column_title ); ?></h2>
									<?php } else { ?>
										<!--<h2 class="column_title no-border" aria-hidden="true"></h2>-->
									<?php } ?>
									<ul class="submenu__nav-list">
										<?php if ( have_rows( 'links' ) ) : ?>

											<?php while ( have_rows( 'links' ) ) : the_row();
												$link        = get_sub_field( 'link' );
												$link_target = $link['target'] ? $link['target'] : '_self'; ?>

												<li>

													<a href="<?php echo esc_url( $link['url'] ); ?>"
													   target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_attr( $link['title'] ); ?></a>

												</li>

											<?php endwhile; ?>

										<?php endif; ?>
									</ul>
								</div>

							<?php endwhile; ?>

						<?php endif; ?>
					</div>
				</div>
			</div>

		</li>


		<!-- ==================== Nav Item 6 ====================  -->
		<li id="nav7" class="nav-main__item nav-main__item--parent">

			<a href="#" aria-expanded="false" aria-controls="nav6_submenu"><?php echo $acf_options->nav6_label; ?><i
					class="fas fa-angle-down" aria-hidden="true"></i></a>

			<div class="nav-main__submenu" id="nav7_submenu">
				<div class="container">
					<div class="columns columns--flex">

						<div class="col col-3">
							<div class="submenu__ft">
								<?php $featured_image = get_field( 'nav6_ft_img', 'options' );
								if ( $featured_image['url'] ) : ?>
									<img class="submenu__ft__img submenu__img--shadow"
									     src="<?php echo esc_url( $featured_image['sizes']['desktop-nav'] ); ?>" alt="">
								<?php endif; ?>
							</div>
						</div>

						<?php if ( have_rows( 'nav5_columns', 'options' ) ) : ?>

							<?php while ( have_rows( 'nav6_columns', 'options' ) ) : the_row();
								$column_title = get_sub_field( 'column_title' );
								?>

								<div class="col col-3">
									<?php if ( ! empty( $column_title ) ) { ?>
										<h2 class="column_title"><?php echo esc_attr( $column_title ); ?></h2>
									<?php } else { ?>
										<!--<h2 class="column_title no-border" aria-hidden="true"></h2>-->
									<?php } ?>
									<ul class="submenu__nav-list">
										<?php if ( have_rows( 'links' ) ) : ?>

											<?php while ( have_rows( 'links' ) ) : the_row();
												$link        = get_sub_field( 'link' );
												$link_target = $link['target'] ? $link['target'] : '_self'; ?>

												<li>

													<a href="<?php echo esc_url( $link['url'] ); ?>"
													   target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_attr( $link['title'] ); ?></a>

												</li>

											<?php endwhile; ?>

										<?php endif; ?>
									</ul>
								</div>

							<?php endwhile; ?>

						<?php endif; ?>
					</div>
				</div>
			</div>

		</li>

		<!-- ==================== Nav Item 7 ====================  -->
		<li id="nav7" class="nav-main__item nav-main__item--parent">

			<a class="red-nav-btn" href="https://ride.jeffersonlines.com/" aria-expanded="false"
			   aria-controls="nav7_submenu"><?php echo $acf_options->nav7_label; ?></a>
			<!-- <div class="nav-main__submenu submenu--bg-third" id="nav6_submenu">
                <div class="container">
                    <div class="columns columns--flex">

                        <div class="col col-3">
                            <div class="submenu__ft">
								<?php $featured_image = get_field( 'nav7_ft_img', 'options' );
			if ( $featured_image['url'] ) : ?>
                                    <img class="submenu__ft__img submenu__img--shadow"
                                         src="<?php echo esc_url( $featured_image['sizes']['desktop-nav'] ); ?>" alt="">
								<?php endif; ?>
                            </div>
                        </div>

						<?php if ( have_rows( 'nav7_columns', 'options' ) ) : ?>

							<?php while ( have_rows( 'nav7_columns', 'options' ) ) : the_row();
				$column_title = get_sub_field( 'column_title' );
				?>

                                <div class="col col-3">
									<?php if ( ! empty( $column_title ) ) { ?>
                                        <h2 class="column_title"><?php echo esc_attr( $column_title ); ?></h2>
									<?php } else { ?>
                                        <h2 class="column_title no-border" aria-hidden="true">&nbsp;</h2>
									<?php } ?>
                                    <ul class="submenu__nav-list">
										<?php if ( have_rows( 'links' ) ) : ?>

											<?php while ( have_rows( 'links' ) ) : the_row();
					$link        = get_sub_field( 'link' );
					$link_target = $link['target'] ? $link['target'] : '_self'; ?>

                                                <li>

                                                    <a class="red-nav-btn" href="<?php echo esc_url( $link['url'] ); ?>"
                                                       target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_attr( $link['title'] ); ?></a>

                                                </li>

											<?php endwhile; ?>

										<?php endif; ?>
                                    </ul>
                                </div>

							<?php endwhile; ?>

						<?php endif; ?>
                    </div>
                </div>
            </div> -->

		</li>
	</ul>
</nav>
