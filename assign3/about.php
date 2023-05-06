<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Creating Web Applications">
    <meta name="keywords" content="HTML, CSS, JavaScript, PHP, SQL">
    <meta name="author" content="Marella Morad">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>About Us</title>
    <!--Add a favicon to the website-->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="scripts/enhancements.js"></script>
</head>

<body>
    <?php include('header.inc'); ?>
    <button class="back-to-top hidden"><span class="fa fa-angle-up"></span></button>
    <h1>About Us</h1>
    <div class="about-us">
        <figure>
            <a href="aboutMe.php"><img title="Learn more about our CEO!" src="images/personal_picture.jpg"
                    alt="Marella's Personal Photo"></a>
            <figcaption>
                CEO and Co-founder of TechWave - Marella Morad
            </figcaption>
        </figure>
        <dl>
            <dt>Name:</dt>
            <dd>Marella Morad</dd>
            <dt>Meaning:</dt>
            <dd>
                Star of the Sea<sup><a class="ref" href="http://www.thinkbabynames.com/meaning/0/Marella">3</a></sup>
            </dd>
            <dt>Student Number:</dt>
            <dd>103076428</dd>
            <dt>Student Email:</dt>
            <dd>
                <a href="mailto:103076428@student.swin.edu.au">103076428@student.swin.edu.au</a>
            </dd>
            <dt>Tutor's Name:</dt>
            <dd>Jingwen Zhou</dd>
            <dt>Course:</dt>
            <dd>
                Bachelor of Engineering (Honours) (Professional) Majoring in
                Software
            </dd>
        </dl>
    </div>
    <div class="about-me">
        <aside>
            <a href="aboutMe.php">Wanna learn more about our CEO?</a>
        </aside>
    </div>
    <div class="timetable-wrapper">
        <table>
            <caption>
                Swinburne Timetable
            </caption>
            <tr>
                <th></th>
                <th>MON</th>
                <th>TUE</th>
                <th>WED</th>
                <th>THUR</th>
                <th>FRI</th>
            </tr>
            <tr>
                <td>8:00</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cos">COS30008</td>
                <td></td>
            </tr>
            <tr>
                <td>9:00</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cos">COS30008</td>
                <td></td>
            </tr>
            <tr>
                <td>10:00</td>
                <td class="swe">SWE30003</td>
                <td></td>
                <td></td>
                <td class="swe">SWE30003</td>
                <td></td>
            </tr>
            <tr>
                <td>11:00</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>12:00</td>
                <td class="cos one-class">COS30008</td>
                <td></td>
                <td></td>
                <td class="web one-class">COS10011</td>
                <td></td>
            </tr>
            <tr>
                <td>13:00</td>
                <td class="cos one-class"></td>
                <td></td>
                <td></td>
                <td class="web one-class keep-border"></td>
                <td></td>
            </tr>
            <tr>
                <td>14:00</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="eee one-class"></td>
                <td></td>
            </tr>
            <tr>
                <td>15:00</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="eee one-class">EEE40002</td>
                <td></td>
            </tr>
            <tr>
                <td>16:00</td>
                <td class="eee">EEE40002</td>
                <td></td>
                <td></td>
                <td class="eee one-class"></td>
                <td></td>
            </tr>
            <tr>
                <td>17:00</td>
                <td class="web one-class">COS10011</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>18:00</td>
                <td class="web one-class keep-border"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
    <?php include('footer.inc'); ?>
</body>

</html>