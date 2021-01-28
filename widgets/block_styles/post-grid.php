<div class="big-wrapper">
  <?php while ($queryd->have_posts()) : $queryd->the_post(); ?>
  <div class="wrapper wrapper--big">
    <?php include (MYPLUGIN__PLUGIN_DIR_PATH . 'widgets/content/content-1.php'); ?>
  </div>
  <?php endwhile; ?>
</div>
