<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Stat;
use Illuminate\Support\Facades\DB;

// Я це не знав, до цього завдання. Посидів почитав та поспілкувався з ШІ.
class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $stats = Stat::first();

        if ($stats) {
            $stats->update([
                'projects_count' => $stats->projects_count + 1
            ]);
        } else {
            // Якщо записів в таблиці Stat немає, створити новий рядок
            Stat::create(['projects_count' => 1]);
        }
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
