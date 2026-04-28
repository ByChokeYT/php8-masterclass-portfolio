<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\BusinessProfile;

/**
 * Servicio encargado del renderizado visual de la tarjeta
 */
class CardRenderer {
    
    public function render(BusinessProfile $profile): string {
        $initials = $profile->getInitials();
        $photoHtml = !empty($profile->photo) 
            ? "<img src='{$profile->photo}' class='w-full h-full object-cover rounded-2xl'>" 
            : "<span class='text-2xl font-black' style='color: {$profile->accentColor}'>{$initials}</span>";

        return <<<HTML
        <div class="business-card relative w-[500px] h-[280px] rounded-[2rem] overflow-hidden bg-[#0d1117] border border-white/10 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] transition-all duration-500 hover:scale-[1.02] group"
             style="background: radial-gradient(circle at 10% 10%, {$profile->accentColor}15 0%, transparent 60%), #0d1117;">
            
            <!-- Brillo Holográfico -->
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-1000 pointer-events-none"
                 style="background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.03) 50%, transparent 60%); background-size: 200% 200%; animation: shine 3s infinite;"></div>

            <!-- Patrón Industrial -->
            <div class="absolute top-0 right-0 w-40 h-40 opacity-[0.03] pointer-events-none" 
                 style="background-image: radial-gradient({$profile->accentColor} 2px, transparent 2px); background-size: 10px 10px;"></div>
            
            <div class="p-12 h-full flex flex-col justify-between relative z-10">
                <!-- Header -->
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center border-2 transition-all duration-500 group-hover:rotate-6 overflow-hidden" 
                             style="border-color: {$profile->accentColor}; background: {$profile->accentColor}08">
                            {$photoHtml}
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-white tracking-tighter uppercase leading-none mb-1 whitespace-pre-wrap">{$profile->name}</h2>
                            <div class="flex items-center gap-2">
                                 <div class="h-[1px] w-4" style="background: {$profile->accentColor}"></div>
                                 <p class="text-[10px] font-mono tracking-[0.2em] uppercase opacity-70 whitespace-pre-wrap" style="color: {$profile->accentColor}">{$profile->role}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer / Contact -->
                <div class="grid grid-cols-[1fr,auto] gap-6 items-end">
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-3 text-[10px] text-white/50 font-medium">
                            <i class="ph-bold ph-envelope text-lg" style="color: {$profile->accentColor}"></i>
                            <span class="whitespace-pre">{$profile->email}</span>
                        </div>
                        <div class="flex items-center gap-3 text-[10px] text-white/50 font-medium">
                            <i class="ph-bold ph-phone text-lg" style="color: {$profile->accentColor}"></i>
                            <span class="whitespace-pre">{$profile->phone}</span>
                        </div>
                        <div class="flex items-center gap-3 text-[10px] text-white/50 font-medium">
                            <i class="ph-bold ph-globe text-lg" style="color: {$profile->accentColor}"></i>
                            <span class="whitespace-pre">{$profile->website}</span>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-[11px] font-black text-white tracking-widest uppercase opacity-40 whitespace-pre-wrap">{$profile->company}</p>
                    </div>
                </div>
            </div>

            <!-- Barra Estética -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 w-24 h-1 rounded-full opacity-30" 
                 style="background: {$profile->accentColor}; box-shadow: 0 0 15px {$profile->accentColor}80"></div>
        </div>
HTML;
    }
}
