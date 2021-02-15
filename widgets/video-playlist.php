<?php
namespace ElementorAwesomesauce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class VideoPlaylist extends Widget_Base {

  public function __construct( $data = array(), $args = null ) {
    parent::__construct( $data, $args );
    wp_register_style( 'general', plugins_url( '/assets/css/general.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
    wp_register_style( 'video-playlist', plugins_url( '/assets/css/video-playlist.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
  }

  /**
   * Retrieve the widget name.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'video-playlist';
  }

  /**
   * Retrieve the widget title.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __( 'Video Playlist', 'elementor-post-grid' );
  }

  /**
   * Retrieve the widget icon.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'fa fa-pencil';
  }

  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @since 1.1.0
   *
   * @access public
   *
   * @return array Widget categories.
   */
   public function get_categories() {
 		return ['general', 'test-category'];
 	}

  /**
   * Enqueue styles.
   */
  public function get_style_depends() {
    return array( 'general', 'video-playlist' );
  }

  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function _register_controls() {
    $this->start_controls_section(
      'section_content',
      [
        'label' => __( 'Content', 'menheer-plugin' ),
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => __( 'Title', 'menheer-plugin' ),
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Video playlist', 'menheer-plugin' ),
      ]
    );

    $this->add_control(
      'order_by',
      [
        'label' => __( 'Order by', 'menheer-plugin' ),
        'type' => Controls_Manager::SELECT,
        'default' => __( 'date', 'menheer-plugin' ),
      ]
    );



    $this->add_control(
      'post_count',
      [
        'label' => __( 'Post count', 'menheer-plugin' ),
        'type' => Controls_Manager::NUMBER,
        'default' => __( '3', 'menheer-plugin' ),
      ]
    );

    $this->add_control(
     'show_date',
     [
       'label' => esc_html__('Show Date', 'digiqole'),
       'type' => Controls_Manager::SWITCHER,
       'label_on' => esc_html__('Yes', 'digiqole'),
       'label_off' => esc_html__('No', 'digiqole'),
       'default' => 'yes',
     ]
   );

    $this->add_control(
     'show_cat',
     [
       'label' => esc_html__('Show Category', 'digiqole'),
       'type' => Controls_Manager::SWITCHER,
       'label_on' => esc_html__('Yes', 'digiqole'),
       'label_off' => esc_html__('No', 'digiqole'),
       'default' => 'yes',
     ]
   );
    $this->add_control(
     'show_author',
     [
       'label' => esc_html__('Show author', 'digiqole'),
       'type' => Controls_Manager::SWITCHER,
       'label_on' => esc_html__('Yes', 'digiqole'),
       'label_off' => esc_html__('No', 'digiqole'),
       'default' => 'yes',
     ]
   );


    $this->end_controls_section();
  }

  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.1.0
   *
   * @access protected
   */
  protected function render() {
    $settings = $this->get_settings_for_display();
    $show_cat           = $settings['show_cat'];
    $show_date          = $settings['show_date'];
    $show_author         = $settings['show_author'];

    $this->add_inline_editing_attributes( 'title', 'none' );
    // $this->add_inline_editing_attributes( 'order_by', 'advanced' );
    // $this->add_inline_editing_attributes( 'post_count', 'advanced' );
    ?>
    <h2 class="menheer-block-title" <?php echo $this->get_render_attribute_string( 'title' ); ?>><?php echo $settings['title']; ?></h2>


    <div class="vid-main-wrapper clearfix">

      <!-- THE YOUTUBE PLAYER -->


      <!-- THE PLAYLIST -->
      <div class="vid-list-container" style="background: #fff;padding: 10px;">
          <?php
          $argus = array(
            'post_type' => 'post',
            'posts_per_page' => $settings['post_count'],
            'meta_key'    => 'video_link',
            'ignore_sticky_posts' => 1,
            'terms' => array(
                'post-format-video',
            ),
          );

          $post_query = new \WP_Query($argus);

          if($post_query->have_posts() ) {
            $i = 0;
            while($post_query->have_posts() ) {
              $post_query->the_post();
              ?>

              <?php $i++; ?>
                <?php if ( $i == 1 ) : ?>
                  <div class="vid-container" style="margin-bottom: 5px;margin-right:15px;width:50%;float: left;">
                    <iframe id="vid_frame" src="" frameborder="0" width="auto" height="300"></iframe>
                    <p class="video_link" style="display: none;"><?php the_field("video_link"); ?></p>
                  </div>
                  <ol id="vid-list" style="list-style: none;padding: 0;">
                    <?php $new = str_replace("https://youtu.be/", '',  get_field('video_link')); ?>
                  <li style="background: #efefef;padding:10px;margin-bottom: 10px;">
                    <p><?php the_title() ?></p>
                    <?php echo '<a href="javascript:void(0);" class="video_on_click" style="float: left;">
                      <span class="vid-thumb"><img width=72 src="https://img.youtube.com/vi/'.$new.'/default.jpg" /></span></a>' ?>
                    <h6 class="video_on_click"><?php echo explode('</title>',explode('<title>',file_get_contents("https://www.youtube.com/watch?v=$new"))[1])[0];
 ?></h6>
                    <p class="video_link" style="display: none;"><?php the_field("video_link"); ?></p>
                  </li>
                  <?php else :
                     $new = str_replace("https://youtu.be/", '',  get_field('video_link')); ?>
                   <li style="background: #efefef;padding:10px;margin-bottom: 10px;">
                                        <p><?php the_title() ?></p>

                    <?php echo '<a href="javascript:void(0);" class="video_on_click" style="float: left;">
                      <span class="vid-thumb"><img width=72 src="https://img.youtube.com/vi/'.$new.'/default.jpg" /></span></a>' ?>

                      <h6 class="video_on_click"><?php echo explode('</title>',explode('<title>',file_get_contents("https://www.youtube.com/watch?v=$new"))[1])[0];
 ?></h6>
                    <!--  <h4><?php the_title() ?></h4> -->
                    <p class="video_link" style="display: none;"><?php the_field("video_link"); ?></p>
                  </li>
                <?php endif ?>

              <?php wp_reset_postdata(); ?>
            <?php }}
            wp_reset_postdata();?>
            <?php $i = 0;?>
          </ol>
        </div>
      </div>

    <?php }


    protected function _content_template() {

    }
  }
