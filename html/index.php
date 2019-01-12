<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/styles.css"/>
    <title>SubstanceWiki</title>
</head>
<body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="scripts/livesearch.js"></script>

<?php include('livesearch.php'); ?>
<?php include('connection.php');?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">SubstanceWiki</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse navmenu" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="substance.php?substance=DMT">Substance</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Login</a>
            </li>
        </ul>
        <div class="wrapper">
            <div class="div1"><form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" onkeyup="showResult(this.value)" type="search" placeholder="Search">
                    <!--                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
                </form></div>
            <div class="list-group div2" id="livesearch"> </div>
        </div>
    </div>
</nav>


<div id="content">
    <div class="alert alert-danger endorsementAlert" role="alert">
        <img src="img/warning.png" style="object-fit: cover; height: 35px;">
        <span>The information contained on this page is for education purposes only. We do not condone or endorse the use of psychoactive substances.
            However we do believe in freedom of information and harm reduction.</span>
    </div>
    <h3>Mission</h3>
    <hr>
    <p>SubstanceWiki is an informational website committed to providing accurate, objective and scientific harm reduction information
    on the pharmacology, chemistry and safety of psychoactive chemicals. The purpose of this website is to provide a source of
    unbiased information for students and pharmacology enthusiasts alike. As stated in the warning at the top of the page,
        the creator of this website does not condone or endorse the use of any psychoactive substance be it one listed on this site or
    otherwise. Experimenting with such substances can be incredibly dangerous and even fatal. However with this stated, we are not
    ignorant to the fact that some people will choose to continue to do this regardless of being advised against it. Due to this
    we are determined to provide a source of safety oriented information to decrease the number of incidences where
    misuse of drugs has caused serious harm.</p>
    <p>This website consists of many pages on various substances, each page contains a general description of the substance,
    information on it's pharmacology and chemistry, a dosage table which indicates what size of dose can be most safely taken
    for a given level of effects as well as a section detailing the effects a substance can be expected to cause.</p>
    <p>To find a given substance, you can either use the live search in the navigation bar or you can browse the library
    of substances below this text.</p>
    <h3>Substances</h3>
    <hr>
    <div class="container-flex row">
    <?php
    $sql = "SELECT * FROM substances";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $name = $row["SubstanceName"];
            $desc = $row["SubstanceDescription"];
            $img = $row["StructureImageName"];

            if (strlen($desc) > 100)
            {
                $lastPos = (10 - 3) - strlen($desc);
//                $newdesc = substr($desc, 0, strrpos($desc, ' ', 10)) . '...';
                $newdesc = mb_strimwidth($desc, 0, 125, "...");

            }?>

            <div id="card-container" class="card col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-6" style="height: 450px;">
                <div style="height:200px;">
                <img class="card-img-top" style="max-height: 175px; object-fit: contain;" src="img/<?php echo $img?>" alt="Substance image"></div>
                <div class="card-body substance-card">
                    <h5 class="card-title"><?php echo $name?></h5>
                    <p class="card-text"><?php echo $newdesc?></p>
                    <a href="substance.php?substance=<?php echo $name ?>" class="btn btn-primary">Select</a>
                </div>
            </div>
    <?php    }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
    </div>
</div>
</body>
</html>