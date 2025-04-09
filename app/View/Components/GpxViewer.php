<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use phpGPX\Models\GpxFile;
use phpGPX\phpGPX;

class GpxViewer extends Component
{
    private GpxFile $file;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $gpx = new phpGPX();

        $this->file = $gpx->load(public_path('gpx/6kms_MDF.gpx'));

        foreach ($this->file->tracks as $track) {
            // Statistics for whole track
            $track->stats->toArray();

            foreach ($track->segments as $segment) {
                // Statistics for segment of track
                $segment->stats->toArray();
            }
        }

        return view('components.gpx-viewer');
    }
}
