<?php

namespace App\Notifications;

use App\Models\Visite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VisiteStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(protected Visite $visite) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $statusLabel = \App\Enums\StatutVisite::from($this->visite->statut)->label() ?? $this->visite->statut;
        $url = route('client.visites.index');

        return (new MailMessage)
            ->subject("Mise à jour sur votre demande de visite")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("La demande de visite pour le bien « {$this->visite->bien->titre} » a été mise à jour.")
            ->line("Nouveau statut : {$statusLabel}")
            ->action('Voir mes demandes', $url)
            ->line('Merci d’utiliser BellyImmo.');
    }

    public function toArray($notifiable)
    {
        return [
            'visite_id' => $this->visite->id,
            'bien_id' => $this->visite->bien->id,
            'bien_titre' => $this->visite->bien->titre,
            'statut' => $this->visite->statut,
        ];
    }
}
