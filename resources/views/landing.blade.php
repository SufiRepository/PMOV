<!DOCTYPE html>
<html>
<title>Project Management Office</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<body>
  
<!-- Header -->
<header class="w3-container w3-blue-grey w3-padding" id="myHeader">

  <div class="w3-bar w3-blue">
    <a href="#" class="w3-bar-item w3-button w3-padding-16">Home</a>
    <a href="http://staging.pmo.mindwave.my/login" class="w3-bar-item w3-button w3-padding-16">Login</a>
    <a href="http://staging.pmo.mindwave.my/register" class="w3-bar-item w3-button w3-padding-16">Sign Up</a>
  </div>

  <div class="w3-center">
  <h4>Welcome to </h4>
  <h1 class="w3-xxxlarge w3-animate-bottom">Project Management System </h1>
    <div class="w3-padding-32">
      <button class="w3-btn w3-xlarge w3-dark-grey w3-hover-light-grey" onclick="document.getElementById('id01').style.display='block'" style="font-weight:900;">More About us</button>
    </div>
  </div>
</header>

<!-- Modal -->
<div id="id01" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-top">
      <header class="w3-container w3-theme-l1"> 
        <span onclick="document.getElementById('id01').style.display='none'"
        class="w3-button w3-display-topright">×</span>
        <h4>Oh snap! We just showed you a modal..</h4>
        <h5>Because we can <i class="fa fa-smile-o"></i></h5>
      </header>
      <div class="w3-padding">
        <p>Cool huh? Ok, enough teasing around..</p>
        <p>Go to our <a class="w3-btn" href="/w3css/default.asp">W3.CSS Tutorial</a> to learn more!</p>
      </div>
      <footer class="w3-container w3-theme-l1">
        <p>Modal footer</p>
      </footer>
    </div>
</div>


<div class="w3-row-padding w3-center w3-margin-top">
<div class="w3-third">
  <div class="w3-card w3-container" style="min-height:460px">
  <h3>Frequent Updates</h3><br>
  <i class="fa fa-refresh" aria-hidden="true" style="font-size:120px"></i>
  {{-- <i class="fa fa-desktop w3-margin-bottom w3-text-theme" style="font-size:120px"></i> --}}
  <p>Project Management System  is improved constantly, </p>
  <p> with new releases every few weeks.</p>
  <p>Bug-fixes and new features ship daily.</p>
  </div>
</div>

<div class="w3-third">
  <div class="w3-card w3-container" style="min-height:460px">
  <h3>Dedicated Support</h3><br>
  <i class="fa fa-phone" aria-hidden="true" style="font-size:120px"></i>
  {{-- <i class="fa fa-css3 w3-margin-bottom w3-text-theme" style="font-size:120px"></i> --}}
  <p>Our full-time in-house support</p>
  <p>team is ready to answer all technical</p>
  <p>difficulties customers may encounter</p>
  <p>with any of our products.</p>
  </div>
</div>

<div class="w3-third">
  <div class="w3-card w3-container" style="min-height:460px">
  <h3>Real-Time Software</h3><br>
  <i class="fa fa-clock-o" aria-hidden="true" style="font-size:120px"></i>
  {{-- <i class="fa fa-diamond w3-margin-bottom w3-text-theme" style="font-size:120px"></i> --}}
  <p> The first step in any successful</p>
  <p>it works in real-time so you can see</p>
  <p>what’s happening as it happens,</p>
  <p>and teams get to collaborate.</p>
  </div>
</div>
</div>


<div class="w3-container w3-center">
  <hr>
  <h3></h3>
</div>

{{-- <div class="w3-row-padding"> 

  <div class="w3-third">
  <div class="w3-card">
    <img src="register.png" alt="Car" style="width:100%">
    <div class="w3-container">
    <p>Register</p>
    </div>
  </div>
  </div>
  
  <div class="w3-third">
  <div class="w3-card-4">
    <img src="login.png" alt="Car" style="width:100%">
    <div class="w3-container">
    <p>Login</p>
    </div>
  </div>
  </div>

  <div class="w3-third">
    <div class="w3-card-4">
      <img src="/w3images/car.jpg" alt="Car" style="width:100%">
      <div class="w3-container">
      <p>dashboard</p>
      </div>
    </div>
    </div>

</div>
<br>  --}}

<!-- Footer -->
<footer class="w3-container w3-blue-grey w3-padding">
  <h3>Project Managment System </h3>
  <p>Powered by <a href=" https://mindwave.my/" target="_blank">Mindwave Consultancy SDN BHD</a></p>
  <div style="position:relative;bottom:55px;" class="w3-tooltip w3-right">
    <span class="w3-text w3-theme-light w3-padding">Go To Top</span>    
    <a class="w3-text-white" href="#myHeader"><span class="w3-xlarge">
    <i class="fa fa-chevron-circle-up"></i></span></a>
  </div>
  {{-- <p>Remember to check out our  <a href="w3css_references.asp" class="w3-btn w3-theme-light" target="_blank">W3.CSS Reference</a></p> --}}
</footer>

<!-- Script for Sidebar, Tabs, Accordions, Progress bars and slideshows -->
<script>
// Side navigation
function w3_open() {
  var x = document.getElementById("mySidebar");
  x.style.width = "100%";
  x.style.fontSize = "40px";
  x.style.paddingTop = "10%";
  x.style.display = "block";
}
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
}

// Tabs
function openCity(evt, cityName) {
  var i;
  var x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  var activebtn = document.getElementsByClassName("testbtn");
  for (i = 0; i < x.length; i++) {
    activebtn[i].className = activebtn[i].className.replace(" w3-dark-grey", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " w3-dark-grey";
}

var mybtn = document.getElementsByClassName("testbtn")[0];
mybtn.click();

// Accordions
function myAccFunc(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}

// Slideshows
var slideIndex = 1;

function plusDivs(n) {
  slideIndex = slideIndex + n;
  showDivs(slideIndex);
}

function showDivs(n) {
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length} ;
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}

showDivs(1);

// Progress Bars
function move() {
  var elem = document.getElementById("myBar");   
  var width = 5;
  var id = setInterval(frame, 10);
  function frame() {
    if (width == 100) {
      clearInterval(id);
    } else {
      width++; 
      elem.style.width = width + '%'; 
      elem.innerHTML = width * 1  + '%';
    }
  }
}
</script>

</body>
</html>
