<div class="description">
  <div class="description-inner">
    <?php if($show_cat_small) { ?>
      <div class="category">
        <?php
        $categories2 = get_the_category();
        foreach ( $categories2 as $category2 ) {
          echo '<span style="display: inline-block;
          color: white;
          padding: 4px 7px;
    margin-right: 10px;
    background-color: #177c51;
    font-size: 10px;
    font-family: Arial;
    font-weight: 500;
    border-radius: 2px;
    line-height: 10px; background-color:'.get_field('category_colors', $category2).';border-radius:2px;" class="acf-category-color">'.$category2->name.'</span>';
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
      <?php echo esc_html(wp_trim_words(get_the_title(), $crop_small,'')); ?></h4>
    <span class="comments-views-date">
      <?php if($show_comments_small) { ?>
        <span class="comments">
          <i class="fa fa-comment"></i><?php  echo get_comments_number(); ?>
        </span>
      <?php }  ?>
      <?php if($show_views_small) { ?>
        <span class="views">
          <i class="fa fa-eye"></i><?php  echo gt_get_post_view(); ?>
        </span>
      <?php }  ?>
      <?php if($show_date_small) { ?>
        <span class="date">
          <i class="fa fa-calendar"></i><?php echo get_the_date('Y-m-d'); ?>
        </span>
      <?php }  ?>
    </span>
  </div>
</div>
