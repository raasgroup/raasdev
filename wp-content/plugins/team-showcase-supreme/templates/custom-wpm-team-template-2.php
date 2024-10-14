<?php
/*
Template Name: Custom WPM Team Template
*/
?>

<?php get_header(); ?>

<?php
wp_enqueue_script('jquery');
$font_awesome = wpm_6310_get_option('wpm_6310_font_awesome_status');
if ($font_awesome != 1) {
    wp_enqueue_style('wpm-font-awesome-all', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
}

$member_table = $wpdb->prefix . 'wpm_6310_member';
$members = $wpdb->get_row("SELECT * FROM $member_table WHERE post_id='{$post->ID}'", ARRAY_A);

//Fetch CSS data from table
$template_table = $wpdb->prefix . 'wpm_6310_template';
$styledata = $wpdb->get_row($wpdb->prepare("SELECT * FROM $template_table WHERE name = %s ", esc_attr($members['template_id'])), ARRAY_A);
$css = explode("!!##!!", $styledata['css']);
$key = explode(",", $css[0]);
$value = explode("||##||", $css[1]);
$cssData = array_combine($key, $value);

$text_array = array(
    'T', 'h', 'i', 's', ' ', 't', 'e', 'm', 'p', 'l', 'a', 't', 'e', ' ', 'i', 's', ' ', 'a', 'v', 'a', 'i', 'l', 'a', 'b', 'l', 'e', ' ', 'o', 'n', ' ', 't', 'h', 'e', ' ', 'p', 'r', 'o', ' ', 'v', 'e', 'r', 's', 'i', 'o', 'n', ' ', 'o', 'n', 'l', 'y', '.'
  );
?>
<style>
     .wpm-6310-details-wrapper{
        display: flex;
        margin: 0 auto;
    }
    .wpm-6310-details-content {
        flex: 1 1 100%;
    }
    .wpm-6310-details-content-pro {
        float: left;
        width: 100%;
        text-align: center;
        color: red;
        font-size: 1.3rem;
        margin: 2rem 0 3rem;
    }
</style>
<section>
    <div class="container">
        <div class="row">
            <div class="wpm-6310-details-wrapper">
                <div class="wpm-6310-details-content">
                    <?php

                    if (is_user_logged_in()) {
                        // Get the current user object
                        $current_user = wp_get_current_user();

                        // Check if the user has the "editor" role
                        if (!in_array('editor', $current_user->roles) && !in_array('administrator', $current_user->roles)) {
                            echo "<div class='wpm-6310-details-content-pro'>" . implode('', $text_array) . "</div>";
                            get_footer();
                            return;
                        } else {
                            echo "<div class='wpm-6310-details-content-pro'>" . implode('', $text_array) . " Only the Administrator or Editor can view this page as demo.</div>";
                        }
                    } else {
                        echo "<div class='wpm-6310-details-content-pro'>" . implode('', $text_array) . "</div>";
                        get_footer();
                        return;
                    }
                    ?>
                    <div class="wpm-6310-details-content-header">
                        <div class="wpm-6310-details-content-header-color">
                            <div class="wpm-6310-details-content-header-padding">
                                <div class="wpm-6310-details-content-header-img">
                                    <img src="<?php echo esc_attr($members['thumbnail']) ?>" alt="<?php echo esc_attr($members['name']) ?>">
                                </div>
                                <div class="wpm-6310-details-content-header-info">
                                    <div>
                                        <?php
                                        if ($cssData['top_text']) {
                                        ?>
                                            <div class="wpm-6310-details-content-header-dummy-text"><?php echo wpm_6310_replace($cssData['top_text']); ?></div>
                                        <?php } ?>
                                        <div class="wpm-6310-details-content-header-name"><?php echo wpm_6310_multi_language_get('name', $members['name'], $members['id']); ?></div>
                                        <div class="wpm-6310-details-content-header-designation"><?php echo wpm_6310_multi_language_get('designation', $members['designation'], $members['id']); ?></div>
                                        <div class="wpm-6310-details-content-header-social-icon">
                                            <?php
                                            $icon_table = $wpdb->prefix . 'wpm_6310_icons';
                                            if (isset($cssData['social_status']) && ($members['iconids'] != '' || $members['iconurl'] != '')) {
                                                $iconUrl = explode("||||", $members['iconurl']);
                                                $iconIds = explode(",", $members['iconids']);
                                                if ($iconIds && $iconUrl) {
                                                    for ($i = 0; $i < count($iconUrl); $i++) {

                                                        if ($iconIds[$i] != "" && $iconUrl[$i] != "") {
                                                            $selIcon = $wpdb->get_row("SELECT * FROM $icon_table WHERE id={$iconIds[$i]}", ARRAY_A);
                                                            if ($selIcon) {
                                                                echo "<a " . wpm_6310_external_link($iconUrl[$i]) . "><i class='" . esc_attr($selIcon['class_name']) . "'></i></a>";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wpm-6310-details-content-about-me">
                        <?php
                        if ($cssData['details_text']) {
                        ?>
                            <div class="wpm-6310-details-content-about-me-text"><?php echo wpm_6310_replace($cssData['details_text']); ?></div>
                            <div class="wpm-6310-heading-inner">
                                <div class="wpm-6310-heading-line"></div>
                            </div>
                        <?php } ?>
                        <div class="wpm-6310-details-content-about-me-details">
                            <?php
                            if (function_exists('icl_t')) {
                                $members['profile_details'] = icl_t('team-showcase-supreme', "{$members['id']}. details: Profile Details", $members['profile_details']);
                            }
                            $dd = wpm_6310_replace($members['profile_details']);
                            $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                            $trans = array_flip($trans);
                            echo nl2br(strtr($dd, $trans));
                            ?>
                        </div>

                        <div class="wpm-6310-details-content-others">
                            <?php
                            if (isset($cssData['technical_skill_status'])) {
                            ?>
                                <div class="wpm-6310-details-content-others-skill">
                                    <div class="wpm-6310-details-content-others-skill-heading"><?php echo wpm_6310_replace($cssData['technical_skill']); ?></div>
                                    <?php
                                    if ($members['skills']) {
                                        $skills = explode("####||||####", $members['skills']);
                                        $skl = 1;
                                        foreach ($skills as $skill) {
                                            if ($skill) {
                                                if ($skl > 2) break;
                                                $skill = explode("||||", $skill);
                                                if (!$skill || count($skill) < 2) continue;
                                    ?>
                                                <div class='wpm_6310_skills_label'><?php echo wpm_6310_multi_language_get('skills', $skill[0]); ?></div>
                                                <div class="wpm_6310_skills_prog">
                                                    <div class="wpm_6310_fill" data-progress-animation="<?php echo esc_attr($skill[1]) ?>%" data-appear-animation-delay="400" style="width: <?php echo wpm_6310_replace(esc_attr($skill[1])) ?>%;">
                                                        <div class="wpm-6310-tooltip-percent"><?php echo wpm_6310_replace(esc_attr($skill[1])) ?>%</div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                            $skl++;
                                        }
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            if (isset($cssData['contact_info_status'])) {
                            ?>
                                <div class="wpm-6310-details-content-others-contact">
                                    <div class="wpm-6310-details-content-others-contact-heading"><?php echo wpm_6310_replace($cssData['contact_info']); ?></div>
                                    <?php
                                    $str = "";
                                    if ($members['contact_info']) {
                                        $contacts = explode("####||||####", $members['contact_info']);
                                        if ($contacts) {
                                            foreach ($contacts as $contact) {
                                                $contact = explode("||||", $contact);
                                                $contact1 = trim($contact[1]);
                                                $dataAttr = '';
                                                $dataClass = '';
                                                if (filter_var($contact1, FILTER_VALIDATE_EMAIL)) {
                                                    $dataAttr = "wpm-data-custom-field='mailto:" . esc_attr($contact1) . "'";
                                                    $dataClass = ' wpm-6310-custom-field-mail-link-class';
                                                } else if (filter_var($contact1, FILTER_VALIDATE_URL)) {
                                                    $contact2 = wpm_6310_validate_profile_url($contact1);
                                                    $dataAttr = "wpm-data-custom-field='" . esc_attr($contact2) . "'";
                                                    $dataClass = ' wpm-6310-custom-field-mail-link-class';
                                                } else if (strtolower(substr($contact1, 0, 4)) == 'tel:') {
                                                    $dataAttr = "wpm-data-custom-field='" . esc_attr($contact1) . "'";
                                                    $dataClass = ' wpm-6310-custom-field-mail-link-class';
                                                    $contact1 = trim(substr($contact1, 4));
                                                } else if (strtolower(substr($contact1, 0, 6)) == 'skype:') {
                                                    $dataAttr = "wpm-data-custom-field='" . esc_attr($contact1) . "'";
                                                    $dataClass = ' wpm-6310-custom-field-mail-link-cls';
                                                    $contact1 = explode("?", trim(substr($contact1, 6)))[0];
                                                }
                                                $str .= "<div class='wpm-custom-fields-list" . esc_attr($dataClass) . "' {$dataAttr}><div class='wpm-custom-fields-list-label'>" . wp_kses_post(str_replace("\\", "", $contact[0])) . "</div> <div class='wpm-custom-fields-list-content'>" . esc_attr($contact1) . "</div></div>";
                                            }
                                        }
                                    }
                                    if ($str) {
                                        $str = "<div class='wpm-custom-fields-'>{$str}</div>";
                                    }
                                    echo $str;
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .wpm-6310-details-content {
        box-sizing: border-box;
        padding-left: <?php echo esc_attr($cssData['template_left_right_padding']) ?>px;
        padding-right: <?php echo esc_attr($cssData['template_left_right_padding']) ?>px;
    }
    .wpm-6310-details-content * {
        box-sizing: border-box;
    }
    .wpm-6310-details-content-header {
        background-image: url('<?php echo $cssData['top_text_bg_img'] ?>');
        background-size: cover;
        width: 100%;
        float: left;
    }
    .wpm-6310-details-content-header-color {
        display: flex;
        background-color: <?php echo $cssData['top_text_bg_color'] ?>;
        width: 100%;
        height: auto;
        align-items: center;
    }
    .wpm-6310-details-content-header-padding {
        display: flex;
        align-items: center;
        float: left;
        width: 100%;
        height: 100%;
        padding: 50px 0 30px;
    }
    .wpm-6310-details-content-header-img {
        width: <?php echo esc_attr($cssData['template_left_width']) ?>%;
        float: left;
        text-align: center;
    }
    .wpm-6310-details-content-header-img img {
        width: 80%;
        height: auto;
    }
    .wpm-6310-details-content-header-info {
        width: <?php echo 100 - esc_attr($cssData['template_left_width']); ?>%;
        float: left;
    }
    .wpm-6310-details-content-header-dummy-text {
        color: <?php echo $cssData['top_text_color'] ?>;
        font-weight: 600;
        font-size: <?php echo $cssData['top_text_font_size_desktop'] ?>px;
        line-height: <?php echo $cssData['top_text_font_size_desktop'] ? $cssData['top_text_font_size_desktop'] * 1.20 : 30 ?>px;
        margin-bottom: 1rem;
    }
    .wpm-6310-details-content-header-name {
        color: <?php echo $cssData['title_color'] ?>;
        font-size: <?php echo $cssData['title_font_size_desktop'] ?>px;
        font-weight: <?php echo $cssData['title_font_weight'] ?>;
        line-height: <?php echo $cssData['title_font_size_desktop'] ? $cssData['title_font_size_desktop'] * 1.20 : 0 ?>px;
        margin-bottom: 5px;
    }
    .wpm-6310-details-content-header-designation {
        color: <?php echo $cssData['designation_color'] ?>;
        font-size: <?php echo $cssData['designation_font_size_desktop'] ?>px;
        font-weight: <?php echo $cssData['designation_font_weight'] ?>;
        line-height: <?php echo $cssData['designation_font_size_desktop'] ? $cssData['designation_font_size_desktop'] * 1.20 : 0 ?>px;
    }
    .wpm-6310-details-content-header-social-icon {
        width: 100%;
        float: left;
        margin-top: 1rem;
    }
    .wpm-6310-details-content-header-social-icon a {
        display: inline-block;
        color: <?php echo $cssData['social_color'] ?>;
        font-size: <?php echo $cssData['social_font_size_desktop'] ?>px;
        width: <?php echo $cssData['social_font_size_desktop'] ? $cssData['social_font_size_desktop'] * 1.10 : $cssData['social_font_size_desktop'] ?>px;
        height: <?php echo $cssData['social_font_size_desktop'] ? $cssData['social_font_size_desktop'] * 1.10 : $cssData['social_font_size_desktop'] ?>px;
        margin-right: 10px;
    }
    .wpm-6310-details-content-header-social-icon a:hover {
        color: <?php echo $cssData['social_hover_color'] ?>;
    }
    a[tooltip-href] {
        cursor: pointer;
    }
    .wpm-6310-tooltip:hover:after {
        display: -webkit-flex;
        display: flex;
        -webkit-justify-content: center;
        justify-content: center;
        background: rgba(0, 119, 181, 1);
        border-radius: 5px;
        color: #fff;
        content: attr(tooltip-href);
        margin: -70px 5px 0;
        font-size: 14px;
        line-height: 25px;
        padding: 8px 10px;
        position: absolute;
        z-index: 999;
        min-width: 140px;
    }
    .wpm-6310-details-content-about-me {
        float: left;
        width: 100%;
        margin-top: 60px;
        margin-bottom: 20px;
    }
    .wpm-6310-details-content-about-me-text {
        float: left;
        width: 100%;
        text-align: center;
        font-size: <?php echo $cssData['details_text_font_size_desktop'] ?>px;
        line-height: <?php echo $cssData['details_text_font_size_desktop'] ? $cssData['details_text_font_size_desktop'] * 1.30 : 0 ?>px;
        color: <?php echo $cssData['details_text_color'] ?>;
        font-weight: 600;
    }
    .wpm-6310-heading-inner {
        float: left;
        width: 100%;
    }
    .wpm-6310-heading-line {
        height: 10px;
        width: 10px;
        border-radius: 50%;
        border: 2px solid <?php echo $cssData['details_text_line_color']; ?>;
        margin: 0 auto;
        position: relative;
    }
    .wpm-6310-heading-line::before {
        content: "";
        height: 2px;
        width: 90px;
        background-color: <?php echo $cssData['details_text_line_color']; ?>;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 8px;
    }
    .wpm-6310-heading-line::after {
        content: "";
        height: 2px;
        width: 90px;
        background-color: <?php echo $cssData['details_text_line_color']; ?>;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 8px;
    }
    .wpm-6310-details-content-about-me-details {
        width: 100%;
        float: left;
        color: <?php echo $cssData['details_paragraph_color']; ?>;
        font-size: <?php echo $cssData['details_paragraph_font_size_desktop'] ?>px;
        line-height: <?php echo $cssData['details_paragraph_font_size_desktop'] ? $cssData['details_paragraph_font_size_desktop'] * 1.50 : 0 ?>px;
        margin-top: 2rem;
    }
    .wpm-6310-details-content-others {
        width: 100%;
        float: left;
        margin-top: 3rem;
    }
    .wpm-6310-details-content-others-skill-heading {
        float: left;
        width: 100%;
        margin-bottom: 1rem;
        font-weight: <?php echo $cssData['technical_skill_font_weight']; ?>;
        color: <?php echo $cssData['technical_skill_color']; ?>;
        font-size: <?php echo $cssData['technical_skill_font_size_desktop'] ?>px;
        line-height: <?php echo $cssData['technical_skill_font_size_desktop'] ? $cssData['technical_skill_font_size_desktop'] * 1.30 : 0 ?>px;
    }
    .wpm-6310-details-content-others-skill,
    .wpm-6310-details-content-others-contact {
        float: left;
        width: 50%;
        padding-right: 100px;

    }
    .wpm_6310_skills_label {
        color: <?php echo $cssData['technical_skill_label_color']; ?>;
        font-size: <?php echo $cssData['technical_skill_label_font_size_desktop'] ?>px;
        line-height: <?php echo $cssData['technical_skill_label_font_size_desktop'] ? $cssData['technical_skill_label_font_size_desktop'] * 1.30 : 0 ?>px;
        text-transform: capitalize;
        font-weight: 600;
        margin-bottom: .2rem;
        text-align: left;
        display: block;
        padding-left: 5px;
    }
    .wpm_6310_skills_prog {
        flex: 1;
        height: <?php echo $cssData['technical_skill_progress_bar_height']; ?>px;
        margin-bottom: 6px;
        border-radius: <?php echo $cssData['technical_skill_progress_bar_height']; ?>px;
        border: 1px solid <?php echo $cssData['technical_skill_progress_bar_border_color']; ?>;
        background-color: #FFF;
        box-shadow: none;
        -o-box-shadow: none;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-sizing: border-box;
        margin-bottom: 15px;
        cursor: pointer;
    }
    .wpm_6310_fill {
        float: left;
        background-color: <?php echo $cssData['technical_skill_progress_bar_color']; ?>;
        height: 100%;
        background-size: 20px 20px;
        position: relative;
        border-radius: <?php echo $cssData['technical_skill_progress_bar_height']; ?>px;
    }
    .wpm-6310-tooltip-percent {
        position: absolute;
        width: 50px;
        background-color: <?php echo $cssData['technical_skill_progress_bar_color']; ?>;
        color: #fff;
        height: 25px;
        line-height: 25px;
        text-align: center;
        right: -17px;
        top: -35px;
        display: none;
        border-radius: 5px;
        font-weight: 400;
        font-size: 13px;
        border-radius: 2px;
        transition: all .33s;
    }
    .wpm-6310-tooltip-percent::after {
        position: absolute;
        content: '';
        height: 0;
        border-left: 12px solid transparent;
        border-right: 12px solid transparent;
        border-top: 12px solid <?php echo $cssData['technical_skill_progress_bar_color']; ?>;
        top: 22px;
        right: 12px;
        z-index: 1;
    }
    .wpm_6310_skills_prog:hover .wpm-6310-tooltip-percent {
        display: block
    }
    .wpm-6310-details-content-others-contact-heading {
        float: left;
        width: 100%;
        margin-bottom: 1rem;
        font-weight: <?php echo $cssData['contact_info_font_weight']; ?>;
        color: <?php echo $cssData['contact_info_color']; ?>;
        font-size: <?php echo $cssData['contact_info_font_size_desktop'] ?>px;
        line-height: <?php echo $cssData['contact_info_font_size_desktop'] ? $cssData['contact_info_font_size_desktop'] * 1.30 : 0 ?>px;
    }
    .wpm-custom-fields-list {
        font-size: 14px;
        text-align: left;
        line-height: 20px;
        min-height: 20px;
        float: left;
        width: 100%;
        -moz-transition-duration: 0.4s;
        -o-transition-duration: 0.4s;
        -webkit-transition-duration: 0.4s;
        transition-duration: 0.4s;
        margin-bottom: .7rem;
        cursor: pointer;
    }
    .wpm-custom-fields-list-label {
        font-size: <?php echo $cssData['contact_info_icon_desktop_font_size'] ?>px;
        line-height: <?php echo $cssData['contact_info_icon_desktop_font_size'] ? $cssData['contact_info_icon_desktop_font_size'] * 1.20 : 0 ?>px;
        color: <?php echo $cssData['contact_info_icon_color'] ?>;
        font-weight: 100;
        text-transform: none;
        display: inline-block;
    }
    .wpm-custom-fields-list-content {
        font-size: <?php echo $cssData['contact_info_text_desktop_font_size'] ?>px;
        line-height: <?php echo $cssData['contact_info_text_desktop_font_size'] ? $cssData['contact_info_text_desktop_font_size'] * 1.20 : 0 ?>px;
        color: <?php echo $cssData['contact_info_text_color'] ?>;
        font-weight: 500;
        text-transform: none;
        display: inline-block;
        word-break: break-all;
    }
    @media only screen and (max-width: 991px) {
        .wpm-6310-details-content-header {
            overflow: visible;
            height: auto;
        }
        .wpm-6310-details-content-header-color {
            display: block;
            padding: 0;
            height: 100%;
        }
        .wpm-6310-details-content-header-img,
        .wpm-6310-details-content-header-info {
            width: 100%;
        }
        .wpm-6310-details-content-header-info {
            margin-top: 50px;
            padding-left: 15px;
            padding-right: 15px;
            text-align: center;
            padding-bottom: 30px;
        }
        .wpm-6310-details-content-header-padding{
            display: block;
        }
        .wpm-6310-details-content-header-dummy-text {
            margin-bottom: 1rem;
            font-size: <?php echo esc_attr($cssData['top_text_font_size_mobile']) ?>px;
            line-height: <?php echo $cssData['top_text_font_size_mobile'] ? esc_attr($cssData['top_text_font_size_mobile']) * 1.20 : 0 ?>px;
        }
        .wpm-6310-details-content-header-name {
            font-size: <?php echo esc_attr($cssData['title_font_size_mobile']) ?>px;
            line-height: <?php echo $cssData['title_font_size_mobile'] ? esc_attr($cssData['title_font_size_mobile']) * 1.20 : 0 ?>px;
        }
        .wpm-6310-details-content-header-designation {
            font-size: <?php echo esc_attr($cssData['designation_font_size_mobile']) ?>px;
            line-height: <?php echo $cssData['designation_font_size_mobile'] ? esc_attr($cssData['designation_font_size_mobile']) * 1.20 : 0 ?>px;
        }
        .wpm-6310-details-content-header-social-icon a {
            font-size: <?php echo esc_attr($cssData['social_font_size_mobile']) ?>px;
            width: <?php echo $cssData['social_font_size_mobile'] ? esc_attr($cssData['social_font_size_mobile']) * 1.10 : 0 ?>px;
            height: <?php echo $cssData['social_font_size_mobile'] ? esc_attr($cssData['social_font_size_mobile']) * 1.10 : 0 ?>px;
        }
        .wpm-6310-details-content-about-me-text {
            font-size: <?php echo esc_attr($cssData['details_text_font_size_mobile']) ?>px;
            line-height: <?php echo $cssData['details_text_font_size_mobile'] ? esc_attr($cssData['details_text_font_size_mobile']) * 1.30 : 0 ?>px;
        }
        .wpm-6310-details-content-about-me-details {
            font-size: <?php echo esc_attr($cssData['details_paragraph_font_size_mobile']) ?>px;
            line-height: <?php echo $cssData['details_paragraph_font_size_mobile'] ? esc_attr($cssData['details_paragraph_font_size_mobile']) * 1.50 : 0 ?>px;
        }
        .wpm-6310-details-content-others-skill-heading {
            font-size: <?php echo esc_attr($cssData['technical_skill_font_size_mobile']) ?>px;
            line-height: <?php echo $cssData['technical_skill_font_size_mobile'] ? esc_attr($cssData['technical_skill_font_size_mobile']) * 1.30 : 0 ?>px;
        }
        .wpm_6310_skills_label {
            font-size: <?php echo esc_attr($cssData['technical_skill_label_font_size_mobile']) ?>px;
            line-height: <?php echo $cssData['technical_skill_label_font_size_mobile'] ? esc_attr($cssData['technical_skill_label_font_size_mobile']) * 1.30 : 0 ?>px;
        }
        .wpm-6310-details-content-others-contact-heading {
            font-size: <?php echo esc_attr($cssData['contact_info_font_size_mobile']) ?>px;
            line-height: <?php echo $cssData['contact_info_font_size_mobile'] ? esc_attr($cssData['contact_info_font_size_mobile']) * 1.30 : 0 ?>px;
        }
        .wpm-6310-details-content-about-me-details,
        .wpm-6310-details-content-others-skill,
        .wpm-6310-details-content-others-contact {
            width: 100%;
            padding-left: 10px;
            padding-right: 10px;
        }
        .wpm-6310-details-content-others-contact {
            margin-top: 1rem;
        }
        .wpm-custom-fields-list-label {
            font-size: <?php echo esc_attr($cssData['contact_info_icon_mobile_font_size']) ?>px;
            line-height: <?php echo $cssData['contact_info_icon_mobile_font_size'] ? esc_attr($cssData['contact_info_icon_mobile_font_size']) * 1.20 : 0 ?>px;
        }
        .wpm-custom-fields-list-content {
            font-size: <?php echo esc_attr($cssData['contact_info_text_mobile_font_size']) ?>px;
            line-height: <?php echo $cssData['contact_info_text_mobile_font_size'] ? esc_attr($cssData['contact_info_text_mobile_font_size']) * 1.20 : 0 ?>px;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        jQuery('.wpm-6310-details-content-header').css({
            height: jQuery('.wpm-6310-details-content-header').height() + 'px'
        });
    })
</script>
<?php get_footer(); ?>