<?php
require_once "setup.php";

if(isset($_GET['q'])) $q=htmlentities($_GET['q']);
else $q=false;

showHeader("Thread Exchange",$q);
$threadList = getThreadList($q);

echo '<div class="row"><table class="table table-striped"><tbody>';

//show list of threads
foreach($threadList as $t){
  echo '
  <tr>
    <td>';
    $str=$t['desc'];
    if (strlen($str) > 20)
      $str = substr($str, 0, 7) . '...';
    echo $str;
    echo '</td>
    <td>';
    echo number_format($t['price'],2).' '.$t['currency'];
    echo '
    </td>
    <td>
      <button type="button" class="btn btn-secondary">Contact</button>
    </td>
  </tr>
  ';
}
echo '</tbody></table></div>';
showFooter();