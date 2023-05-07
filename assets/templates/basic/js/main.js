'user strict';

// Preloader
$(window).on('load', function () {
    $('#preloader').fadeOut(1);
});

//Menu Dropdown
$("ul>li>.sub-menu").parent("li").addClass("has-sub-menu");

$('.menu li a').on('click', function () {
  var element = $(this).parent('li');
  if (element.hasClass('open')) {
    element.removeClass('open');
    element.find('li').removeClass('open');
    element.find('ul').slideUp(300, "swing");
  } else {
    element.addClass('open');
    element.children('ul').slideDown(300, "swing");
    element.siblings('li').children('ul').slideUp(300, "swing");
    element.siblings('li').removeClass('open');
    element.siblings('li').find('li').removeClass('open');
    element.siblings('li').find('ul').slideUp(300, "swing");
  }
});

// Responsive Menu
var headerTrigger = $('.header-trigger');
headerTrigger.on('click', function(){
    $('.menu, .header-trigger').toggleClass('active')
    $('.overlay').toggleClass('overlay-color')
    $('.overlay').removeClass('active')
});

var headerTrigger2 = $('.top-bar-trigger');
headerTrigger2.on('click', function(){
    $('.header-top').toggleClass('active')
    $('.overlay').toggleClass('overlay-color')
    $('.overlay').removeClass('active')
});

var over = $('.overlay');
over.on('click', function() {
  $('.overlay').removeClass('overlay-color')
  $('.overlay').removeClass('active')
  $('.menu, .header-trigger').removeClass('active')
  $('.header-top').removeClass('active')
  $('.cart-sidebar').removeClass('active')
  $('.dashboard-sidebar').removeClass('active')
})


// Sticky Menu
window.addEventListener('scroll', function(){
  var header = document.querySelector('header');
  header.classList.toggle('sticky', window.scrollY > 0);

});
var prevScrollpos = window.pageYOffset;
var scrollPosition = window.scrollY;
if (scrollPosition >= 1) {
  $(".header").addClass('active');
}
window.onscroll = function () {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    $(".header-atop").addClass('active');
    $(".header-atop").removeClass('inActive');
  } else {
    $(".header-atop").removeClass('active');
    $(".headera-top").addClass('inActive');
  }
  prevScrollpos = currentScrollPos;
  if (currentScrollPos === 0) {
    $(".headera-top").removeClass('active');
  }
};


// Scroll To Top 
var scrollTop = $(".scrollToTop");
$(window).on('scroll', function () {
  if ($(this).scrollTop() < 500) {
    scrollTop.removeClass("active");
  } else {
    scrollTop.addClass("active");
  }
});

//Click event to scroll to top
$('.scrollToTop').on('click', function () {
  $('html, body').animate({
    scrollTop: 0
  }, 300);
  return false;
});

// pagination
$('.pagination .page-item').on('click', function() {
  $('.pagination .page-item').removeClass('active')
  $(this).addClass('active')
})

// Odometer Counter
$(".counter-item").each(function () {
  $(this).isInViewport(function (status) {
    if (status === "entered") {
      for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
        var el = document.querySelectorAll('.odometer')[i];
        el.innerHTML = el.getAttribute("data-odometer-final");
      }
    }
  });
});

//Faq
$('.faq-wrapper .faq-title, .faq-wrapper-two .faq-title-two').on('click', function (e) {
  var element = $(this).parent('.faq-item, .faq-item-two');
  if (element.hasClass('open')) {
    element.removeClass('open');
    element.find('.faq-content, .faq-content-two').removeClass('open');
    element.find('.faq-content, .faq-content-two').slideUp(300, "swing");
  } else {
    element.addClass('open');
    element.children('.faq-content, .faq-content-two').slideDown(300, "swing");
    element.siblings('.faq-item, .faq-item-two').children('.faq-content, .faq-content-two').slideUp(300, "swing");
    element.siblings('.faq-item, .faq-item-two').removeClass('open');
    element.siblings('.faq-item, .faq-item-two').find('.faq-title, .faq-title-two').removeClass('open');
    element.siblings('.faq-item, .faq-item-two').find('.faq-content, .faq-content-two').slideUp(300, "swing");
  }
});

if ($('.testimonial-slider').length) {
  $('.testimonial-slider').owlCarousel({
    // center: true,
    items: 1,
    autoplay: true,
    smartSpeed: 600,
    autoplayTimeout: 5000,
    loop: true,
    singleItem: true,
    nav: false,
    dots: false,
    thumbs: true,
    thumbsPrerendered: true,
    // animateIn: 'fadeIn',
    // animateOut: 'fadeUp'
  });
}

$('.image').magnificPopup({type:'image'});


// Product Slider
$('.product-slider').owlCarousel({
  // center: true,
  items: 4,
  autoplay: true,
  smartSpeed: 600,
  autoplayTimeout: 3000,
  loop: true,
  singleItem: true,
  nav: false,
  dots: false,
  thumbs: true,
  thumbsPrerendered: true,
  margin: 24,
  // animateIn: 'fadeIn',
  // animateOut: 'fadeUp'
  responsive : {
    0 : {
      items: 1,
    },
    450 : {
      items: 2,
    },
    768 : {
      items: 3,
    },
    992 : {
      items: 3,
    },
    1400 : {
      items: 4,
    }
}
});

// Product Details Thumb
var sync1 = $(".sync1");
var sync2 = $(".sync2");
var thumbnailItemClass = '.owl-item';
var slides = sync1.owlCarousel({
  items: 1,
  loop: true,
  margin: 0,
  mouseDrag: true,
  touchDrag: true,
  pullDrag: false,
  scrollPerPage: true,
  nav: false,
  dots: false,
}).on('changed.owl.carousel', syncPosition);

function syncPosition(el) {
  $owl_slider = $(this).data('owl.carousel');
  var loop = $owl_slider.options.loop;

  if (loop) {
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - (el.item.count / 2) - .5);
    if (current < 0) {
      current = count;
    }
    if (current > count) {
      current = 0;
    }
  } else {
    var current = el.item.index;
  }

  var owl_thumbnail = sync2.data('owl.carousel');
  var itemClass = "." + owl_thumbnail.options.itemClass;

  var thumbnailCurrentItem = sync2
    .find(itemClass)
    .removeClass("synced")
    .eq(current);
  thumbnailCurrentItem.addClass('synced');

  if (!thumbnailCurrentItem.hasClass('active')) {
    var duration = 500;
    sync2.trigger('to.owl.carousel', [current, duration, true]);
  }
}
var thumbs = sync2.owlCarousel({
    items: 3,
    loop: false,
    margin: 0,
    nav: true,
    dots: false,
    responsive:{
        500:{
            items: 4,
        },
        768:{
            items: 5,
        },
        992:{
            items: 4,
        },
        1200:{
            items: 5,
        },
    },
    onInitialized: function(e) {
      var thumbnailCurrentItem = $(e.target).find(thumbnailItemClass).eq(this._current);
      thumbnailCurrentItem.addClass('synced');
    },
  })
  .on('click', thumbnailItemClass, function(e) {
    e.preventDefault();
    var duration = 500;
    var itemIndex = $(e.target).parents(thumbnailItemClass).index();
    sync1.trigger('to.owl.carousel', [itemIndex, duration, true]);
  }).on("changed.owl.carousel", function(el) {
    var number = el.item.index;
    $owl_slider = sync1.data('owl.carousel');
    $owl_slider.to(number, 500, true);
});
sync1.owlCarousel();
$( ".owl-prev").html('<i class="las la-angle-left"></i>');
$( ".owl-next").html('<i class="las la-angle-right"></i>');

// Add to Cart

$(".qtybutton").on("click", function() {
  var $button = $(this);
  $button.parent().find('.qtybutton').removeClass('active')
  $button.addClass('active');
    var oldValue = $button.parent().find("input").val();
    if ($button.hasClass('inc')) {
        var newVal = parseFloat(oldValue) + 01;
    } else {
        if (oldValue > 1) {
            var newVal = parseFloat(oldValue) - 01;
        } else {
            newVal = 01;
        }
    }
  $button.parent().find("input").val(newVal);
});

// Cart Toggleer
var carToggler = $('.cart-toggler');
carToggler.on('click', function () {
  $('.cart-sidebar').toggleClass('active');
  $('.overlay').addClass('active');
})
 var cartClose = $('.close-cart');
 cartClose.on('click', function() {
   $(this).parent().removeClass('active')
   $('.overlay').removeClass('active')
 })


//  Product Filter
 // filter functions
 var $gallery = $(".product-filter-wrapper");
 var filterFns = {};
 $gallery.isotope({
   itemSelector: '.col-xl-3',
   masonry: {
     columnWidth: 0,
   }
 });
 // bind filter button click
 $('ul.filter').on('click', 'li', function () {
   $('ul.filter li').removeClass('active');
   $(this).addClass('active');
   var filterValue = $(this).attr('data-filter');
   // use filterFn if matches value
   filterValue = filterFns[filterValue] || filterValue;
   $gallery.isotope({
     filter: filterValue
   });
 });

$('.user-toggler').on('click', function() {
  $('.dashboard-sidebar').toggleClass('active')
})

$('.close-dashboard').on('click', function() {
  $('.dashboard-sidebar').removeClass('active')
})