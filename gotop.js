(function ($) {
    $("body").append("<img id='goTopButton' style='display:none;z-index:5;cursor:pointer;'title='回到頂端' />");
    var img = "./images/bntop02.png",
      location = 0.5,
      right = 100,
      opacity = 0.6,
      speed = 800,
    $button = $("#goTopButton"),
      $body = $(document),
      $win = $(window);
    $button.attr("src", img);

    window.goTopMove = function () {
      var scrollH = $body.scrollTop(),
        winH = $win.height(),
        css = { "top": (winH * location)*1.5 + "px", "position": "fixed", "right": right, "opacity": opacity};

      if (scrollH > 20) {
        $button.css(css);
        $button.fadeIn("slow");
      } else {
        css={"transform":"none","transition":"none"};
        $button.css(css);
        $button.fadeOut("slow")
      }
    };
    $win.on({
      scroll: function () { goTopMove(); },
      resize: function () { goTopMove(); }
    });
    $button.on({
      mouseover: function () { $button.css("opacity", 1); },
      mouseout: function () { $button.css("opacity", opacity); },
      click: function () {
        css={};
        $button.css(css);
        $("html,body").animate({ scrollTop: 0 }, speed); }
    });

  })(jQuery);