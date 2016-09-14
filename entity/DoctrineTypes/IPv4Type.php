<?php

namespace entity\DoctrineTypes;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class IPv4Type extends Type
{
    const IPV4TYPE = 'ipv4';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $int_ip = intval($value);
        $ip = [0, 0, 0, 0];
        for ($i = 0; $i < 4; $i ++) {
            $ip[3 - $i] = ($int_ip & (0xff << ($i * 8))) >> ($i * 8);
            if ($ip[3 - $i] < 0) {
                $ip[3 - $i] += 0x100;
            }
        }
        return implode('.', $ip);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $arr_ip = explode('.', $value);
        $ip = 0;
        for ($i = 0; $i < 4; $i ++) {
            $ip = ($ip << 8) + intval($arr_ip[$i]);
        }
        return $ip;
    }

    public function getName()
    {
        return self::IPV4TYPE;
    }
}
