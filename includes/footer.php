<footer>
  <!-- <p><a href="/">Return to Top</a></p> -->
  <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
  <p>401 college ave., ithaca, New York 14850</p>
  <p class="createdBy">This is an INFO 2300 project created by: <a href="mailto: wz82@cornell.edu" class="createdBy">Amber Zheng</a></p>
</footer>

<script>
//Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>
