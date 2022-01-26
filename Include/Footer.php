	</td></tr></tbody></table></td></tr>
	<tr class="FooterRow" style="font-size: 8pt; font-weight: bold;">
	</tr>
</table>

<?php

// Record the page load end time, and report it

	$time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$finish = $time;
	$total_time = round(($finish - $start), 4);
	if ($DebugMode == true)
	{
	}
?>

</body>
</html>
