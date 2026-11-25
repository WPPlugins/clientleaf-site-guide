<?php
/** @var array<string, mixed> $vexmedia_clientleaf_site_guide_settings */
/** @var array<int, array<string, mixed>> $vexmedia_clientleaf_site_guide_quick_links */
/** @var array<string, string> $vexmedia_clientleaf_site_guide_website_info */
/** @var array<string, string> $vexmedia_clientleaf_site_guide_support */

defined( 'ABSPATH' ) || exit;

$vexmedia_clientleaf_site_guide_show_quick_links = ! empty( $vexmedia_clientleaf_site_guide_settings['show_quick_actions'] ) && ! empty( $vexmedia_clientleaf_site_guide_quick_links );
$vexmedia_clientleaf_site_guide_show_website     = ! empty( $vexmedia_clientleaf_site_guide_settings['show_website_info'] ) && \VexMedia\ClientleafSiteGuide\has_populated_value( $vexmedia_clientleaf_site_guide_website_info );
$vexmedia_clientleaf_site_guide_show_support     = ! empty( $vexmedia_clientleaf_site_guide_settings['show_support'] ) && \VexMedia\ClientleafSiteGuide\has_populated_value( $vexmedia_clientleaf_site_guide_support );
$vexmedia_clientleaf_site_guide_show_notes       = ! empty( $vexmedia_clientleaf_site_guide_settings['show_helpful_notes'] ) && \VexMedia\ClientleafSiteGuide\has_populated_value( array( $vexmedia_clientleaf_site_guide_settings['helpful_notes'] ) );
$vexmedia_clientleaf_site_guide_has_sections     = $vexmedia_clientleaf_site_guide_show_quick_links || $vexmedia_clientleaf_site_guide_show_website || $vexmedia_clientleaf_site_guide_show_support || $vexmedia_clientleaf_site_guide_show_notes;
?>
<div class="wrap clientleaf-site-guide-wrap clientleaf-site-guide-dashboard">
	<header class="clientleaf-site-guide-dashboard__header">
		<h1><?php echo esc_html( (string) $vexmedia_clientleaf_site_guide_settings['dashboard_heading'] ); ?></h1>
		<?php if ( '' !== trim( (string) $vexmedia_clientleaf_site_guide_settings['intro_message'] ) ) : ?>
			<p class="clientleaf-site-guide-dashboard__intro"><?php echo nl2br( esc_html( (string) $vexmedia_clientleaf_site_guide_settings['intro_message'] ) ); ?></p>
		<?php endif; ?>
	</header>

	<?php if ( $vexmedia_clientleaf_site_guide_show_quick_links ) : ?>
		<section class="clientleaf-site-guide-section" aria-labelledby="clientleaf-site-guide-quick-actions-heading">
			<h2 id="clientleaf-site-guide-quick-actions-heading"><?php esc_html_e( 'Quick Actions', 'clientleaf-site-guide' ); ?></h2>
			<div class="clientleaf-site-guide-action-grid">
				<?php foreach ( $vexmedia_clientleaf_site_guide_quick_links as $vexmedia_clientleaf_site_guide_link ) : ?>
					<a class="clientleaf-site-guide-action-card" href="<?php echo esc_url( \VexMedia\ClientleafSiteGuide\link_url( $vexmedia_clientleaf_site_guide_link['url'] ) ); ?>">
						<?php if ( ! empty( $vexmedia_clientleaf_site_guide_link['icon'] ) ) : ?>
							<span class="dashicons dashicons-<?php echo esc_attr( (string) $vexmedia_clientleaf_site_guide_link['icon'] ); ?>" aria-hidden="true"></span>
						<?php endif; ?>
						<span class="clientleaf-site-guide-action-card__content">
							<strong><?php echo esc_html( (string) ( $vexmedia_clientleaf_site_guide_link['label'] ?? '' ) ); ?></strong>
							<?php if ( ! empty( $vexmedia_clientleaf_site_guide_link['description'] ) ) : ?>
								<span><?php echo esc_html( (string) $vexmedia_clientleaf_site_guide_link['description'] ); ?></span>
							<?php endif; ?>
						</span>
						<span class="dashicons dashicons-arrow-right-alt2 clientleaf-site-guide-action-card__arrow" aria-hidden="true"></span>
					</a>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<div class="clientleaf-site-guide-dashboard-grid">
		<?php if ( $vexmedia_clientleaf_site_guide_show_website ) : ?>
			<section class="clientleaf-site-guide-card" aria-labelledby="clientleaf-site-guide-website-information-heading">
				<h2 id="clientleaf-site-guide-website-information-heading"><?php esc_html_e( 'Website Information', 'clientleaf-site-guide' ); ?></h2>
				<dl class="clientleaf-site-guide-details">
					<?php
					$vexmedia_clientleaf_site_guide_fields = array(
						'website_name' => __( 'Website name', 'clientleaf-site-guide' ),
						'website_url'  => __( 'Website URL', 'clientleaf-site-guide' ),
						'hosting'      => __( 'Hosting provider', 'clientleaf-site-guide' ),
						'domain'       => __( 'Domain provider', 'clientleaf-site-guide' ),
						'developer'    => __( 'Developer or agency', 'clientleaf-site-guide' ),
						'launch_date'  => __( 'Launch date', 'clientleaf-site-guide' ),
					);
					foreach ( $vexmedia_clientleaf_site_guide_fields as $vexmedia_clientleaf_site_guide_key => $vexmedia_clientleaf_site_guide_label ) :
						if ( empty( $vexmedia_clientleaf_site_guide_website_info[ $vexmedia_clientleaf_site_guide_key ] ) ) {
							continue;
						}
						?>
						<div class="clientleaf-site-guide-details__row">
							<dt><?php echo esc_html( $vexmedia_clientleaf_site_guide_label ); ?></dt>
							<dd>
								<?php if ( 'website_url' === $vexmedia_clientleaf_site_guide_key ) : ?>
									<a href="<?php echo esc_url( \VexMedia\ClientleafSiteGuide\link_url( $vexmedia_clientleaf_site_guide_website_info[ $vexmedia_clientleaf_site_guide_key ] ) ); ?>"><?php echo esc_html( $vexmedia_clientleaf_site_guide_website_info[ $vexmedia_clientleaf_site_guide_key ] ); ?></a>
								<?php elseif ( 'launch_date' === $vexmedia_clientleaf_site_guide_key ) : ?>
									<?php echo esc_html( mysql2date( get_option( 'date_format' ), $vexmedia_clientleaf_site_guide_website_info[ $vexmedia_clientleaf_site_guide_key ] . ' 00:00:00' ) ); ?>
								<?php else : ?>
									<?php echo esc_html( $vexmedia_clientleaf_site_guide_website_info[ $vexmedia_clientleaf_site_guide_key ] ); ?>
								<?php endif; ?>
							</dd>
						</div>
					<?php endforeach; ?>
				</dl>
				<?php if ( ! empty( $vexmedia_clientleaf_site_guide_website_info['general_notes'] ) ) : ?>
					<div class="clientleaf-site-guide-prose clientleaf-site-guide-prose--bordered"><?php echo nl2br( esc_html( $vexmedia_clientleaf_site_guide_website_info['general_notes'] ) ); ?></div>
				<?php endif; ?>
			</section>
		<?php endif; ?>

		<?php if ( $vexmedia_clientleaf_site_guide_show_support ) : ?>
			<section class="clientleaf-site-guide-card" aria-labelledby="clientleaf-site-guide-support-heading">
				<h2 id="clientleaf-site-guide-support-heading"><?php esc_html_e( 'Support', 'clientleaf-site-guide' ); ?></h2>
				<?php if ( ! empty( $vexmedia_clientleaf_site_guide_support['message'] ) ) : ?>
					<div class="clientleaf-site-guide-prose"><?php echo wp_kses_post( wpautop( $vexmedia_clientleaf_site_guide_support['message'] ) ); ?></div>
				<?php endif; ?>
				<ul class="clientleaf-site-guide-contact-list">
					<?php if ( ! empty( $vexmedia_clientleaf_site_guide_support['name'] ) ) : ?>
						<li><span class="dashicons dashicons-businessperson" aria-hidden="true"></span><span><?php echo esc_html( $vexmedia_clientleaf_site_guide_support['name'] ); ?></span></li>
					<?php endif; ?>
					<?php if ( ! empty( $vexmedia_clientleaf_site_guide_support['email'] ) ) : ?>
						<li><span class="dashicons dashicons-email-alt" aria-hidden="true"></span><a href="<?php echo esc_url( 'mailto:' . $vexmedia_clientleaf_site_guide_support['email'], array( 'mailto' ) ); ?>"><?php echo esc_html( $vexmedia_clientleaf_site_guide_support['email'] ); ?></a></li>
					<?php endif; ?>
					<?php if ( ! empty( $vexmedia_clientleaf_site_guide_support['phone'] ) ) : ?>
						<li><span class="dashicons dashicons-phone" aria-hidden="true"></span>
							<?php if ( preg_match( '/[0-9]/', $vexmedia_clientleaf_site_guide_support['phone'] ) ) : ?>
								<a href="<?php echo esc_url( 'tel:' . \VexMedia\ClientleafSiteGuide\phone_link_value( $vexmedia_clientleaf_site_guide_support['phone'] ), array( 'tel' ) ); ?>"><?php echo esc_html( $vexmedia_clientleaf_site_guide_support['phone'] ); ?></a>
							<?php else : ?>
								<span><?php echo esc_html( $vexmedia_clientleaf_site_guide_support['phone'] ); ?></span>
							<?php endif; ?>
						</li>
					<?php endif; ?>
					<?php if ( ! empty( $vexmedia_clientleaf_site_guide_support['url'] ) ) : ?>
						<li><span class="dashicons dashicons-admin-links" aria-hidden="true"></span><a href="<?php echo esc_url( \VexMedia\ClientleafSiteGuide\link_url( $vexmedia_clientleaf_site_guide_support['url'] ) ); ?>"><?php esc_html_e( 'Visit support website', 'clientleaf-site-guide' ); ?></a></li>
					<?php endif; ?>
				</ul>
			</section>
		<?php endif; ?>

		<?php if ( $vexmedia_clientleaf_site_guide_show_notes ) : ?>
			<section class="clientleaf-site-guide-card clientleaf-site-guide-card--wide" aria-labelledby="clientleaf-site-guide-helpful-notes-heading">
				<h2 id="clientleaf-site-guide-helpful-notes-heading"><?php esc_html_e( 'Helpful Notes', 'clientleaf-site-guide' ); ?></h2>
				<div class="clientleaf-site-guide-prose"><?php echo wp_kses_post( wpautop( (string) $vexmedia_clientleaf_site_guide_settings['helpful_notes'] ) ); ?></div>
			</section>
		<?php endif; ?>
	</div>

	<?php if ( ! $vexmedia_clientleaf_site_guide_has_sections ) : ?>
		<div class="clientleaf-site-guide-card clientleaf-site-guide-empty-state">
			<span class="dashicons dashicons-welcome-learn-more" aria-hidden="true"></span>
			<h2><?php esc_html_e( 'Your website guide is ready', 'clientleaf-site-guide' ); ?></h2>
			<p><?php esc_html_e( 'An administrator can add useful links, website information, support details, and notes here.', 'clientleaf-site-guide' ); ?></p>
		</div>
	<?php endif; ?>
</div>
