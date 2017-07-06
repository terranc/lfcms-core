<?php
error_reporting(1);
$target = __DIR__ . '/../website.com'; // 生产环境web目录
$token = '您在coding填写的hook令牌';
$wwwUser = 'www-data';
$wwwGroup = 'www-data';
$json = json_decode(file_get_contents('php://input'), true);
if (empty($json['token']) || $json['token'] !== $token) {
    exit('error request');
}
$repo = $json['repository']['name'];
$dir = __DIR__ . '/repos/' . $repo;
$cmds = array(
    "cd $dir && git pull",
    "rm -rf $target/* && cp -r $dir/* $target/",
    "chown -R {$wwwUser}:{$wwwGroup} $target/",
);
foreach ($cmds as $cmd) {
    shell_exec($cmd);
}
