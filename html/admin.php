<?php
session_start();

if (@$_POST["logout"]=="Log Out")
{
    unset($_SESSION["username"]);
}
?>
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
<script src="scripts/logout.js"></script>
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
                <a class="nav-link" href="substance.php">Substance</a>
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
//TODO: INSTALL DEBUGGER TO KEEP USER LOGGED IN AND CHECK VARIABLES
if (!empty($_POST['username']) || !empty($_SESSION["username"])) {
    if (!empty($_SESSION["username"])){
        $username = $_SESSION["username"];
    } else {
        $username = "\"" . $_POST['username'] . "\"";
        $password = "\"" . $_POST['password'] . "\"";
    }
    $sql = "SELECT * FROM admin WHERE username=" . $username;
    $result = $conn->query($sql);

    //Checks if username is found in the database
    if ($result->num_rows == 1) {
        while($row = $result->fetch_assoc()) {
            $database_password = $row["password"];
        }
        //Compares user password to hashed password in database
        if (@$_SESSION["username"] == $username || password_verify($password, $database_password)){
            $_SESSION["username"] = $username;
            $sql = "SELECT * FROM substances";
            $result = $conn->query($sql);
            ?>
            <div class="col-lg-6">
                <form>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Substance Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Pharmacology</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Pharmacology" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Chemistry" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Low Dose Range</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Low Dose Range">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Mid Dose Range</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputPassword3" placeholder="Mid Dose Range">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">High Dose Range</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="High Dose Range">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Structure Image Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputPassword3" placeholder="Structure Image Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label >Structure Image</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Physical Effects</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Physical Effects">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Cognitive Effects</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputPassword3" placeholder="Cognitive Effects">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>


                        </div>
                    </div>
                </form>
                <form action="admin.php" method="post" style="display: inline;">
                    <input type="submit" class="btn btn-primary" name="logout" value="Log Out">
                </form>
            </div>
            <hr>
            <h3>Substances</h3>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Pharmacology</th>
                    <th scope="col">Chemistry</th>
                    <th scope="col">Low Doses</th>
                    <th scope="col">Medium Doses</th>
                    <th scope="col">High Doses</th>
                    <th scope="col">Image</th>
                    <th scope="col">Physical Effects</th>
                    <th scope="col">Cognitive Effects</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                            <td>" . $row[2] . "</td>
                            <td>" . $row[3] . "</td>
                            <td>" . $row[4] . "</td>
                            <td>" . $row[5] . "</td>
                            <td>" . $row[6] . "</td>
                            <td>" . $row[7] . "</td>
                            <td>" . $row[8] . "</td>
                            <td>" . $row[9] . "</td>
                            <td>" . $row[10] . "</td>
                            <td>" . $row[11] . "</td>
                            <td> <form action='admin.php' method='GET'> 
                            <button type='submit' name='substance' value='" . $row[2] ."' class=\"btn btn-primary\">Edit</button>
                            <button type=\"submit\" class=\"btn btn-primary\">Delete</button></form></td>
                          </tr>";
                }
                ?>
                </tbody>
            </table>

    <?php }} else { ?>
        <div class="jumbotron col-lg-6" style="margin:0 auto;">
            <h2>Login</h2>

            <div>
                <form action="admin.php" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input name="username" type="text" class="form-control"
                               placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input name="password" type="text" class="form-control"
                               placeholder="Password" required>
                    </div>
                    <div class="alert alert-danger" role="alert">
                        Username or password is incorrect!
                    </div>
                    <button type="submit" class="btn btn-outline-success btn-primary my-2 my-sm-0">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    <?php }
    $conn->close();
} else { ?>
    <div class="jumbotron col-lg-6" style="margin:0 auto;">
        <h2>Login</h2>

        <div>
            <form action="admin.php" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input name="username" type="text" class="form-control"
                           placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input name="password" type="text" class="form-control"
                           placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-outline-success btn-primary my-2 my-sm-0">
                    Submit
                </button>
            </form>
        </div>
    </div>
<?php }
?>

</body>
</html>