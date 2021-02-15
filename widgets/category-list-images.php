<?php
namespace ElementorAwesomesauce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* @since 1.1.0
*/
class CategoryListImages extends Widget_Base {

  public function __construct( $data = array(), $args = null ) {
    parent::__construct( $data, $args );
    wp_register_style( 'general', plugins_url( '/assets/css/general.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
    wp_register_style( 'category-list-images', plugins_url( '/assets/css/category-list-images.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
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
  return 'category-list-images';
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
  return __( 'Category List Images', 'elementor-category-list-images' );
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
  return array( 'general', 'category-list-images' );
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
      'default' => __( 'Categories', 'menheer-plugin' ),
    ]
  );

    $this->add_control(
      'grid_item_color',
      [
        'label' => __( 'Item background color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        // 'scheme' => [
        //   'type' => \Elementor\Scheme_Color::get_type(),
        //   'value' => \Elementor\Scheme_Color::COLOR_1,
        // ],
        'default' => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .category-image' => 'background-color: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'thumbnail_margin_bottom',
      [
        'label' => __( 'Thumbnail margin bottom', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
        'desktop_default' => [
          'size' => 30,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 20,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .category-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
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

  ?>
  <h2 class="menheer-block-title"><?php echo $settings['title']; ?></h2>

  <div class=="categories-with-image" style="display:grid;grid-template-columns:1fr 1fr; column-gap: 15px;">
     <?php
        $categories = get_categories();
        foreach ($categories as $cat) {
          if ($cat->category_count > 0) {
            echo '<div class="category-image"><div class="category-posts-number" style="background-color:'.get_field('category_colors', $cat).'"><span>'.$cat->category_count.'</span></div><a href="'.get_category_link( $cat->cat_ID ).'" class="category-image-inner" style="background-image:url('.get_field('category_picture', $cat)['url'].');"><span>'.$cat->name.'</span><div class="category-opacity-color"></div></a></div>';
          }
          }

      ?>
</div>
  <?php }

  protected function _content_template() {

  }
}
