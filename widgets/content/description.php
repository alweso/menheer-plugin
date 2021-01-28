<div class="description">
  <div class="description-inner">
    <?php if($show_cat) { ?>
      <div class="category">
        <?php
        $categories = get_the_category();
        foreach ( $categories as $category ) {
          echo '<span style="display: inline-block;
          color: white;
          padding: 4px 7px;
    margin-right: 10px;
    background-color: #177c51;
    font-size: 10px;
    font-family: Arial;
    font-weight: 500;
    border-radius: 2px;
    line-height: 10px; background-color:'.get_field('category_colors', $category).';border-radius:2px;" class="acf-category-color">'.$category->name.'</span>';
        }
        ?>
      </div>
    <?php }  ?>
    <h4 class="news-title">
      <?php if (has_post_format('video')) { ?>
                <i class="fa fa-video"></i>
    <?php  } elseif (has_post_format('gallery')) { ?>
        <i class="fa fa-images"></i>
  <?php  } ?>
      <?php echo esc_html(wp_trim_words(get_the_title(), $crop,'')); ?></h4>
    <?php if(isset($show_exerpt) && $show_exerpt == "yes" || isset($show_exerpt_2)  && $show_exerpt_2 == "yes") : ?>
      <p><?php echo esc_html( wp_trim_words(get_the_excerpt(),$post_content_crop,'...') );?></p>
    <?php endif ?>
    <span class="comments-views-date">
      <?php if($show_comments) { ?>
        <span class="comments">
          <i class="fa fa-comment"></i><?php  echo get_comments_number(); ?>
        </span>
      <?php }  ?>
      <?php if($show_views) { ?>
        <span class="views">
          <i class="fa fa-eye"></i><?php  echo gt_get_post_view(); ?>
        </span>
      <?php }  ?>
      <?php if($show_date) { ?>
        <span class="date">
          <i class="fa fa-calendar"></i><?php echo get_the_date('Y-m-d'); ?>
        </span>
      <?php }  ?>
      <?php if($show_author == "yes") {?>
        <span class="author">
          <i class="fa fa-user-edit"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a>
        </span>
      <?php } ?>
    </span>
    <?php if($show_tags == "yes") { ?>
      <div class="tags">
        <?php  the_tags(); ?>
      </div>
    <?php }  ?>
  </div>
</div>
