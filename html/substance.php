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

<?php
$substance = "\"".$_GET['substance']."\"";
$sql = "SELECT * FROM substances WHERE SubstanceName=" . $substance;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $name = $row["SubstanceName"];
        $desc = $row["SubstanceDescription"];
        $pharm = $row["SubstancePharm"];
        $chem = $row["SubstanceChemistry"];
        $lowdose = $row["LowDoseRange"];
        $middose = $row["MediumDoseRange"];
        $highdose = $row["HighDoseRange"];
        $img = $row["StructureImageName"];
    }
} else {
    echo "0 results";
}
?>

<div id="content">
    <div class="alert alert-danger endorsementAlert" role="alert">
        <img src="img/warning.png" style="object-fit: cover; height: 35px;">
        <span>The information contained on this page is for education purposes only. We do not condone or endorse the use of psychoactive substances.
            However we do believe in freedom of information and harm reduction.</span>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <h1><?php echo $name?></h1>
                <hr class="my-4"/>
                <p><?php echo $desc;?></p>
                <h2>Chemistry</h2>
                <hr class="my-4"/>
                <p><?php echo $chem?></p>
                <h2>Pharmacology</h2>
                <hr class="my-4"/>
                <p><?php echo $pharm ?></p>
                <h2>Subjective Effects</h2>
                <hr/>
                <p>Remember, this is is not an exhaustive list, not all of these effects will manifest themselves every
                    time the substance is administered. Some of these effects may not be present at all. Re-dosing in an attempt to bring out effects not currently being experienced
                    is strongly advised against. This will almost always increase the side effects experienced without increasing
                    desirable effects.</p>
                <div class="card">
                    <h5 class="card-header">Physical Effects</h5>
                    <div class="card-body">
                        <dl>
                        <?php
//                        $substance = "\"".$_GET['substance']."\"";
                        $sql = "SELECT Effects FROM substances WHERE SubstanceName=" . $substance;
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $effectIDs = $row["Effects"];
                            }
                        }
                        $effects = str_replace(",", "','", $effectIDs);
                        $sql = "SELECT * FROM effects WHERE EffectID IN('" . $effects ."');";
                        $result = $conn->query($sql);


                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                if ($row["EffectType"] == "Physical"){
                                    echo "<dt>" . $row["EffectName"] ."</dt>
                                        <dd>" . $row["EffectDescription"] . "</dd>";
                                }
                            }
                        }
                        ?>
                        </dl>
                    </div>
                </div>
                <br>
                <div class="card">
                    <h5 class="card-header">Cognitive Effects</h5>
                    <div class="card-body">
                        <dl>
                        <?php
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                if ($row["EffectType"] == "Cognitive"){
                                    echo "<dt>" . $row["EffectName"] ."</dt>
                                        <dd>" . $row["EffectDescription"] . "</dd>";
                                }
                            }
                        }?>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="jumbotron">
                    <img class="img-thumbnail" style="width: 100%" src="<?php echo "img/".$img?>" >
                    <hr class="my-4">
                    <table class="table table-bordered" style="background: white;">
                        <thead>
                        <tr>
                            <th scope="col">Dose Bracket</th>
                            <th scope="col">Dose Range</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">Low</th>
                            <td><?php echo $lowdose?></td>
                        </tr>
                        <tr>
                            <th scope="row">Medium</th>
                            <td><?php echo $middose?></td>
                        </tr>
                        <tr>
                            <th scope="row">High</th>
                            <td><?php echo $highdose?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
    $conn->close();
    ?>
</div>
</body>
</html>