<?php

// run as: php self_name.php <build_number>

require_once('config.php');

$c = '$(which curl) --silent -u ' . LOGIN . ':' . PASSWORD . ' "' . BASE_URL . '/httpAuth/app/rest/buildTypes/id:' . BUILD_ID . '/builds/status:SUCCESS" > ./last-success-build.xml';
exec($c);

$last_success_build = new SimpleXMLElement(file_get_contents('./last-success-build.xml'));
$last_success_build_number  = $last_success_build['number'] . '';
$last_success_build_version = $last_success_build->revisions->revision['version'] . '';

//$build_dir = $argv[1];

$c = '$(which git) log ' . $last_success_build_version . '..HEAD --pretty=format:"%h %ad | %s [%an]" --graph --date=short > ./changes.lst';
exec($c);

echo(file_get_contents('./changes.lst'));

/*
$c = '$(which curl) --silent -u ' . LOGIN . ':' . PASSWORD . ' "' . BASE_URL . '/httpAuth/app/rest/changes?locator=build:(number:' . $number . ')" > ./changes.xml';
exec($c);

$changes = new SimpleXMLElement(file_get_contents('./changes.xml'));

foreach ($changes->change as $change) {
  $url = BASE_URL . $change['href'];
  $c   = '$(which curl) --silent -u ' . LOGIN . ':' . PASSWORD . ' ' . $url . ' > ./change.xml';
  exec($c);
  $change_xml = new SimpleXMLElement(file_get_contents('./change.xml'));
  echo($change_xml->comment . '');
}
*/

//unlink('changes.xml');
//unlink('change.xml');
