$(document).ready(function() {
  $('.slick-carousel-standard').slick({
    slidesToShow: 4,
    autoplay: true,
    autoplaySpeed: 500000,
    arrows: false,
    swipeToSlide: true,
    draggable: true,
    responsive: [{
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 360,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });
})
