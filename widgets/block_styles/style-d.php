<?php if($show_title) { ?>
  <h2 class="menheer-block-title" <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo $settings['title']; ?></h2>
<?php }  ?>
<div class="big-wrapper" style="">
  <?php $i = 0; ?>
  <?php while ($queryd->have_posts()) : $queryd->the_post();
  if ( $i == 0 || $i == 1 ) : ?>
  <div class="wrapper wrapper--big">
    <?php $category_display = $big_category_display ?>
    <?php include (MYPLUGIN__PLUGIN_DIR_PATH . 'widgets/content/content-1.php'); ?>
  </div>
<?php else : ?>
  <div class="wrapper wrapper--small">
    <?php $category_display = $small_category_display ?>
    <?php include (MYPLUGIN__PLUGIN_DIR_PATH . 'widgets/content/content-2.php'); ?>
  </div>
<?php endif; ?>
<?php $i++; ?>
<?php endwhile; ?>
</div>
