<?php if ( has_post_thumbnail() ) : ?>
  <div>
    <div class="thumbnail thumbnail--small">
      <span class="post-number"><?php echo $i + 1 ?></span>
      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="widget-image d-block">
        <?php the_post_thumbnail('medium-thumbnail', ['class' => 'img-fluid', 'title' => 'Feature image']); ?>
      </a>
    </div>
  </div>
<?php endif; ?>
<?php include (MYPLUGIN__PLUGIN_DIR_PATH . 'widgets/content/description_with_number.php'); ?>
