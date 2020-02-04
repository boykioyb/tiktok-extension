<?php
header("Host: https://www.tiktok.com/");
$ch = curl_init();
$ip = isset($_GET['ip']) && strlen($_GET['ip']) > 0 ? $_GET['ip'] : get_client_ip();
$params = http_build_query([
    "secUid" => "",
    "id" => "",
    "type" => 5,
    "count" => 30,
    "minCursor" => 0,
    "maxCursor" => 1,
    'shareUid' => "",
    "lang" => 'vi',
    "_signature" => "dkFnEgAgEBL5oTkKZ3J6j3ZBZgAACh8"
]);
curl_setopt($ch, CURLOPT_URL, "https://www.tiktok.com/share/item/list?" . $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'Referer: https://www.tiktok.com/trending/?lang=vi',
    'cookie: _ga=GA1.2.1420542344.1580432930; tt_webid_v2=6787907993712477697; _gid=GA1.2.1630456976.1580697178; ak_bmsc=42FECF952D52AF36CC329B50A8BAD41571ABEA63C91D0000AEC7385EBBAAAB79~pl1qPRq+URO6xvv/ikJMMscLeV53Swbzu/8DLiGtfuDidTu6HK7Uv7tMJghe0Sx2fj3xWke0JLmY52wRAUUfaBLWw58rzxwydJxmiirkjQMcD8lhd8tQ9lsLKtA1nbjmpOiz0R0jz/EKo4tBIOsCeFBlDPliknR0U/zQfhQKaZu/jEXCTVFwbLqO/NcyjOVEcZf6LY9MDN1z6JxTc/Fa57o3n/Xe7ce4kiv1ocAdJlJJJkWhlphcTq5ZbOW4v2IXnM; SLARDAR_WEB_ID=c63fc07d-b19c-4ee9-b3d3-76b089240526; bm_sv=51CC27FF08909E89F98592CCBB9CC2D7~zftz78fMoBcqHNxBaNJ0BRhB61YHILu8QcFS/4l9ADf6SU02ernwD3u3QuYvdXtzzoSG2ZTxOpWcyk6S5nh/Wxg0w+UP6MwGMxfxYyY9zG58e47c/SQ+CBbiFsnOugoa66yvFfWFexNewK6nCLCPRWwd2mjdkWMG5+gu+tGfM/0=',
    "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1",
    "X-Forwarded-For: " . $ip
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$server_output = curl_exec($ch);

curl_close($ch);
print  $server_output;
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}
