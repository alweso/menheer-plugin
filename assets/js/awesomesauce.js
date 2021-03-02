jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( WidgetHandlerClass, {
           $element,
       } );
   };

   elementorFrontend.hooks.addAction( 'frontend/element_ready/post-carousel.default', addHandler );

   class WidgetHandlerClass extends elementorModules.frontend.handlers.Base {
       getDefaultSettings() {
           return {
               selectors: {
                   firstSelector: '.owl-carousel',
                   secondSelector: '.post-slider',
               },
           };
       }

       getDefaultElements() {
           const selectors = this.getSettings( 'selectors' );
           return {
               $firstSelector: this.$element.find( selectors.firstSelector ),
               $secondSelector: this.$element.find( selectors.secondSelector ),
           };
       }

       bindEvents() {
           // this.elements.$firstSelector.owlCarousel();
           this.elements.$firstSelector.on('load', this.blabla());
       }

       blabla() {
         const controls = JSON.parse(this.elements.$secondSelector.attr('data-controls'));
         const autoslide = Boolean(controls.auto_nav_slide?true:false);
         const nav_show = Boolean(controls.nav_show?true:false);
         const dot_nav_show = Boolean(controls.dot_nav_show?true:false);
         const item_count = parseInt( controls.item_count );

         if (this.elements.$secondSelector.length > 0) {
                        this.elements.$secondSelector.owlCarousel({
                           items: item_count,
                           center: false,
                           loop: true,
                           autoplay: autoslide,
                           nav: false,
                           dots: dot_nav_show,
                           autoplayTimeout: 8000,
                           autoplayHoverPause: false,
                           mouseDrag: true,
                           smartSpeed: 1100,
                           margin:30,
                           navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
                           responsive: {
                              0: {
                                 items: 1,
                              },
                              600: {
                                 items: 2,
                              },
                              1000: {
                                 items: 3,
                              },
                              1200: {
                                 items:item_count,
                              }
                           }

                        });
                  }
       }
   }
} );




// jQuery( window ).on( 'elementor/frontend/init', () => {
//    const addHandler = ( $element ) => {
//        elementorFrontend.elementsHandler.addHandler( WidgetHandlerClass, {
//            $element,
//        } );
//    };
//
//    elementorFrontend.hooks.addAction( 'frontend/element_ready/post-carousel.default', addHandler );
// } );
