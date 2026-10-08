<?php

namespace App\Helpers;

class WhatsAppHelper
{
    /**
     * Nettoie et formate un numéro de téléphone pour wa.me (chiffres uniquement, indicatif international).
     */
    public static function cleanPhone(?string $phone): string
    {
        if (!$phone) {
            return '';
        }

        // Supprime tout sauf les chiffres (enlève les espaces, +, -, parenthèses, etc.)
        $digits = preg_replace('/[^0-9]/', '', $phone);

        if (empty($digits)) {
            return '';
        }

        // Si commence par 00 (ex: 00237), on retire 00
        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        }

        // Si commence par un seul 0 local (ex: 0692..., 0233...), on remplace par 237
        if (str_starts_with($digits, '0')) {
            return '237' . substr($digits, 1);
        }

        // Si numéro à 9 chiffres (standard mobile/fixe Cameroun 6xx ou 2xx), on ajoute 237
        if (strlen($digits) === 9) {
            return '237' . $digits;
        }

        return $digits;
    }

    public static function credentialsLink(string $phone, string $prenom, string $matricule, string $password): string
    {
        $clean = self::cleanPhone($phone);
        $message = urlencode("Bonjour $prenom, votre compte StageTrack a été créé avec succès.\nMatricule : $matricule\nMot de passe : $password\nLien de connexion : " . url('/login'));
        return "https://wa.me/$clean?text=$message";
    }

    public static function encadrantCredentialsLink(string $phone, string $nom, string $matricule, string $email, string $password): string
    {
        $clean = self::cleanPhone($phone);
        $message = urlencode("Bonjour $nom, votre compte Encadrant StageTrack a été créé avec succès et est prêt à l'emploi !\nMatricule : $matricule\nEmail : $email\nMot de passe : $password\nLien de connexion : " . url('/login'));
        return "https://wa.me/$clean?text=$message";
    }

    public static function messageLink(string $phone, string $texte): string
    {
        $clean = self::cleanPhone($phone);
        return "https://wa.me/$clean?text=" . urlencode($texte);
    }
}

