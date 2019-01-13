<?php
include("connection.php");

$query = "SELECT * FROM substances";
$result = $conn->query($query);

while($row = $result->fetch_array())
{
    $a[]=$row["SubstanceName"];
}

$result->free();

$conn->close();

$q = @$_REQUEST["q"];

$hint = "";

if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (@stristr($q, @substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = "<a href=\"substance.php?substance=" . $name . "\" class=\"list-group-item list-group-item-action\">" . $name . "</a>";
            } else {
                $hint = "<a href=\"substance.php?substance=" . $name . "\" class=\"list-group-item list-group-item-action\">" . $name . "</a>";
            }
        }
    }
}

if (isset($q))
{
    if ($hint != "") {
        echo $hint;
    }
}
?>