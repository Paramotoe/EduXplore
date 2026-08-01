<?php

namespace App\Support;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Pencatat jejak audit terpusat.
 */
class Audit
{
    public static function log(string $action, string $description = '', ?User $actor = null): void
    {
        $actor ??= Auth::user();

        AuditLog::create([
            'user_id'     => $actor?->id,
            'actor_name'  => $actor?->name ?? 'Tamu',
            'actor_role'  => $actor?->role ?? 'guest',
            'action'      => $action,
            'description' => mb_substr($description, 0, 255),
            'ip_address'  => Request::ip(),
        ]);
    }
}
