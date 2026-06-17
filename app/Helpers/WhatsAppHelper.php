<?php

namespace App\Helpers;

class WhatsAppHelper
{
    public static function credentialsLink(string $phone, string $prenom, string $matricule, string $password): string
    {
        $phone = preg_replace('/\s+/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '237' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '237')) {
            $phone = '237' . $phone;
        }
        $message = urlencode("Bonjour $prenom, votre compte est créé.\nMatricule : $matricule\nMot de passe : $password");
        return "https://wa.me/$phone?text=$message";
    }

    public static function messageLink(string $phone, string $texte): string
    {
        $phone = preg_replace('/\s+/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '237' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '237')) {
            $phone = '237' . $phone;
        }
        return "https://wa.me/$phone?text=" . urlencode($texte);
    }
}
