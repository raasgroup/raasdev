<?php
//add_shortcode( 'show_team', 'get_team_members' ); 
function get_team_members()
{
    $post_data = '<h4>The respected choice in small-cap and micro-cap research</h4>';

    $post_data .= '<p class="pop__content">RaaS Advisory is the benchmark for independent investment research on small-cap and';
    $post_data .= 'micro-cap companies. Our funds management approach and reputation for telling it';
    $post_data .= 'like it is has made us the go-to for companies looking for balanced and insightful';
    $post_data .= 'coverage in an overcrowded and under-researched investment market.</p>';

    $post_data .= drawTeamTile();


    if (count($_SESSION["post_ids"]->posts) == 0)
        $status = false;
    else
        $status = true;

    echo json_encode(array("post_val" => $post_data, "status" => $status));

    die();
}

function drawTeamTile()
{
    global $wpdb;
    //get employee dataset
    $employees = $wpdb->get_results("Select * from raas_employee order by last");

    $tileCode = '';
    $i = 1;

    foreach ($employees as $employee) {
        $name = $employee->First . ' ' . $employee->Last;
        $empImage = site_url() . $employee->picture;
        $popTileID = "popTile" . $i;
        $imageTileID = "imageTile" . $i;

        $tileCode .=
            '<div class="w3eden">'
            .   '<div id="equal_box" class="col-md-2 col-sm-6 col-xs-12">'
            .       '<div class="panel2" onmouseover="Popup(' . $i . ')" onmouseout="Popdown()">'
            .           '<div id=' . $imageTileID . '>'
            .               '<div class="media media--2x3">'
            .                   '<div class="">'
            .                       '<img alt="' . $name . '" src="' . $empImage . '"'
            .                       ' class="lazyautosizes lazyloaded">'
            .                   '</div>'
            .                   '<div class="bottomleft">' . $name . '</div>'
            .               '</div>'
            .           '</div>';

            $tileCode .=    drawPopTile($employee, $popTileID, $imageTileID);

            $tileCode .=
                   '</div>'
            .   '</div>'
            .'</div>';

        $i = $i + 1;
    }
    return $tileCode;
}

function drawPopTile($employee, $popTileID, $imageTileID)
{
    $tileCode = '';
    $tileCode .=    '<div id=' . $popTileID . ' class="pop pop--top">'
    .                   '<div class="pop__header">'
    .                       '<h5 class="pop__title">' . $employee->position . '</h5>'
    .                   '</div>';
    $tileCode .=    drawEmployeeContact($employee);
    $tileCode .=    drawEmployeeCv($employee);
    $tileCode .=    '</div>';

    return $tileCode;
}

function drawEmployeeCv($employee)
{
    $tileCode = '';
    $tileCode .=    '<div class="pop_line">' . $employee->Specialities . '</div>'
    .               '<div class="pop_line">' . $employee->cv . '</div>'
    .               '<div class="pop_line">'
    .                   '<ul class="a">';

    if ($employee->bullet1 != "")
        $tileCode .= '<li>' . $employee->bullet1 . '</li>';
    if ($employee->bullet2 != "")
        $tileCode .= '<li>' . $employee->bullet2 . '</li>';
    if ($employee->bullet3 != "")
        $tileCode .= '<li>' . $employee->bullet3 . '</li>';
    if ($employee->bullet4 != "")
        $tileCode .= '<li>' . $employee->bullet4 . '</li>';
    if ($employee->bullet5 != "")
        $tileCode .= '<li>' . $employee->bullet5 . '</li>';

    $tileCode .=        '</ul>'
    .               '</div>';

    return $tileCode;
    }

function drawEmployeeContact($employee)
{
    $name = $employee->First . ' ' . $employee->Last;
    $empImage = site_url() . $employee->picture;
    $tileCode = '';

    $tileCode .=        '<div class="pop_line">'
        .                 '<div class="media media--2x3">'
        .                       '<ul style="list-style-type:none">'
        .                           '<li style="list-style-type:none">'
        .                               '<div>'
        .                                   '<div><img class="pop--image" alt="' . $name . '" src="' . $empImage . '" class="lazyautosizes lazyloaded"></div>'
        .                               '</div>'
        .                           '</li>'
        .                           '<li style="list-style-type:none">'
        .                               '<div>'
        .                                   '<div>Email:' . $employee->email . '</div>'
        .                                   '<div>Mobile:' . $employee->phonemobile . '</div>';

                                            if ($employee->skype != "")
                                                 $tileCode .= '<div>Skype:' . $employee->skype . '</div>';
    $tileCode .=                         '</div>'
        .                           '</li>'
        .                       '</ul>'
        .                   '</div>'
        .               '</div>';

    return $tileCode;
}


add_action('wp_ajax_get_team_members', 'get_team_members');
add_action('wp_ajax_nopriv_get_team_members', 'get_team_members');
