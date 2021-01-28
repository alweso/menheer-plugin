<?php

namespace ElementorAwesomesauce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;


class Comments extends Widget_Base {

  public function __construct( $data = array(), $args = null ) {
    parent::__construct( $data, $args );
    wp_register_style( 'general', plugins_url( '/assets/css/general.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
    wp_register_style( 'comments', plugins_url( '/assets/css/comments.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
  }


  public function get_name() {
    return 'comments';
  }

  public function get_title() {
    return esc_html__( 'Comments', 'elementor-comments' );
  }

  public function get_icon() {
    return 'fa fa-pencil';
  }

  public function get_categories() {
    return ['general', 'test-category'];
  }


    /**
     * Enqueue styles.
     */
    public function get_style_depends() {
      return array( 'general', 'comments' );
    }


  protected function _register_controls() {

    $this->start_controls_section(
      'section_tab',
      [
        'label' => esc_html__('Comment settings', 'menheer-plugin'),
      ]
    );

    $this->add_control(
      'comment_count',
      [
        'label'         => esc_html__( 'Comment count', 'digiqole' ),
        'type'          => Controls_Manager::NUMBER,
        'default'       => '4',

      ]
    );

    $this->add_control(
      'commnet_limit',
      [
        'label'         => esc_html__( 'Comment crop', 'digiqole' ),
        'type'          => Controls_Manager::NUMBER,
        'default'       => '15',

      ]
    );

    $this->add_control(
      'comment_order',
      [
        'label'     =>esc_html__( 'Comment order', 'digiqole' ),
        'type'      => Controls_Manager::SELECT,
        'default'   => 'DESC',
        'options'   => [
          'DESC'      =>esc_html__( 'Descending', 'digiqole' ),
          'ASC'       =>esc_html__( 'Ascending', 'digiqole' ),
        ],
      ]
    );

    $this->end_controls_section();




  } //Register control end

  protected function render( ) {

    $settings = $this->get_settings();
    $comment_count    = $settings['comment_count'];
    $comment_order    = $settings['comment_order'];
    $commnet_limit    = $settings['commnet_limit'];

    $args = array(
      'orderby' => 'comment_ID',
      'order'  => $comment_order,
      'number' => $comment_count,
      'suppress_filters' => false,

    );

    $comments_query = new \WP_Comment_Query;
    $comments = $comments_query->query( $args );
    ?>
    <?php if ( $comments ):  ?>
      <div class="comment-box">
        <?php foreach ( $comments as $comment ) : ?>
          <div class="comment-box_single">
            <div class="comment-box_author-info">
              <div class="comment-box_author-thumb">
                <?php echo get_avatar(get_the_author_meta('ID')); ?>
              </div>
            </div>
            <div class="comment-box_comment-content">
              <a href="<?php echo esc_url(get_post_permalink($comment->comment_post_ID)); ?> ">
              <div class="comment-box_comment">
                  <?php echo esc_html(wp_trim_words($comment->comment_content,$commnet_limit,'') ); ?>
                  <div class="comment-box_name-and-date">
                    <div class="comment-box_author-name">
                        <?php echo esc_html($comment->comment_author); ?>
                    </div>
                    <div class="comment-box_date">
                      <?php echo get_the_date( 'd\.m\.Y', get_option($comment->comment_date)); ?>
                    </div>
                  </div>
              </div>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div><!-- author comments end -->
    <?php endif; ?>

    <?php

  }

  protected function _content_template() { }
}
