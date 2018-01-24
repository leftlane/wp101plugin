<?php
/**
 * Show available add-ons from WP101.
 *
 * @global $api       An instance of WP101\API;
 * @global $addons    An array of add-ons from the WP101 API.
 * @global $purchased Slugs of any Series this site already has access to.
 *
 * @package WP101
 */

use WP101\TemplateTags as TemplateTags;

?>

<main class="wrap wp101-addons">
	<h1>
		<?php echo esc_html( _x( 'WP101 Add-ons', 'listings page title', 'wp101' ) ); ?>
	</h1>

	<?php settings_errors(); ?>

	<?php if ( empty( $addons['addons'] ) ) : ?>

		<div class="notice notice-warning">
			<p><?php esc_html_e( 'There are no add-ons currently available for WP101!', 'wp101' ); ?></p>
		</div>

	<?php else : ?>

		<p><?php esc_html_e( 'Enhance your WP101 experience with these add-ons:', 'wp101' ); ?></p>

		<div class="wp101-addon-list">
			<?php foreach ( $addons['addons'] as $addon ) : ?>
				<?php $has_addon = isset( $addon['slug'] ) && in_array( $addon['slug'], $purchased, true ); ?>

				<div class="card wp101-addon">
					<h2><?php echo esc_html( $addon['title'] ); ?></h2>
					<?php if ( ! empty( $addon['description'] ) ) : ?>
						<div class="wp101-addon-description">
							<?php echo wp_kses_post( wpautop( $addon['description'] ) ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $addon['topics'] ) ) : ?>
						<h3><?php esc_html_e( 'In this series:', 'wp101' ); ?></h3>
						<?php TemplateTags\list_topics( $addon['topics'], 3, $addon['url'] ); ?>
					<?php endif; ?>

					<p class="wp101-addon-button">
						<?php if ( $has_addon ) : ?>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=wp101' ) ); ?>" class="button button-secondary"><?php echo esc_html_e( 'Watch Videos', 'wp101' ); ?></a>

						<?php elseif ( ! empty( $addon['url'] ) ) : ?>
							<a href="<?php echo esc_url( $addon['url'] ); ?>" class="button button-primary" target="_blank"><?php echo esc_html_e( 'Get Add-on', 'wp101' ); ?></a>
						<?php endif; ?>
					</p>
				</div>

			<?php endforeach; ?>
		</div>

	<?php endif; ?>
</main>