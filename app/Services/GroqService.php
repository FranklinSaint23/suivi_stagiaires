<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    private string $apiKey;
    private string $model;
    private const API_URL = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.groq.key', '');
        $this->model  = config('services.groq.model', 'llama-3.3-70b-versatile');
    }

    private function chat(array $messages, int $maxTokens = 1024): string
    {
        $response = Http::withToken($this->apiKey)
            ->timeout(60)
            ->post(self::API_URL, [
                'model'      => $this->model,
                'messages'   => $messages,
                'max_tokens' => $maxTokens,
            ]);

        if ($response->failed()) {
            Log::error('Groq API error', ['body' => $response->body()]);
            $msg = $response->json('error.message', 'Erreur inconnue');
            throw new \Exception("Erreur Groq : {$msg}");
        }

        return $response->json('choices.0.message.content', '');
    }

    public function analyseCv(string $cvText, string $nomComplet, string $filiere): string
    {
        return $this->chat([
            ['role' => 'system', 'content' => 'Tu es un assistant RH expert en analyse de CV pour des stagiaires. Réponds toujours en français.'],
            ['role' => 'user',   'content' =>
                "Analyse ce CV de {$nomComplet} (filière : {$filiere}).\n\n"
                . "=== Contenu du CV ===\n{$cvText}\n=== Fin ===\n\n"
                . "Fournis un résumé structuré avec :\n"
                . "1. **Formation académique**\n"
                . "2. **Compétences techniques**\n"
                . "3. **Expériences**\n"
                . "4. **Points forts**\n"
                . "5. **Adéquation pour le stage** (note /10 et justification)\n\n"
                . "Sois concis et factuel.",
            ],
        ], 1024);
    }

    public function rapportPerformance(array $stagiaire, float $tauxPresence, int $absences, array $stages): string
    {
        $stagesTexte = empty($stages)
            ? 'Aucun stage enregistré'
            : collect($stages)->map(fn($s) => "{$s['theme']} chez {$s['etablissement']}")->join(', ');

        return $this->chat([
            ['role' => 'system', 'content' => 'Tu es un responsable RH rédigeant des rapports officiels de performance de stagiaires. Réponds en français.'],
            ['role' => 'user',   'content' =>
                "Génère un rapport de performance formel pour :\n"
                . "Nom : {$stagiaire['prenom']} {$stagiaire['nom']}\n"
                . "Filière : {$stagiaire['filiere']}\n"
                . "Taux de présence : {$tauxPresence}%\n"
                . "Absences : {$absences}\n"
                . "Stages : {$stagesTexte}\n\n"
                . "Rédige 3-4 paragraphes formels : appréciation générale, assiduité, recommandations, conclusion.",
            ],
        ], 900);
    }

    public function detecterAnomalies(array $stagiairesData): string
    {
        $lignes = collect($stagiairesData)
            ->map(fn($s) => "- {$s['nom']} : {$s['taux']}% de présence, {$s['absences']} absence(s)")
            ->join("\n");

        return $this->chat([
            ['role' => 'system', 'content' => 'Tu es un assistant pour encadrant de stagiaires, spécialisé dans l\'analyse des absences. Réponds en français.'],
            ['role' => 'user',   'content' =>
                "Données de présence des stagiaires :\n{$lignes}\n\n"
                . "Identifie les situations préoccupantes (seuil : moins de 75% de présence). "
                . "Pour chaque cas, indique : niveau d'alerte (Critique/Avertissement), risque, action recommandée. "
                . "Si tout va bien, dis-le clairement.",
            ],
        ], 700);
    }

    public function chatStagiaire(string $message, array $contexte, array $historique = []): string
    {
        $messages = [[
            'role'    => 'system',
            'content' => "Tu es un assistant virtuel bienveillant pour l'application de suivi de stagiaires. "
                . "Tu aides {$contexte['prenom']} {$contexte['nom']} (filière : {$contexte['filiere']}). "
                . "Son taux de présence est de {$contexte['taux_presence']}%. "
                . "Réponds en français, de façon concise (2-4 phrases). "
                . "Tu informes et conseilles mais ne modifies aucune donnée.",
        ]];

        foreach ($historique as $h) {
            $messages[] = ['role' => $h['role'], 'content' => $h['content']];
        }
        $messages[] = ['role' => 'user', 'content' => $message];

        return $this->chat($messages, 512);
    }
}
