<?php

namespace Tests\Feature;

use App\Filament\Admin\Resources\GraveResource;
use App\Filament\Admin\Resources\GraveResource\Pages\CreateGrave;
use App\Filament\Admin\Resources\GraveResource\Pages\ListGraves;
use App\Models\Corpse;
use App\Models\Grave;
use App\Models\User;
use function Pest\Livewire\livewire;

// beforeEach(function () {
//     // $this->actingAs(User::where('role', 'admin')->first());
// });

// it('can list graves', function () {
//     // $graves = Grave::limit(10)->get();
//     // livewire(ListGraves::class)
//     //     ->assertCanSeeTableRecords($graves);
// });

// it('can render page', function () {
//     $this->withoutMiddleware();
//     $this->get(GraveResource::getUrl('create'))->assertSuccessful();
// });

