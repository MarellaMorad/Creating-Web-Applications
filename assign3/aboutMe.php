<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Creating Web Applications">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, SQL">
    <meta name="author" content="Marella Morad">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>About Me</title>
    <!--Add a favicon to the website-->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/enhancements.js"></script>
</head>

<body>
    <?php include('header.inc'); ?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <h1>About Me</h1>
    <section id="demographic" class="more-about-me">
        <h2>Demographics</h2>
        <p>
            My name is <strong>Marella Morad</strong> and as you may know, I
            am the <strong>CEO of TechWave.</strong>
        </p>
        <p>
            I come from a small city in North Eastern
            <a href="https://en.wikipedia.org/wiki/Syria">Syria</a> called
            <a href="https://en.wikipedia.org/wiki/Al-Hasakah">Al-Hasakah</a>
        </p>
        <img src="images/flying-to-aus.gif"
            alt="World Map with an animation of an airplane flying from Syria to Australia">
        <p>
            I speak two languages: <strong>Arabic</strong>, my mother
            language and yes you guessed it, <strong>English</strong>, which
            I got better at after migrating to Australia
        </p>
        <p id="arabic-text">
            For example:
            <strong>"مرحبا انا اسمي ماريلا مراد وانا مديرة شركة تيك ويف"</strong>
            is the same as the introduction you see above
        </p>
        <p>
            Check this voice note below where I say the sentence in both Arabic and English!
        </p>
        <audio controls>
            <source src="audio/intro.mp3" type="audio/mp3">
            Your browser does not support the audio element.
        </audio>
    </section>
    <section class="more-about-me">
        <h2>Hobbies</h2>
        <p>
            One thing you might not know about me is that I also
            <strong>Sing</strong>, alongside managing TechWave.
        </p>
        <p>
            <span class="fas fa-arrow-down"></span> Here's a video of me
            singing in Arabic <span class="fas fa-arrow-down"></span>
        </p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/DbRIJcjj2bs" title="YouTube video player"
            allowfullscreen></iframe>
    </section>
    <section id="socials" class="more-about-me">
        <h2>Socials</h2>
        <p>
            Lastly, if you want to get in touch with me, you can follow me
            on my Socials!
        </p>
        <div>
            <a href="https://www.facebook.com/music.m.b.m.e99" title="Link to my Facebook Page"><span
                    class="fab fa-facebook"></span></a>
            <a href="https://www.instagram.com/music.m.b.m/" title="Link to my Instagram Page"><span
                    class="fab fa-instagram"></span></a>
            <a href="https://www.linkedin.com/in/marellamorad" title="Link to my LinkedIn Profile"><span
                    class="fab fa-linkedin"></span></a>
        </div>
    </section>
    <?php include('footer.inc'); ?>
</body>

</html>