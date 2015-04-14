<?php
/**
 *
 * @package    test.php
 * @author     Rakesh Shrestha
 * @since      8/4/15 4:13 PM
 * @version    1.0
 */
$arr = array(
    'id_banner'      => 1,
    'name'           => 'The Club',
    'name_seo'       => 'the-club',
    'dt_created'     => '2015-04-07 14:44:23',
    'locale'         => 'en_AU',
    'banners' => [[
        'h1'          => 'I came to run the NY marathon and to my great surprise, I was upgraded to a luxurious double room. A million thanks for this very nice gesture. (1)',
        'h2'          => null,
        'h3'          => 'Phillip, Sydney',
        'h4'          => null,
        'h5'          => null,
        'h6'          => null,
        'description' => null,
        'url_desktop' => 'https://www.tnetnoc.com/HCL/assets/2015/bcm/value_prop/banner.png',
        'url_tablet'  => 'https://www.tnetnoc.com/HCL/assets/2015/bcm/value_prop/banner.png',
        'url_mobile'  => null,
        'tags'        => null,
    ],
    [
        'h1'          => 'I came to run the NY marathon and to my great surprise, I was upgraded to a luxurious double room. A million thanks for this very nice gesture. (1)',
        'h2'          => null,
        'h3'          => 'Phillip, Sydney',
        'h4'          => null,
        'h5'          => null,
        'h6'          => null,
        'description' => null,
        'url_desktop' => 'https://www.tnetnoc.com/HCL/assets/2015/bcm/value_prop/banner.png',
        'url_tablet'  => 'https://www.tnetnoc.com/HCL/assets/2015/bcm/value_prop/banner.png',
        'url_mobile'  => null,
        'tags'        => null,
    ],
    [
        'h1'          => 'I came to run the NY marathon and to my great surprise, I was upgraded to a luxurious double room. A million thanks for this very nice gesture. (1)',
        'h2'          => null,
        'h3'          => 'Phillip, Sydney',
        'h4'          => null,
        'h5'          => null,
        'h6'          => null,
        'description' => null,
        'url_desktop' => 'https://www.tnetnoc.com/HCL/assets/2015/bcm/value_prop/banner.png',
        'url_tablet'  => 'https://www.tnetnoc.com/HCL/assets/2015/bcm/value_prop/banner.png',
        'url_mobile'  => null,
        'tags'        => null,
    ]]
);

echo json_encode($arr);