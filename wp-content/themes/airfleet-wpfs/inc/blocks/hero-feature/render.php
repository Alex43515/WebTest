<?php
/**
 * Hero Feature block render template (no-JS toggle)
 * - Respects ACF 'Additional CSS class(es)' and 'Anchor'
 * - Wraps summary + body inside .af-hero__copy so they can be positioned as a single unit on mobile
 * - Defensive empty-state handling (no empty tags/wrappers)
 * - Proper escaping, safe attributes, and minor a11y improvements
 */

/** -------------------------------
 *  Fetch & sanitize field values
 *  ------------------------------- */
$layout_raw = get_field('layout') ?: 'text_left';
$layout     = in_array($layout_raw, ['text_left','text_right'], true) ? $layout_raw : 'text_left';

$headline   = trim((string) get_field('headline'));
$sub        = trim((string) get_field('subheadline'));
$summary    = trim((string) get_field('summary')); // plain text
$body       = get_field('body');                   // may contain HTML from WYSIWYG

$cta        = (array) get_field('cta_group');
$cta_label  = isset($cta['label']) ? trim((string) $cta['label']) : '';
$cta_url    = isset($cta['url'])   ? trim((string) $cta['url'])   : '';
$cta_target = isset($cta['target']) ? trim((string) $cta['target']) : '';

$image      = (array) get_field('image');
$image_alt  = trim((string) get_field('image_alt'));

// Image URL + ALT (prefer sized variant if present)
$img_url = '';
$img_alt = '';
if (!empty($image)) {
  $img_url = $image['sizes']['large'] ?? ($image['url'] ?? '');
  // prefer explicit custom alt, then media alt; allow empty string for decorative images
  $img_alt = ($image_alt !== '') ? $image_alt : (isset($image['alt']) ? (string) $image['alt'] : '');
}

/** --------------------------------
 *  Block wrapper attributes from ACF
 *  -------------------------------- */
$id_attr = '';
if (!empty($block['anchor'])) {
  $id_attr = ' id="' . esc_attr($block['anchor']) . '"';
}
$classes = ['af-hero', "af-hero--{$layout}"];
if (!empty($block['className'])) { $classes[] = $block['className']; }
if (!empty($block['align']))     { $classes[] = 'align' . $block['align']; }

/** --------------------------------
 *  Unique id for the no-JS toggle
 *  -------------------------------- */
$toggle_id = !empty($block['id'])
  ? 'af-hero-toggle-' . sanitize_html_class($block['id'])
  : 'af-hero-toggle-' . wp_rand();

/** --------------------------------
 *  Helpers
 *  -------------------------------- */
$has_media   = (bool) $img_url;
$has_cta     = ($cta_label !== '' && $cta_url !== '');
$has_summary = ($summary !== '');
$has_body    = !empty($body); // allow HTML; consider empty if null/''

?>
<section class="<?php echo esc_attr(implode(' ', $classes)); ?>"<?php echo $id_attr; ?>>
  <div class="af-hero__inner">

    <div class="af-hero__text">
      <?php if ($headline !== ''): ?>
        <h2 class="af-hero__headline"><?php echo esc_html($headline); ?></h2>
      <?php endif; ?>

      <?php if ($sub !== ''): ?>
        <p class="af-hero__sub"><?php echo esc_html($sub); ?></p>
      <?php endif; ?>

      <?php
      /**
       * Summary + Body as one logical group
       * - Desktop: summary + "Read more" (if body exists). Body starts hidden via CSS (no-JS toggle).
       * - Mobile: both summary + body visible; "Read more" hidden via CSS.
       * - We only render the wrapper if at least one of the two exists.
       */
      ?>
      <?php if ($has_summary || $has_body): ?>
        <div class="af-hero__copy">
          <?php if ($has_summary): ?>
            <?php if ($has_body): ?>
              <!-- Hidden checkbox controls the toggle (no JS needed) -->
              <input
                type="checkbox"
                id="<?php echo esc_attr($toggle_id); ?>"
                class="af-hero__toggle"
                hidden
                aria-controls="<?php echo esc_attr($toggle_id); ?>-body"
                aria-expanded="false"
              >
            <?php endif; ?>

            <p class="af-hero__summary">
              <?php echo esc_html($summary); ?>
              <?php if ($has_body): ?>
                <!-- Label acts as the Read more button, inline with summary -->
                <label
                  for="<?php echo esc_attr($toggle_id); ?>"
                  class="af-hero__readmore"
                >
                  <?php echo esc_html__('Read more', 'airfleet'); ?>
                </label>
              <?php endif; ?>
            </p>
          <?php endif; ?>

          <?php if ($has_body): ?>
            <div
              id="<?php echo esc_attr($toggle_id); ?>-body"
              class="af-hero__body"
              data-collapsible="true"
              aria-hidden="true"
            >
              <?php
                // Allow safe HTML from WYSIWYG
                echo wp_kses_post($body);
              ?>
            </div>
          <?php endif; ?>
        </div><!-- /.af-hero__copy -->
      <?php endif; ?>

      <?php if ($has_cta): ?>
        <div class="af-hero__actions">
          <a
            class="btn af-hero__btn"
            href="<?php echo esc_url($cta_url); ?>"
            <?php if ($cta_target !== ''): ?>
              target="<?php echo esc_attr($cta_target); ?>"
              <?php
              // add rel when opening new tab
              $rel = ($cta_target === '_blank') ? 'noopener noreferrer' : '';
              if ($rel !== ''): ?>
                rel="<?php echo esc_attr($rel); ?>"
              <?php endif; ?>
            <?php endif; ?>
          >
            <?php echo esc_html($cta_label); ?>
          </a>
        </div>
      <?php endif; ?>
    </div><!-- /.af-hero__text -->

    <?php if ($has_media): ?>
      <div class="af-hero__media">
        <img
          src="<?php echo esc_url($img_url); ?>"
          alt="<?php echo esc_attr($img_alt); ?>"
          loading="lazy"
          decoding="async"
        />
      </div>
    <?php endif; ?>

  </div><!-- /.af-hero__inner -->
</section>