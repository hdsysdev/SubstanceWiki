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

$request = @$_REQUEST["q"];

$hint = "";

if ($request !== "") {
    $request = strtolower($request);
    $len=strlen($request);
    foreach($a as $name) {
        if (@stristr($request, @substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = "<a href=\"substance.php?substance=" . $name . "\" class=\"list-group-item list-group-item-action\">" . $name . "</a>";
            } else {
                $hint = "<a href=\"substance.php?substance=" . $name . "\" class=\"list-group-item list-group-item-action\">" . $name . "</a>";
            }
        }
    }
}

if (isset($request))
{
    if ($hint != "") {
        echo $hint;
    }
}
?>