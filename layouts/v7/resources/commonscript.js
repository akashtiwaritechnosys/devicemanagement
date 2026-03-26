// ************** Document Ready Starts Here **************
$(document).ready(function () {
  // ************** Navbar Scroll Effect Starts Here **************
  $(window).on("scroll", function () {
    const $searchCont = $(".search-cont");
    const $sidemenu = $(".app-menu ");
    if ($(this).scrollTop() > 10) {
      $searchCont.addClass("scrolled");
      $sidemenu.addClass("scrolled");
    } else {
      $searchCont.removeClass("scrolled");
       $sidemenu.removeClass("scrolled");
    }

  });
  // ************** Navbar Scroll Effect Ends Here **************

  // ************** FloatThead Scroll Fix on Dropdown Starts Here **************
  // $(".more.dropdown").on("shown.bs.dropdown", function () {
  //   $(".floatThead-wrapper .ps-container").addClass("ps-visible");
  // });

  // $(".more.dropdown").on("hidden.bs.dropdown", function () {
  //   $(".floatThead-wrapper .ps-container").removeClass("ps-visible");
  // });
  // ************** FloatThead Scroll Fix Ends Here **************

  // ************** MutationObserver for .ready .test Element Starts Here **************
  setTimeout(() => {
    const target = document.querySelector(".ready .test");
    if (target) {
      const observer = new MutationObserver(() => {
        target.removeAttribute("style");
      });
      observer.observe(target, {
        attributes: true,
        attributeFilter: ["style"],
      });
      console.log("MutationObserver attached after delay.");
    } else {
      console.log("Element not found after delay.");
    }
  }, 1000);
  // ************** MutationObserver Ends Here **************

  // ************** Dark/Light Mode Toggle Starts Here **************
  if (localStorage.getItem("theme") === "dark") {
    $("html").addClass("dark-mode");
  }

  $("#theme-toggle").on("click", function () {
    $("html").toggleClass("dark-mode");
    const newTheme = $("html").hasClass("dark-mode") ? "dark" : "light";
    localStorage.setItem("theme", newTheme);
  });
  // ************** Dark/Light Mode Toggle Ends Here **************

  // ************** Disable Body Scroll on Modal Open Starts Here **************
  // $(document).on("shown.bs.modal", function () {
  //   $("body").css("overflow", "hidden");
  // });

  // $(document).on("hidden.bs.modal", function () {
  //   $("body").css("overflow", "");
  // });
  // ************** Disable Body Scroll on Modal Open Ends Here **************


// ****************** to increase the width of the "Assign To" search bar start here ***********
   jQuery(document).ready(function() {
    jQuery('select[name="assigned_user_id"]').select2({
      width: '190px'
    });
  });
// ****************** to increase the width of the "Assign To" search bar ends here ***********


});
// ************** Document Ready Ends Here **************
