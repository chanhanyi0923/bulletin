<?php

$dbh = new PDO('mysql:host=localhost;dbname=honor', 'honor', '1qazxsw2');

for ($id = 7050; $id < 7200; $id ++) {
    $sql = "SELECT * FROM `titletb` WHERE `tid` = :id";
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':id', $id);
    $sth->execute();
    $titletb = $sth->fetch(PDO::FETCH_OBJ);

    $sql = "SELECT * FROM `anntb` WHERE `tid` = :id";
    $sth = $dbh->prepare($sql);
    $sth->bindValue(':id', $id);
    $sth->execute();
    $anntb = $sth->fetch(PDO::FETCH_OBJ);

    if (empty($anntb) || empty($titletb)) {
        continue;
    }

    $sql = "INSERT INTO `articles` (`author_id`, `class_id`, `type_id`, `sticky`, `ip`, `hits`, `created_at`, `updated_at`, `title`, `files`, `urls`, `content`) ".
                 "VALUES(:author_id,  :class_id,  :type_id,  :sticky,  :ip,  :hits,  :created_at,  :updated_at,  :title,  :files,  :urls,  :content)";
    $sth = $dbh->prepare($sql);

    $sth->bindValue(':author_id', 1);

$map_class = [
63 => 1,
62 => 2,
64 => 3,
65 => 4,
59 => 5,
60 => 6,
61 => 7
];

    $sth->bindValue(':class_id', $map_class[intval($anntb->userid)]);
    $sth->bindValue(':type_id', intval($titletb->type));
    $sth->bindValue(':sticky', $titletb->up);

$arr_ip = explode('.', $anntb->ip);
$ip = 0;
for ($i = 0; $i < 4; $i ++) {
    $ip = ($ip << 8) + intval($arr_ip[$i]);
}

    $sth->bindValue(':ip', $ip);
    $sth->bindValue(':hits', $titletb->hits);
    $sth->bindValue(
        ':created_at',
        substr($titletb->firsttime, 0, 1) == '0' ? $titletb->posttime : $titletb->firsttime
    );
    $sth->bindValue(':updated_at', $titletb->posttime);
    $sth->bindValue(':title', stripslashes($titletb->subject));

    $files = explode(' ', $anntb->filename);
    $files = json_encode($files);
    $files = $files == '[""]' ? '[]' : $files;
    $sth->bindValue(':files', $files);

    $urls = explode(' ', $anntb->url);
    $urls = json_encode($urls);
    $urls = $urls == '[""]' ? '[]' : $urls;
    $sth->bindValue(':urls', $urls);

    $content = stripslashes($anntb->comment);
    if (strpos($content, '<') === false) {
        $content = nl2br($content);
    }
    $sth->bindValue(':content', $content);
    $sth->execute();
}


