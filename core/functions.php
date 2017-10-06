<?php
function load_conf($conf){
	$path=ROOT.DS.'config'.DS.$conf.'.php';
	if (file_exists($path)){
        require_once($path);
    }else{
   		$trace = debug_backtrace();
		trigger_error('fallo al cargar la configuracion '.$path.' '.$trace[0]['file'].' en la linea '.$trace[0]['line'],E_USER_ERROR);
    }
}
function print_html($my_array) {
    if (is_array($my_array)) {
        echo "<table border=1 cellspacing=0 cellpadding=3 width=100%>";
        echo '<tr><td colspan=2 style="background-color:#333333;"><strong><font color=white>ARRAY</font></strong></td></tr>';
        foreach ($my_array as $k => $v) {
                echo '<tr><td valign="top" style="width:40px;background-color:#F0F0F0;">';
                echo '<strong>' . $k . "</strong></td><td>";
                print_html($v);
                echo "</td></tr>";
        }
        echo "</table>";
        return;
    }
    print_r($my_array);
}
function go404()
{
    header('Location: '.PATH.'/404');
    exit();
}
function array_html($a)
{
    echo '<table border="1"><tr>';
    foreach (array_keys($a[0])as $header) {
        echo "<th>{$header}</th>";
    }
    echo '</tr><tbody>';
    foreach ($a as $row) {
        echo '<tr>';
        foreach ($row as $colum) {
                echo "<td>{$colum}</td>";
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
}

function print_r_log($var)
{
    error_log(print_r($var, TRUE)); 
}