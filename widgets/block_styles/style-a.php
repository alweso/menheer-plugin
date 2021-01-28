<?php if($show_title) { ?>
  <h2 <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo $settings['title']; ?></h2>
<?php }  ?>
<div class="big-wrapper <?php echo $cssClass; ?>">
  <?php $i = 0; ?>
  <?php while ($queryd->have_posts()) : $queryd->the_post();
  if ( $i == 0 ) : ?>
  <div class="wrapper wrapper--big">
    <?php include (MYPLUGIN__PLUGIN_DIR_PATH . 'widgets/content/content-3.php'); ?>
  </div>
<?php endif;
if ( $i > 0 ) : ?>
<div class="wrapper wrapper--small">
  <?php include (MYPLUGIN__PLUGIN_DIR_PATH . 'widgets/content/content-2.php'); ?>
</div>
<?php endif; ?>
<?php $i++; ?>
<?php endwhile; ?>
</div>
