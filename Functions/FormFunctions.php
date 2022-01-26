<?php

function ProjectField($name, $value, $size = 15, $comment = "")
{
        echo "<tr><td>" . $name . ":</td><td><input name=\"" . $name . "\" value=\""
         . $value . "\" size=" . $size . ">";
        echo "<span style=\"color: red;\"> " . $comment . "</span></td></tr>";
}

function ProjectTextarea($name, $value, $rows = 5, $cols = 40)
{
        echo "<tr><td>" . $name . ":</td><td><textarea name=\"" . $name
         . "\" rows=" . $rows . " cols=" . $cols . ">" . $value . "</textarea></td></tr>";
}

function ProjectCheckbox($name, $value)
{
        echo "<tr><td>" . $name . ":</td><td>";
        echo "<input name=\"" . $name . "\" type=\"hidden\" value=0>";
        echo "<input name=\"" . $name . "\" type=\"checkbox\"";
        if ($value == 1)
                echo " checked";
        echo ">";
        echo "</td></tr>";
}

?>
