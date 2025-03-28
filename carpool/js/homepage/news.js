var swiper = new Swiper('.swiper-container', {
  slidesPerView: 1.5, // Show part of previous & next slides
  spaceBetween: 2, // Spacing between slides
  centeredSlides: true, // Center active slide
  watchSlidesProgress: true, // Helps Swiper track slides correctly
  loop: true, // Enable infinite scrolling
  autoplay: {
      delay: 3000, // Auto-slide every 3 seconds
      disableOnInteraction: false, // Continue autoplay after user interaction
  },
  pagination: {
      el: ".swiper-pagination",
      clickable: true, // Allow clicking on dots
  },
  navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
  },
});

//2
function openCity(cityName,elmnt,color) {
  var i, tabcontent, tablinks;

   // Hide all tab content
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
  }

   // Reset background color for all tab links
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.backgroundColor = ""; // Remove previous color
      tablinks[i].classList.remove("active");
  }

  // Show the selected tab content
  document.getElementById(cityName).style.display = "block";
  elmnt.style.backgroundColor = color;

  // Add active class to the clicked tab
  elmnt.classList.add("active");

  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();

  
function openTab(evt, tabName) {
    // Remove 'active' class from all tabs
    var tablinks = document.getElementsByClassName("tablink");
    for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
       }

    // Add 'active' class to the clicked tab
    evt.currentTarget.classList.add("active");

    // Show the related tab content (optional logic)
    var tabcontent = document.getElementsByClassName("tabcontent");
        for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
        }
        document.getElementById(tabName).style.display = "block";
    }   