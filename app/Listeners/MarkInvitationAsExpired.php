<?php

namespace App\Listeners;

use App\Events\InvitationExpired;
use App\Models\UndanganPengunjung;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MarkInvitationAsExpired
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\InvitationExpired  $event
     * @return void
     */
    public function handle(InvitationExpired $event)
    {
        $invitations = UndanganPengunjung::where('status', 'Menunggu')
                                          ->where('waktu_kembali', '<', now())
                                          ->update(['status' => 'Kadaluarsa']);
    }
}
