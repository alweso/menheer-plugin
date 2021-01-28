<?php
namespace ElementorAwesomesauce\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* @since 1.1.0
*/
class PostBlock extends Widget_Base {

  public function __construct( $data = array(), $args = null ) {
    parent::__construct( $data, $args );
    wp_register_style( 'general', plugins_url( '/assets/css/general.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
    wp_register_style( 'post-block', plugins_url( '/assets/css/post-block.css', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
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
    return 'post-block';
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
    return __( 'Post Block', 'elementor-post-block' );
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
    return array( 'general', 'post-block' );
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
        'label' => __( 'General settings', 'menheer-plugin' ),
      ]
    );

    $this->add_control(
      'block_style',
      [
        'label' => __( 'Choose block style', 'menheer-plugin' ),
        'type' => Controls_Manager::SELECT,
        'default' => __( 'style-1', 'menheer-plugin' ),
        'options' => [
          'style-1'  => __( 'Style 1', 'menheer-plugin' ),
          'style-2' => __( 'Style 2', 'menheer-plugin' ),
          'style-3' => __( 'Style 3', 'menheer-plugin' ),
          'style-4' => __( 'Style 4', 'menheer-plugin' ),
          'style-5' => __( 'Style 5', 'menheer-plugin' ),
          'style-6' => __( 'Style 6', 'menheer-plugin' ),
        ],
      ]
    );

    $this->add_control(
      'show_title',
      [
        'label' => esc_html__('Show block title', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => __( 'Title', 'menheer-plugin' ),
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Post block', 'menheer-plugin' ),
      ]
    );

    $this->add_control(
      'order',
      [
        'label' => __( 'Order ASC/DESC', 'menheer-plugin' ),
        'type' => Controls_Manager::SELECT,
        'default' => __( 'DESC', 'menheer-plugin' ),
        'options' => [
          'DESC'  => __( 'Descending', 'menheer-plugin' ),
          'ASC' => __( 'Ascending', 'menheer-plugin' ),
        ],
      ]
    );

    $this->add_control(
      'order_by',
      [
        'label' => __( 'Show', 'menheer-plugin' ),
        'type' => Controls_Manager::SELECT,
        'default' => __( 'date', 'menheer-plugin' ),
        'options' => [
          'date'  => __( 'Latest posts', 'menheer-plugin' ),
          'comment_count'  => __( 'Most commented', 'menheer-plugin' ),
          'meta_value_num'  => __( 'Most read', 'menheer-plugin' ),
        ],
      ]
    );

    $this->add_control(
      'post_pick_by',
      [
        'label'     => esc_html__( 'Post pick by', 'menheer-plugin' ),
        'type'      => Controls_Manager::SELECT,
        'default'   => '',
        'options'   => [
          'all'      =>esc_html__( 'All', 'menheer-plugin' ),
          'category'      =>esc_html__( 'Category', 'menheer-plugin' ),
          'tags'      =>esc_html__( 'Tags', 'menheer-plugin' ),
          'stickypost'    =>esc_html__( 'Sticky posts', 'menheer-plugin' ),
          'post'    =>esc_html__( 'Post id', 'menheer-plugin' ),
          'author'    =>esc_html__( 'Author', 'menheer-plugin' ),
        ],
      ]
    );

    $this->add_control(
      'post_categories',
      [
        'label' => __( 'Choose categories', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'default' => '',
        'options' => $this->post_category(),
        'label_block' => true,
        'multiple' => true,
        'condition' => [ 'post_pick_by' => ['category'] ]
      ]
    );

    $this->add_control(
      'post_tags',
      [
        'label' => esc_html__('Select tags', 'menheer-plugin'),
        'type' => Controls_Manager::SELECT2,
        'options' => $this->menheer_plugin_post_tags(),
        'label_block' => true,
        'multiple' => true,
        'condition' => [ 'post_pick_by' => ['tags'] ]
      ]
    );

    $this->add_control(
      'author_id',
      [
        'label' => esc_html__( 'Author id', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__( '1,2,3', 'menheer-plugin' ),
        'condition' => [ 'post_pick_by' => ['author'] ]
      ]
    );
    $this->add_control(
      'post_id',
      [
        'label' => esc_html__( 'Post id', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__( '1,2,3', 'menheer-plugin' ),
        'condition' => [ 'post_pick_by' => ['post'] ]
      ]
    );

    $this->add_control(
      'post_count',
      [
        'label' => __( 'Post count', 'menheer-plugin' ),
        'type' => Controls_Manager::NUMBER,
        'default' => __( 5, 'menheer-plugin' ),
        'min' => 5,
        'max' => 13,
        'step' => 1,
        'condition' => [ 'block_style' => ['style-1', 'style-5', 'style-6'] ]
      ]
    );

    $this->add_control(
      'post_count_2',
      [
        'label' => __( 'Post count', 'menheer-plugin' ),
        'type' => Controls_Manager::NUMBER,
        'default' => __( 6, 'menheer-plugin' ),
        'condition' => [ 'block_style' => ['style-4'] ]
      ]
    );

    $this->add_control(
      'post_count_3',
      [
        'label' => __( 'Post count', 'menheer-plugin' ),
        'type' => Controls_Manager::NUMBER,
        'default' => __( 5, 'menheer-plugin' ),
        'min' => 2,
        'max' => 5,
        'step' => 1,
        'condition' => [ 'block_style' => ['style-2', 'style-3'] ]
      ]
    );


    $this->add_control(
      'skip_post',
      [
        'label' => esc_html__('Post skip', 'digiqole'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'digiqole'),
        'label_off' => esc_html__('No', 'digiqole'),
        'default' => 'no',

      ]
    );

    $this->add_control(
      'skip_post_num',
      [
        'label'         => esc_html__( 'Skip post count', 'digiqole' ),
        'type'          => Controls_Manager::NUMBER,
        'default'       => '1',
        'condition' => [ 'skip_post' => 'yes' ]

      ]
    );


    $this->end_controls_section();

    $this->start_controls_section(
      'big_item_features',
      [
        'label' => __( 'Big item features', 'menheer-plugin' ),
      ]
    );

    $this->add_control(
      'post_title_crop',
      [
        'label'         => esc_html__( 'Post Title limit (words)', 'menheer-plugin' ),
        'type'          => Controls_Manager::NUMBER,
        'default' => '35',

      ]
    );


    $this->add_control(
      'show_exerpt',
      [
        'label' => esc_html__('Show excerpt', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'no',
        'condition' => [ 'block_style' => ['style-1', 'style-2', 'style-2', 'style-4', 'style-5'] ]
      ]
    );

    $this->add_control(
      'show_exerpt_2',
      [
        'label' => esc_html__('Show excerpt 2', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
        'condition' => [ 'block_style' => ['style-6'] ]
      ]
    );

    $this->add_control(
      'post_content_crop',
      [
        'label'         => esc_html__( 'Post Exerpt limit', 'menheer-plugin' ),
        'type'          => Controls_Manager::NUMBER,
        'default' => '30',
        'condition' => [
          'block_style' => ['style-1', 'style-2', 'style-2', 'style-4', 'style-5'],
          'show_exerpt' => ['yes']
        ]
      ]
    );

    $this->add_control(
      'post_content_crop_2',
      [
        'label'         => esc_html__( 'Post Exerpt limit', 'menheer-plugin' ),
        'type'          => Controls_Manager::NUMBER,
        'default' => '30',
        'condition' => [ 'block_style' => ['style-6'],
        'show_exerpt_2' => ['yes'] ]
      ]
    );

    $this->add_control(
      'show_date',
      [
        'label' => esc_html__('Show Date', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'show_cat',
      [
        'label' => esc_html__('Show Category', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );
    $this->add_control(
      'show_tags',
      [
        'label' => esc_html__('Show tags', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'no',
      ]
    );
    $this->add_control(
      'show_author',
      [
        'label' => esc_html__('Show author', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'no',
      ]
    );
    $this->add_control(
      'show_views',
      [
        'label' => esc_html__('Show views', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );
    $this->add_control(
      'show_comments',
      [
        'label' => esc_html__('Show comments', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'small_item_features',
      [
        'label' => __( 'Small item features', 'menheer-plugin' ),
      ]
    );


    $this->add_control(
      'post_title_crop_small',
      [
        'label'         => esc_html__( 'Post Title limit (words) s', 'menheer-plugin' ),
        'type'          => Controls_Manager::NUMBER,
        'default' => '35',

      ]
    );

    $this->add_control(
      'show_exerpt_small',
      [
        'label' => esc_html__('Show excerpt s', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'no',
      ]
    );

    $this->add_control(
      'post_content_crop_small',
      [
        'label'         => esc_html__( 'Post Exerpt limit s', 'menheer-plugin' ),
        'type'          => Controls_Manager::NUMBER,
        'default' => '30',
        'condition' => [ 'show_exerpt_small' => ['yes'] ]
      ]
    );

    $this->add_control(
      'show_date_small',
      [
        'label' => esc_html__('Show Date s', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'show_cat_small',
      [
        'label' => esc_html__('Show Category s', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );
    $this->add_control(
      'show_tags_small',
      [
        'label' => esc_html__('Show tags s', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'no',
      ]
    );
    $this->add_control(
      'show_author_small',
      [
        'label' => esc_html__('Show author s', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'no',
      ]
    );
    $this->add_control(
      'show_views_small',
      [
        'label' => esc_html__('Show views s', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );
    $this->add_control(
      'show_comments_small',
      [
        'label' => esc_html__('Show comments s', 'menheer-plugin'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'menheer-plugin'),
        'label_off' => esc_html__('No', 'menheer-plugin'),
        'default' => 'yes',
      ]
    );

    $this->end_controls_section();


    $this->start_controls_section(
      'general_style_settings',
      [
        'label' => __( 'General settings', 'menheer-plugin' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'big_thumbnail_border',
      [
        'label' => __( 'Thumbnail border', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::HEADING,
      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'big_thumb_border',
        'fields_options' => [
          'border' => ['default' => 'none'],
          'width' => [
            'default' => [
              'top' => 6,
              'right' => 6,
              'bottom' => 6,
              'left' => 6,
              'unit'=> 'px',
              'isLinked' => true,
            ],
          ],
          'color' => ['default' => '#FFFFFF'],
        ],
        'selector' => '{{WRAPPER}} .awesomesauce-post-block .wrapper .thumbnail',
      ]
    );

    $this->add_control(
      'item_border',
      [
        'label' => __( 'Item border', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before'
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'big_itemborder',
        'fields_options' => [
          'width' => [
            'default' => [
              'top' => 1,
              'right' => 1,
              'bottom' => 1,
              'left' => 1,
              'unit'=> 'px',
              'isLinked' => true,
            ],
          ],
          'color' => ['default' => '#000'],
        ],
        'selector' => '{{WRAPPER}} .awesomesauce-post-block .wrapper',
      ]
    );

    $this->add_control(
      'columns_rows',
      [
        'label' => __( 'Columns and rows', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before'
      ]
    );


    $this->add_responsive_control(
      'big_grid_item_column_gap',
      [
        'label' =>esc_html__( 'Grid item column gap (css grid)', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 15,
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .big-wrapper' => 'column-gap: {{VALUE}}px;',
        ],
      ]
    );

    $this->add_responsive_control(
      'big_grid_item_row_gap',
      [
        'label' =>esc_html__( 'Grid item row gap (css grid)', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 15,
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .big-wrapper' => 'row-gap: {{VALUE}}px;',
        ],
      ]
    );


    $this->add_control(
      'column_width',
      [
        'label' => __( 'Column width', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'fr'],
        'range' => [
          'fr' => [
            'min' => 4,
            'max' => 10,
            'step' => 1,
          ],
        ],
        'default' => [
          'unit' => 'fr',
          'size' => 5,
        ],
        'selectors' => [
          '{{WRAPPER}} .big-wrapper--style-a' => 'grid-template-columns: {{SIZE}}{{UNIT}} 4fr;',
        ],
        'condition' => [ 'block_style' => ['style-1'] ],
      ]
    );

    $this->add_control(
      'background',
      [
        'label' => __( 'Background', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before'
      ]
    );


    $this->add_control(
      'grid_item_color',
      [
        'label' => __( 'Grid item background color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => 'rgba(255,255,255,0)',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper' => 'background-color: {{VALUE}}',
        ],
      ]
    );




    $this->end_controls_section();

    $this->start_controls_section(
      'big_items_section',
      [
        'label' => __( 'Big item features', 'menheer-plugin' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );


    $this->add_control(
      'big_typo_section',
      [
        'label' => __( 'Typography', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => __( 'Title typography', '' ),
        'name' => 'big_title_typography',
        'selector' => '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .news-title',
      ]
    );

    $this->add_control(
      'big_title_color_1',
      [
        'label' => __( 'Title color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .news-title' => 'color: {{VALUE}}',
        ],
        'condition' => [ 'block_style' => ['style-1', 'style-2', 'style-3'] ]
      ]
    );


    $this->add_control(
      'big_title_color_2',
      [
        'label' => __( 'Title Color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .news-title' => 'color: {{VALUE}}',
        ],
        'condition' => [ 'block_style' => ['style-4', 'style-5', 'style-6'] ]
      ]
    );



    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => __( 'Description typography', '' ),
        'name' => 'big_desc_typography',
        'selector' => '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .description',
      ]
    );


    $this->add_control(
      'big_description_color_1',
      [
        'label' => __( 'Big Description color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .description-inner p' => 'color: {{VALUE}}',
        ],
        'condition' => [ 'block_style' => ['style-1', 'style-2', 'style-3'] ]
      ]
    );

    $this->add_control(
      'big_description_color_2',
      [
        'label' => __( 'Description color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .description-inner p' => 'color: {{VALUE}}',
        ],
        'condition' => [ 'block_style' => ['style-4', 'style-5', 'style-6'] ]
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => __( 'Big details typography', '' ),
        'name' => 'big_details_typography',
        'selector' => '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .description-inner .comments-views-date span',
      ]
    );

    $this->add_control(
      'big_details_color_1',
      [
        'label' => __( 'Big details color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#c9c9c9',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .description-inner .comments-views-date span' => 'color: {{VALUE}}',
        ],
        'condition' => [ 'block_style' => ['style-1', 'style-2', 'style-3'] ]
      ]
    );

    $this->add_control(
      'big_details_color_2',
      [
        'label' => __( 'details color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#989898',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .description-inner .comments-views-date span' => 'color: {{VALUE}}',
        ],
        'condition' => [ 'block_style' => ['style-4', 'style-5', 'style-6'] ]
      ]
    );

    $this->add_control(
      'paddings',
      [
        'label' => __( 'Paddings', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );


    $this->add_responsive_control(
      'big_grid_item_padding',
      [
        'label' =>esc_html__( 'Big Grid item padding', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px'],
        'placeholder' => '0',
        'default' => [
          'top' => '15',
          'right' => '15',
          'bottom' => '15',
          'left' => '15',
          'unit' => 'px',
          'isLinked' => true,
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .description-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [ 'block_style' => ['style-1', 'style-2', 'style-3'] ],
      ]
    );


    $this->add_control(
      'big_margins_section',
      [
        'label' => __( 'Margins', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );



    $this->add_responsive_control(
      'big_thumbnail_margin_bottom',
      [
        'label' => __( 'Big thumbnail margin bottom', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
        'desktop_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [ 'block_style' => ['style-4', 'style-5'] ],
      ]
    );



    $this->add_responsive_control(
      'big_category_margin_bottom',
      [
        'label' => __( 'Big category margin bottom', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
        'desktop_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'big_title_margin_bottom',
      [
        'label' => __( 'Big title margin bottom', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
        'desktop_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .news-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'big_excerpt_margin_bottom',
      [
        'label' => __( 'Big excerpt margin bottom', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
        'desktop_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big .description p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );



    $this->end_controls_section();

    $this->start_controls_section(
      'small_items_section',
      [
        'label' => __( 'Small item features', 'menheer-plugin' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );


    $this->add_control(
      'small_typo_section',
      [
        'label' => __( 'Small item typography', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => __( 'Small item title typography', '' ),
        'name' => 'small_title_typography',
        'selector' => '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .news-title',
      ]
    );


    $this->add_control(
      'small_title_color',
      [
        'label' => __( 'Small item title Color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'selectors' => [
          '{{WRAPPER}}  .awesomesauce-post-block .wrapper--small .news-title' => 'color: {{VALUE}}',
        ],
      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => __( 'Small description typography', '' ),
        'name' => 'small_desc_typography',
        'selector' => '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .description',
      ]
    );

    $this->add_control(
      'small_description_color',
      [
        'label' => __( 'Description color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--big p' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'label' => __( 'Small details typography', '' ),
        'name' => 'small_details_typography',
        'selector' => '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .description-inner .comments-views-date span',
      ]
    );

    $this->add_control(
      'small_details_color',
      [
        'label' => __( 'Details color', '' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#989898',
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .description-inner .comments-views-date span' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'small_paddings',
      [
        'label' => __( 'Paddings', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'grid_item_padding',
      [
        'label' =>esc_html__( 'Small Grid item padding', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px'],
        'placeholder' => '0',
        'default' => [
          'top' => '0',
          'right' => '0',
          'bottom' => '0',
          'left' => '0',
          'unit' => 'px',
          'isLinked' => 'false',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .description-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'small_margins_section',
      [
        'label' => __( 'Margins', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
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
          'size' => 10,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [ 'block_style' => ['style-2', 'style-3', 'style-4', 'style-6'] ],
      ]
    );


    $this->add_responsive_control(
      'small_category_margin_bottom',
      [
        'label' => __( 'Small category margin bottom', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
        'desktop_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 10,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'small_title_margin_bottom',
      [
        'label' => __( 'Small title margin bottom', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
        'desktop_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .news-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'small_excerpt_margin_bottom',
      [
        'label' => __( 'Small excerpt margin bottom', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'devices' => [ 'desktop', 'tablet', 'mobile' ],
        'desktop_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'tablet_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'mobile_default' => [
          'size' => 5,
          'unit' => 'px',
        ],
        'selectors' => [
          '{{WRAPPER}} .awesomesauce-post-block .wrapper--small .description p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'small_thumbnail_width_section',
      [
        'label' => __( 'Thumbnail width', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => [ 'block_style' => ['style-1', 'style-5'] ]
      ]
    );


    $this->add_control(
      'thumbnail_width',
      [
        'label' => __( 'Small thumbnail width', 'menheer-plugin' ),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => [ 'px'],
        'range' => [
          'px' => [
            'min' => 120,
            'max' => 230,
            'step' => 1,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 145,
        ],
        'selectors' => [
          '{{WRAPPER}} .wrapper--small .thumbnail' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [ 'block_style' => ['style-1', 'style-5'] ]
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
    $block_style = $settings['block_style'];
    $show_title         = $settings['show_title'];

    /* Big item*/
    $show_cat           = $settings['show_cat'];
    $show_date          = $settings['show_date'];
    $show_author         = $settings['show_author'];
    $show_views         = $settings['show_views'];
    $show_comments         = $settings['show_comments'];
    $show_tags        = $settings['show_tags'];
    $post_count      = $settings['post_count'];
    $post_count_2      = $settings['post_count_2'];
    $post_count_3      = $settings['post_count_3'];
    $show_exerpt = $settings['show_exerpt'];
    $show_exerpt_2 = $settings['show_exerpt_2'];
    $crop	= (isset($settings['post_title_crop'])) ? $settings['post_title_crop'] : 20;
    $post_content_crop	= (isset($settings['post_content_crop'])) ? $settings['post_content_crop'] : 50;

    /* Small item*/
    $show_cat_small           = $settings['show_cat_small'];
    $show_date_small          = $settings['show_date_small'];
    $show_author_small         = $settings['show_author_small'];
    $show_views_small         = $settings['show_views_small'];
    $show_comments_small         = $settings['show_comments_small'];
    $show_tags_small        = $settings['show_tags_small'];
    $show_exerpt_small = $settings['show_exerpt_small'];
    $crop_small	= (isset($settings['post_title_crop_small'])) ? $settings['post_title_crop_small'] : 20;
    $post_content_crop_small	= (isset($settings['post_content_crop_small'])) ? $settings['post_content_crop_small'] : 50;



    $this->add_inline_editing_attributes( 'title', 'none' );
    ?>
    <?php
    $arg = [
      'post_type'   =>  'post',
      'post_status' => 'publish',
      'orderby' => $settings['order_by'],
      'posts_per_page' => $settings['post_count'],
      'order' => $settings['order'],
    ];

    if($settings['post_pick_by']=='stickypost'){
      $arg['post__in'] = get_option( 'sticky_posts' );
      $arg['ignore_sticky_posts'] = 1;
    } else {
      $arg['ignore_sticky_posts'] = 1;
    }

    if($settings['order_by']== 'meta_value_num'){
      $arg['meta_key'] ='post_views_count';
    }

    if($settings['block_style']=='style-4') {
      $arg['posts_per_page'] = $settings['post_count_2'];
    }

    if($settings['block_style']=='style-2' || $settings['block_style']=='style-3') {
      $arg['posts_per_page'] = $settings['post_count_3'];
    }

    if($settings['block_style']=='style-1' || $settings['block_style']=='style-5' || $settings['block_style']=='style-6') {
      $arg['posts_per_page'] = $settings['post_count'];
    }

    if($settings['post_pick_by']=='category') {
      $arg['category__in'] = $settings['post_categories'];
    }

    if($settings['post_pick_by']=='tags') {
      $arg['tag__in'] = $settings['post_tags'];
    }

    if($settings['post_pick_by']=='post') {
      $menheer_plugin_posts = explode(',',$settings['post_id']);
      $arg['post__in'] = $menheer-plugin_posts;
      $arg['posts_per_page'] = count($menheer-plugin_posts);
    }

    if($settings['post_pick_by']=='author') {
      $menheer_plugin_authors = explode(',',$settings['author_id']);
      $arg['author__in'] = $menheer-plugin_authors;
    }

    if($settings['skip_post']=='yes'){
      $arg['offset'] = $settings['skip_post_num'];
    }

    $queryd = new \WP_Query( $arg );
    if ( $queryd->have_posts() ) : ?>
    <div class="awesomesauce-post-block <?php echo $block_style ?>">
      <?php if($settings['block_style']=="style-1"): ?>
        <?php  require 'block_styles/style-a.php'; ?>
      <?php endif; ?>
      <?php if($settings['block_style']=="style-2") : ?>
        <?php  require 'block_styles/style-a.php'; ?>
      <?php endif; ?>
      <?php if($settings['block_style']=="style-3") : ?>
        <?php  require 'block_styles/style-a.php'; ?>
      <?php endif; ?>
      <?php if($settings['block_style']=="style-4") : ?>
        <?php  require 'block_styles/style-d.php'; ?>
      <?php endif; ?>
      <?php if($settings['block_style']=="style-5") : ?>
        <?php  require 'block_styles/style-e.php'; ?>
      <?php endif; ?>
      <?php if($settings['block_style']=="style-6") : ?>
        <?php  require 'block_styles/style-f.php'; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  <?php endif; ?>
<?php }

protected function _content_template() {

}

public function post_category() {

  $terms = get_terms( array(
    'taxonomy'    => 'category',
    'hide_empty'  => false,
    'posts_per_page' => -1,
    'suppress_filters' => false,
  ) );

  $cat_list = [];
  foreach($terms as $post) {
    $cat_list[$post->term_id]  = [$post->name];
  }
  return $cat_list;
}

function menheer_plugin_post_tags(){
  $terms = get_terms( array(
    'taxonomy'    => 'post_tag',
    'hide_empty'  => false,
    'posts_per_page' => -1,
  ) );

  $cat_list = [];
  foreach($terms as $post) {
    $cat_list[$post->term_id]  = [$post->name];
  }
  return $cat_list;
}

function menheer_plugin_post_authors(){
  $terms = wp_list_authors( array(
    'show_fullname' => 1,
    'optioncount'   => 1,
    'html'          => false,
    'orderby'       => 'post_count',
    'order'         => 'DESC',
  ) );

  $cat_list = [];
  foreach($terms as $post) {
    $cat_list[$post->term_id]  = [$post->name];
  }
  return $cat_list;
}

}
