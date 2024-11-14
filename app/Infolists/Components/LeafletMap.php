<?php

namespace App\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;

class LeafletMap extends Entry
{
    protected string $view = 'infolists.components.leaflet-map';

    protected string|Closure|null $imageUrl = '';

    protected array|Closure|null $coordinates = null;

    public function getImageUrl(): string|null
    {
        return $this->evaluate($this->imageUrl);
    }

    public function imageUrl(string|Closure|null $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getCoordinates(): array|null
    {
        return $this->evaluate($this->coordinates);
    }

    public function coordinates(array|Closure|null $coordinates): static
    {
        $this->coordinates = $coordinates;

        return $this;
    }
}
