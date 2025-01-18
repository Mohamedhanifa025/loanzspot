'use strict';

var Layout = (function() {

    function pinSidenav() {
        $('.sidenav-toggler').addClass('active');
        $('.sidenav-toggler').data('action', 'sidenav-unpin');
        $('body').removeClass('g-sidenav-hidden').addClass('g-sidenav-show g-sidenav-pinned');
        $('body').append('<div class="backdrop d-xl-none" data-action="sidenav-unpin" data-target=' + $('#sidenav-main').data('target') + ' />');

        // Store the sidenav state in a cookie session
        Cookies.set('sidenav-state', 'pinned');
    }

    function unpinSidenav() {
        $('.sidenav-toggler').removeClass('active');
        $('.sidenav-toggler').data('action', 'sidenav-pin');
        $('body').removeClass('g-sidenav-pinned').addClass('g-sidenav-hidden');
        $('body').find('.backdrop').remove();

        // Store the sidenav state in a cookie session
        Cookies.set('sidenav-state', 'unpinned');
    }

    // Set sidenav state from cookie

    var $sidenavState = Cookies.get('sidenav-state') ? Cookies.get('sidenav-state') : 'pinned';

    if ($(window).width() > 1200) {
        if ($sidenavState == 'pinned') {
            pinSidenav()
        }

        if (Cookies.get('sidenav-state') == 'unpinned') {
            unpinSidenav()
        }

        $(window).resize(function() {
            if ($('body').hasClass('g-sidenav-show') && !$('body').hasClass('g-sidenav-pinned')) {
                $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
            }
        })
    }

    if ($(window).width() < 1200) {
        $('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
        $('body').removeClass('g-sidenav-show');
        $(window).resize(function() {
            if ($('body').hasClass('g-sidenav-show') && !$('body').hasClass('g-sidenav-pinned')) {
                $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
            }
        })
    }



    $("body").on("click", "[data-action]", function(e) {

        e.preventDefault();

        var $this = $(this);
        var action = $this.data('action');
        var target = $this.data('target');


        // Manage actions

        switch (action) {
            case 'sidenav-pin':
                pinSidenav();
                break;

            case 'sidenav-unpin':
                unpinSidenav();
                break;

            case 'search-show':
                target = $this.data('target');
                $('body').removeClass('g-navbar-search-show').addClass('g-navbar-search-showing');

                setTimeout(function() {
                    $('body').removeClass('g-navbar-search-showing').addClass('g-navbar-search-show');
                }, 150);

                setTimeout(function() {
                    $('body').addClass('g-navbar-search-shown');
                }, 300)
                break;

            case 'search-close':
                target = $this.data('target');
                $('body').removeClass('g-navbar-search-shown');

                setTimeout(function() {
                    $('body').removeClass('g-navbar-search-show').addClass('g-navbar-search-hiding');
                }, 150);

                setTimeout(function() {
                    $('body').removeClass('g-navbar-search-hiding').addClass('g-navbar-search-hidden');
                }, 300);

                setTimeout(function() {
                    $('body').removeClass('g-navbar-search-hidden');
                }, 500);
                break;
        }
    })


    // Add sidenav modifier classes on mouse events

    $('.sidenav').on('mouseenter', function() {
        if (!$('body').hasClass('g-sidenav-pinned')) {
            $('body').removeClass('g-sidenav-hide').removeClass('g-sidenav-hidden').addClass('g-sidenav-show');
        }
    })

    $('.sidenav').on('mouseleave', function() {
        if (!$('body').hasClass('g-sidenav-pinned')) {
            $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hide');

            setTimeout(function() {
                $('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
            }, 300);
        }
    })


    // Make the body full screen size if it has not enough content inside
    $(window).on('load resize', function() {
        if ($('body').height() < 800) {
            $('body').css('min-height', '100vh');
            $('#footer-main').addClass('footer-auto-bottom')
        }
    })

})();



//
// Icon code copy/paste
//

'use strict';

var CopyIcon = (function() {

    // Variables

    var $element = '.btn-icon-clipboard',
        $btn = $($element);


    // Methods

    function init($this) {
        $this.tooltip().on('mouseleave', function() {
            // Explicitly hide tooltip, since after clicking it remains
            // focused (as it's a button), so tooltip would otherwise
            // remain visible until focus is moved away
            $this.tooltip('hide');
        });

        var clipboard = new ClipboardJS($element);

        clipboard.on('success', function(e) {
            $(e.trigger)
                .attr('title', 'Copied!')
                .tooltip('_fixTitle')
                .tooltip('show')
                .attr('title', 'Copy to clipboard')
                .tooltip('_fixTitle')

            e.clearSelection()
        });
    }


    // Events
    if ($btn.length) {
        init($btn);
    }

})();

//
// Navbar
//

'use strict';

var Navbar = (function() {

    // Variables

    var $nav = $('.navbar-nav, .navbar-nav .nav');
    var $collapse = $('.navbar .collapse');
    var $dropdown = $('.navbar .dropdown');

    // Methods

    function accordion($this) {
        $this.closest($nav).find($collapse).not($this).collapse('hide');
    }

    function closeDropdown($this) {
        var $dropdownMenu = $this.find('.dropdown-menu');

        $dropdownMenu.addClass('close');

        setTimeout(function() {
            $dropdownMenu.removeClass('close');
        }, 200);
    }


    // Events

    $collapse.on({
        'show.bs.collapse': function() {
            accordion($(this));
        }
    })

    $dropdown.on({
        'hide.bs.dropdown': function() {
            closeDropdown($(this));
        }
    })

})();


//
// Navbar collapse
//


var NavbarCollapse = (function() {

    // Variables

    var $nav = $('.navbar-nav'),
        $collapse = $('.navbar .navbar-custom-collapse');


    // Methods

    function hideNavbarCollapse($this) {
        $this.addClass('collapsing-out');
    }

    function hiddenNavbarCollapse($this) {
        $this.removeClass('collapsing-out');
    }


    // Events

    if ($collapse.length) {
        $collapse.on({
            'hide.bs.collapse': function() {
                hideNavbarCollapse($collapse);
            }
        })

        $collapse.on({
            'hidden.bs.collapse': function() {
                hiddenNavbarCollapse($collapse);
            }
        })
    }

    var navbar_menu_visible = 0;

    $(".sidenav-toggler").click(function() {
        if (navbar_menu_visible == 1) {
            $('body').removeClass('nav-open');
            navbar_menu_visible = 0;
            $('.bodyClick').remove();

        } else {

            var div = '<div class="bodyClick"></div>';
            $(div).appendTo('body').click(function() {
                $('body').removeClass('nav-open');
                navbar_menu_visible = 0;
                $('.bodyClick').remove();

            });

            $('body').addClass('nav-open');
            navbar_menu_visible = 1;

        }

    });

})();

//
// Popover
//

'use strict';

var Popover = (function() {

    // Variables

    var $popover = $('[data-toggle="popover"]'),
        $popoverClass = '';


    // Methods

    function init($this) {
        if ($this.data('color')) {
            $popoverClass = 'popover-' + $this.data('color');
        }

        var options = {
            trigger: 'focus',
            template: '<div class="popover ' + $popoverClass + '" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        };

        $this.popover(options);
    }


    // Events

    if ($popover.length) {
        $popover.each(function() {
            init($(this));
        });
    }

})();

//
// Scroll to (anchor links)
//

'use strict';

var ScrollTo = (function() {

    //
    // Variables
    //

    var $scrollTo = $('.scroll-me, [data-scroll-to], .toc-entry a');


    //
    // Methods
    //

    function scrollTo($this) {
        var $el = $this.attr('href');
        var offset = $this.data('scroll-to-offset') ? $this.data('scroll-to-offset') : 0;
        var options = {
            scrollTop: $($el).offset().top - offset
        };

        // Animate scroll to the selected section
        $('html, body').stop(true, true).animate(options, 600);

        event.preventDefault();
    }


    //
    // Events
    //

    if ($scrollTo.length) {
        $scrollTo.on('click', function(event) {
            scrollTo($(this));
        });
    }

})();

//
// Tooltip
//

'use strict';

var Tooltip = (function() {

    // Variables

    var $tooltip = $('[data-toggle="tooltip"]');


    // Methods

    function init() {
        $tooltip.tooltip();
    }


    // Events

    if ($tooltip.length) {
        init();
    }

})();

//
// Form control
//

'use strict';

var FormControl = (function() {

    // Variables

    var $input = $('.form-control');


    // Methods

    function init($this) {
        $this.on('focus blur', function(e) {
            $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus'));
        }).trigger('blur');
    }


    // Events

    if ($input.length) {
        init($input);
    }

})();



//
// Bootstrap Datepicker
//

'use strict';

var Datepicker = (function() {

    // Variables

    var $datepicker = $('.datepicker');


    // Methods

    function init($this) {
        var options = {
            disableTouchKeyboard: true,
            autoclose: false
        };

        $this.datepicker(options);
    }


    // Events

    if ($datepicker.length) {
        $datepicker.each(function() {
            init($(this));
        });
    }

})();

//
// Form control
//

'use strict';

var noUiSlider = (function() {

    // Variables

    // var $sliderContainer = $('.input-slider-container'),
    // 		$slider = $('.input-slider'),
    // 		$sliderId = $slider.attr('id'),
    // 		$sliderMinValue = $slider.data('range-value-min');
    // 		$sliderMaxValue = $slider.data('range-value-max');;


    // // Methods
    //
    // function init($this) {
    // 	$this.on('focus blur', function(e) {
    //       $this.parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    //   }).trigger('blur');
    // }
    //
    //
    // // Events
    //
    // if ($input.length) {
    // 	init($input);
    // }



    if ($(".input-slider-container")[0]) {
        $('.input-slider-container').each(function() {

            var slider = $(this).find('.input-slider');
            var sliderId = slider.attr('id');
            var minValue = slider.data('range-value-min');
            var maxValue = slider.data('range-value-max');

            var sliderValue = $(this).find('.range-slider-value');
            var sliderValueId = sliderValue.attr('id');
            var startValue = sliderValue.data('range-value-low');

            var c = document.getElementById(sliderId),
                d = document.getElementById(sliderValueId);

            noUiSlider.create(c, {
                start: [parseInt(startValue)],
                connect: [true, false],
                //step: 1000,
                range: {
                    'min': [parseInt(minValue)],
                    'max': [parseInt(maxValue)]
                }
            });

            c.noUiSlider.on('update', function(a, b) {
                d.textContent = a[b];
            });
        })
    }

    if ($("#input-slider-range")[0]) {
        var c = document.getElementById("input-slider-range"),
            d = document.getElementById("input-slider-range-value-low"),
            e = document.getElementById("input-slider-range-value-high"),
            f = [d, e];

        noUiSlider.create(c, {
            start: [parseInt(d.getAttribute('data-range-value-low')), parseInt(e.getAttribute('data-range-value-high'))],
            connect: !0,
            range: {
                min: parseInt(c.getAttribute('data-range-value-min')),
                max: parseInt(c.getAttribute('data-range-value-max'))
            }
        }), c.noUiSlider.on("update", function(a, b) {
            f[b].textContent = a[b]
        })
    }

})();

//
// Scrollbar
//

'use strict';

var Scrollbar = (function() {

    // Variables

    var $scrollbar = $('.scrollbar-inner');


    // Methods

    function init() {
        $scrollbar.scrollbar().scrollLock()
    }


    // Events

    if ($scrollbar.length) {
        init();
    }

})();

//Custom Scripts
//Current Page
$(document).ready(function() {
    $("[href]").each(function() {
        if (this.href == window.location.href) {
            $(this).addClass("active");
        }
    });
});

//Data Table
var table = $('.datatable').DataTable({
    "lengthChange": false,
    "sDom": "ltipr",
    "aaSorting": []
});


jsPlumb.ready(function() {
    // connection lines style
    var connectorPaintStyle = {
        lineWidth: 3,
        strokeStyle: "#939393",
        joinstyle: "round"
    };

    var pdef = {
        // disable dragging
        DragOptions: null,
        // the tree container
        Container: "treemain"
    };
    var plumb = jsPlumb.getInstance(pdef);

    // all sizes are in pixels
    var opts = {
        prefix: 'node_',
        // left margin of the root node
        baseLeft: 24,
        // top margin of the root node
        baseTop: 24,
        // node width
        nodeWidth: 100,
        // horizontal margin between nodes
        hSpace: 36,
        // vertical margin between nodes
        vSpace: 10,
        imgPlus: '../../../assets/vendor/tree_expand.png',
        imgMinus: '../../../assets/vendor/tree_collapse.png',
        // queste non sono tutte in pixel
        sourceAnchor: [1, 0.5, 1, 0, 10, 0],
        targetAnchor: "LeftMiddle",
        sourceEndpoint: {
            endpoint: ["Image", {
                url: "../../../assets/vendor/tree_collapse.png"
            }],
            cssClass: "collapser",
            isSource: true,
            connector: ["Flowchart", {
                stub: [40, 60],
                gap: [10, 0],
                cornerRadius: 5,
                alwaysRespectStubs: false
            }],
            connectorStyle: connectorPaintStyle,
            enabled: false,
            maxConnections: -1,
            dragOptions: null
        },
        targetEndpoint: {
            endpoint: "Blank",
            maxConnections: -1,
            dropOptions: null,
            enabled: false,
            isTarget: true
        },
        connectFunc: function(tree, node) {
            var cid = node.data('id');
            console.log('Connecting node ' + cid);
        }
    };
    var tree = jQuery.jsPlumbTree(plumb, opts);
    tree.init();
    window.treemain = tree;
});

function positioningBlockBug() {
    var oldNode = window.treemain.nodeById(2);
    //var newNode = $('#node_2_new');
    var newNode = $('    <div id="node_2" class="window hidden"\n' +
        '         data-id="2"\n' +
        '         data-parent="0"\n' +
        '         data-first-child="6"\n' +
        '         data-next-sibling="3">\n' +
        '        Node 2 NEW\n' +
        '    </div>\n');
    if (oldNode) {
        oldNode.replaceWith(newNode);
        newNode.id = 'node_2';
        newNode.show();
        window.treemain.update();
    }
}
