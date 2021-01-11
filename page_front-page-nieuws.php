<?php

/**
 * // * Rijkshuisstijl (Digitale Overheid) - page_front-page-nieuws.php
 * // * ----------------------------------------------------------------------------------
 * // * speciale functionaliteit voor de nieuwe homepage
 * // * ----------------------------------------------------------------------------------
 * //
 * // * @author  Paul van Buuren
 * // * @license GPL-2.0+
 * // * @package wp-rijkshuisstijl
 * // * @version 2.12.11
 * // * @desc.   Kopstructuur homepage verbeterd.
 * // * @link    https://github.com/ICTU/digitale-overheid-wordpress-theme-rijkshuisstijl
 * //
 */

//* Template Name: DO - Homepage met nieuws (2021)


//* Force full-width-content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


// Geen caroussel tonen
remove_action( 'genesis_after_header', 'rhswp_check_caroussel_or_featured_img', 22 );

remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

//========================================================================================================

// geen titel meer tonen of de standaard pagina-inhoud
remove_action( 'genesis_loop', 'genesis_do_loop' );

// eerste blok met uitgelicht artikel
add_action( 'genesis_loop', 'rhswp_home_onderwerpen_dossiers', 8 );

// nieuws
add_action( 'genesis_loop', 'rhswp_write_extra_contentblokken', 14 );

//========================================================================================================

genesis();

//========================================================================================================

function rhswp_home_onderwerpen_dossiers() {

	global $post;

	$theid                  = $post->ID;
	$etalage_titel          = '';
	$etalage_url            = '';
	$etalage_image          = '';
	$etalage_label          = '';
	$etalage_excerpt        = '&nbsp;';
	$uitgelicht_titel       = '';
	$uitgelicht_titel_class = '';
	$uitgelicht_url2        = '';
	$uitgelicht_image       = '';
	$uitgelicht_label       = '';
	$uitgelicht_excerpt     = '&nbsp;';
	$skip_posts             = array(); // array with IDs for posts to be skipped in loop

	if ( 'method_auto' === get_field( 'home_row_1_cell_1_method', $theid ) ) {
		$etalage_post    = get_field( 'home_row_1_cell_1_post', $theid );
		$etalage_post_id = $etalage_post[0]->ID;
		$etalage_titel   = get_the_title( $etalage_post_id );
		$etalage_url     = get_permalink( $etalage_post_id );
		$etalage_excerpt = get_the_excerpt( $etalage_post_id );
		$etalage_image   = get_the_post_thumbnail( $etalage_post_id, IMAGESIZE_16x9 );
		$etalage_label   = rhswp_get_sublabel( $etalage_post_id );
		$skip_posts[]    = $etalage_post_id;
	} elseif ( get_field( 'home_row_1_cell_1_featured_link', $theid ) ) {
		// er is geen featured post uitgekozen; misschien zijn er wel een plaatje en link ingevoerd?
		$etalage_link  = get_field( 'home_row_1_cell_1_featured_link', $theid );
		$etalage_titel = $etalage_link['title'];
		$etalage_url   = $etalage_link['url'];
		if ( get_field( 'home_row_1_cell_1_featured_image', $theid ) ) {
			$image = get_field( 'home_row_1_cell_1_featured_image', $theid );
			if ( $image['ID'] ) {
				$etalage_image = wp_get_attachment_image( $image['ID'], IMAGESIZE_16x9 );
			}
		}
		if ( get_field( 'home_row_1_cell_1_featured_label', $theid ) ) {
			$etalage_label = get_field( 'home_row_1_cell_1_featured_label', $theid );
		}
	}

	if ( 'method_auto' === get_field( 'home_row_1_cell_2_method', $theid ) ) {
		$uitgelicht_post    = get_field( 'home_row_1_cell_2_post', $theid );
		$uitgelicht_post_id = $uitgelicht_post[0]->ID;
		$uitgelicht_titel   = get_the_title( $uitgelicht_post_id );
		$uitgelicht_url2    = get_permalink( $uitgelicht_post_id );
		$uitgelicht_excerpt = get_the_excerpt( $uitgelicht_post_id );
		$uitgelicht_image   = get_the_post_thumbnail( $uitgelicht_post_id, IMAGESIZE_16x9 );
		$skip_posts[]       = $uitgelicht_post_id;
	} elseif ( get_field( 'home_row_1_cell_2_textcontent', $theid ) ) {
		$uitgelicht_titel       = _x( "Uitgelicht", 'breadcrumb', 'wp-rijkshuisstijl' );
		$uitgelicht_titel_class = ' class="visuallyhidden"';
		$uitgelicht_excerpt     = get_field( 'home_row_1_cell_2_textcontent', $theid );
		if ( get_field( 'home_row_1_cell_2_featured_image', $theid ) ) {
			$image = get_field( 'home_row_1_cell_2_featured_image', $theid );
			if ( $image['ID'] ) {
				$uitgelicht_image = wp_get_attachment_image( $image['ID'], IMAGESIZE_16x9 );
			}
		}
	}


	$maxnr      = 4;
	$rowcounter = 0;
	$breedte    = 'vollebreedte';


	if ( $uitgelicht_titel || $etalage_titel ) {

		echo '<section class="grid">';

		echo '<div class="grid-item float-text colspan-2">';

		echo $etalage_image . '<a href="' . $etalage_url . '">';

		$itemtitle = '<div class="text">';
		if ( $etalage_label ) {
			$itemtitle .= '<div class="label">' . $etalage_label . '</div>';
		}
		$itemtitle .= '<h2>' . $etalage_titel . '</h2>';
		$itemtitle .= '</div>';

		echo $itemtitle;
		echo '</a>';
		echo '</div>';


		if ( $uitgelicht_titel ) {
			// een soort fallback: als er geen uitgelichte content is, dan tonen we de samenvatting van de etalage

			echo '<div class="grid-item">';
			echo '<h2' . $uitgelicht_titel_class . '><a href="' . $uitgelicht_url2 . '">' . $uitgelicht_titel . '</a></h2>';
			if ( $uitgelicht_image ) {
				echo '<a href="' . $uitgelicht_url2 . '" tabindex="-1">';
				echo $uitgelicht_image;
				echo '</a>';
			}
			if ( $uitgelicht_label ) {
				echo '<div class="label">' . $uitgelicht_label . '</div>';
			}
			echo $uitgelicht_excerpt;
			echo '</div>';

		} else {
			echo '<div class="grid-item">';
			echo $etalage_excerpt;
			echo '</div>';

		}

		echo '</section>';
	}


	$home_rows = get_field( 'home_rows', $theid );

	if ( ( is_array( $home_rows ) || is_object( $home_rows ) ) && ( $home_rows[0] != '' ) ) {


		foreach ( $home_rows as $row ) {

			$titel     = $row['home_row_title'];
			$limit     = $row['home_row_max_nr'];
			$gridclass = 'grid';

			switch ( $row['home_row_type'] ) {

				case 'free_form':
					if ( $row['home_row_freeform'] ) {

						echo '<div class="' . $gridclass . '">';
						foreach ( $row['home_row_freeform'] as $row2 ) {
							$itemclass = 'grid-item';
							$excerpt   = $row2['home_row_freeform_text'];
							$itemtitle = '<h2>' . $row2['home_row_freeform_title'] . '</h2>';
							if ( $row2['home_row_freeform_width'] ) {
								$itemclass .= ' ' . $row2['home_row_freeform_width'];
							} else {
								$itemclass .= ' colspan-1';
							}

							echo '<div class="' . $itemclass . ' container">';
							echo $itemtitle;
							echo $excerpt;
							echo '</div>';

//							dovardump2( $row2 );
						}
						echo '</div>';

					}

					break;
				case 'events':

					if ( class_exists( 'EM_Events' ) ) {

						$events_link = em_get_link( __( 'all events', 'events-manager' ) );
						$args        = array(
							'scope' => 'future',
							'limit' => $limit,
							'array' => true
						);

						$events = EM_Events::get( $args );

						if ( $events ) {

							echo '<div class="container">';

							if ( $titel ) {
								echo '<h2>' . $titel . '</h2>';
							}

							echo '<div class="' . $gridclass . '">';

							foreach ( $events as $event ):

								$excerpt       = get_the_excerpt( $event['post_id'] );
								$itemtitle     = '<h3><a href="' . get_the_permalink( $event['post_id'] ) . '">' . $event['event_name'] . '</a></h3>';
								$itemclass     = 'grid-item';
								$EM_Event      = new EM_Event( $event['event_id'] );
								$datum         = $EM_Event->output( '#_EVENTDATES' );
								$tijd          = $EM_Event->output( '#_EVENTTIMES' );
								$location_town = $EM_Event->output( '#_LOCATIONTOWN' );

								echo '<div class="' . $itemclass . '">';
								echo $itemtitle;
								echo $excerpt;
								if ( $datum || $tijd || $location_town ) {

									echo '<ul class="event-meta">';
									if ( $datum ) {
										echo '<li class="event-date">' . $datum . '</li>';
									}
									if ( $tijd ) {
										echo '<li class="event-time">' . $tijd . '</li>';
									}
									if ( $location_town ) {
										echo '<li class="event-town">' . $location_town . '</li>';
									}
									echo '</ul>';
								}

								echo '</div>';

							endforeach;

							echo '</div>';
							if ( $events_link ) {
								echo '<p class="more">' . $events_link . '</p>';
							}
							echo '</div>';

						}


					}

					break;
				case 'posts_featured':
				case 'posts_normal':

					$slugs = $row['home_row_category'];
					$args  = array(
						'post_type'      => 'post',
						'post_status'    => 'publish',
						'posts_per_page' => $limit,
					);

					if ( $row['home_row_type'] === $row['home_row_type'] ) {
						// alle blokken dezelfde hoogte, svp
						$gridclass .= ' stretch';
					}

					if ( $slugs ) {
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'category',
								'field'    => 'term_id',
								'terms'    => $slugs,
							)
						);

						$cat_name  = get_cat_name( $slugs );
						$more_text = _x( "Alle berichten onder %s", 'readmore home', 'wp-rijkshuisstijl' );
						$more_url  = get_category_link( $slugs );
						if ( $row['home_row_readmore'] ) {
							$more_text = $row['home_row_readmore'];
						}
						if ( strpos( $more_text, '%s' ) ) {
							$more_text = sprintf( $more_text, strtolower( $cat_name ) );
						}
					}

					if ( $skip_posts ) {
						$args['post__not_in'] = $skip_posts;
					}

					$contentblockposts = new WP_query();
					$contentblockposts->query( $args );

					if ( $contentblockposts->have_posts() ) {
						echo '<div class="container">';
						if ( $titel ) {
							echo '<h2>' . $titel . '</h2>';
						}

						echo '<div class="' . $gridclass . '">';

						while ( $contentblockposts->have_posts() ) : $contentblockposts->the_post();
							$contentblock_post_id = $post->ID;
							$skip_posts[]         = $contentblock_post_id;
							$itemclass            = 'grid-item';
							$itemdate             = get_the_date( get_option( 'date_format' ), $contentblock_post_id );
							$contentblock_image   = get_the_post_thumbnail( $contentblock_post_id, IMAGESIZE_4x3_SMALL );
							$contentblock_titel   = get_the_title( $contentblock_post_id );
							$contentblock_url     = get_permalink( $contentblock_post_id );
							$excerpt              = '';
							$itemtitle            = '';
							$contentblock_label   = rhswp_get_sublabel( $contentblock_post_id );

							if ( $row['home_row_type'] === 'posts_featured' ) {
								$itemclass          = 'grid-item float-text';
								$contentblock_image = get_the_post_thumbnail( $contentblock_post_id, IMAGESIZE_SQUARE_SMALL );
								$itemtitle          = '<div class="text">';
								if ( $contentblock_label ) {
									$itemtitle .= '<div class="label">' . $contentblock_label . '</div>';
								}
								$itemtitle .= '<h2>' . $contentblock_titel . '</h2>';
								$itemtitle .= '</div>';

								// het hele blok klikbaar maken
								echo '<div class="' . $itemclass . '">';
								echo $contentblock_image . '<a href="' . $contentblock_url . '">';
								echo $itemtitle;
								echo '</a>';
								echo '</div>';

							} else {
								if ( $contentblock_label ) {
									$itemtitle .= '<div class="label">' . $contentblock_label . '</div>';
								}
								$itemtitle .= '<h3><a href="' . $contentblock_url . '">' . $contentblock_titel . '</a></h3>';
								$itemtitle .= '<p class="publishdaet">' . $itemdate . '</p>';
								$excerpt   = wp_strip_all_tags( get_the_excerpt( $contentblock_post_id ) );
								if ( $contentblock_image && $contentblock_url ) {
									$contentblock_image = '<a tabindex="-1" href="' . $contentblock_url . '">' . $contentblock_image . '</a>';
								}

								echo '<div class="' . $itemclass . '">';
								echo $contentblock_image;
								echo $itemtitle;
								echo $excerpt;
								echo '</div>';

							}


						endwhile;

						echo '</div>';
						echo '<p class="more"><a href="' . $more_url . '">' . $more_text . '</a></p>';
						echo '</div>';

					}

					break;
			}
		}
	}


}

//========================================================================================================

