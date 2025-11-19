<!DOCTYPE html>
<html>
<head>
    <title>Smart Waste Report</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>

<body>

    <div class="topbar">
        <div class="title">Smart Waste Report</div>

        <div class="buttons">
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        </div>
    </div>

   <div class="content">
    <div class="content-box">
        <h1>Welcome to Smart Waste Report System</h1>
        <p>“See trash? Report fast! Let’s clean our nation together.”</p>
    </div>
</div>

<div class="slideshow">
    <div class="slide fade">
        <img src="images/clean_first.png">
    </div>

    <div class="slide fade">
        <img src="images/clean1.png">
    </div>

    <div class="slide fade">
        <img src="images/clean2.png">
    </div>
    
    <div class="slide fade">
        <img src="images/clean3.png">
    </div>
    
    <div class="slide fade">
        <img src="images/clean4.png">
    </div>
</div>

<script>
let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.getElementsByClassName("slide");

    // hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slideIndex++;

    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    slides[slideIndex - 1].style.display = "block";

    // change slide every 3 seconds
    setTimeout(showSlides, 3000);
}
</script>


</body>
</html>
