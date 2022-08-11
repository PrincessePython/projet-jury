<?php

namespace App\Service;

use DateTimeImmutable;

class JWTService
{
    // generer le JWT token 

    public function generate(array $header, array $payload, string $secret, int $validity = 1200): string
    {
        if ($validity > 0) {
            // return "";
            $now = new DateTimeImmutable();
    
            //pour savoir la date d'expiration 
            $exp = $now->getTimestamp() + $validity;
    
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;
        }
        

        // encoder les donnes en base 64 (doc du jwt)
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // Nettoyage des valeurs encodées (retirer les +, /, =) sinon les erreurs
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);


        // generation d'une signature
        $secret = base64_encode($secret);

        $signature = hash_hmac('sha256', $base64Header.'.'.$base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);
        $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        // creation du token
        $jwt = $base64Header . '.' . $base64Payload . '.'. $base64Signature;

        return $jwt;

    }

    // verification si token est valide (correctement formé)

    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',    // les 3 information doivent correspondre pour avoir le token valide
            $token
        ) === 1;
    }

    // Verification si token est expiré ou pas
    // 1. recuperation de header
    public function getHeader(string $token): array
    {
        // démonter le token (séparer chaque un des ses points)
        $array = explode('.', $token);

        // décode le header
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    // 2. recuperation de payload
    public function getPayload(string $token): array
    {
        // démonter le token (séparer chaque un des ses points)
        $array = explode('.', $token);

        // décode le payload
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }


    // 3. verification si le token a experé ou pas
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);
        $now = new DateTimeImmutable() ;
        // dd($payload);
        // dd($now->getTimestamp());
        // dd($payload['exp'] < $now->getTimestamp());

        return $payload['exp'] < $now->getTimestamp();
    }

    // 4. vérification si le token n'a pas été manipulé par les personnes tiers, par exaple (la signature)  
    public function check(string $token, string $secret)
    {
        // récup. header et le payload
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // régenerer le token pour verifier la signature
        $verfToken = $this->generate($header, $payload, $secret, 0);
        
        return $token === $verfToken;
    }


}


