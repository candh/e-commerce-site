<?php
function formatUrl($url) {
	$url = strtolower($url);
	$url = preg_replace('/[^[:alnum:]]/', ' ', $url);
    $url = preg_replace('/[[:space:]]+/', '-', $url);
    return $url;
};
?>