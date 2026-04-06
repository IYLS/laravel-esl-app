<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Backfill the category column for existing exercises using the following rules:
     *
     * 1. subtype IN ('99', '991') → 'metacognition'
     *    The store() method defaults to subtype='99' when no subtype input is submitted.
     *    The metacognition form never sends a subtype field (except open_ended which uses
     *    99=Simple and 991=Table style). So all metacognition exercises end up with subtype 99 or 991.
     *
     * 2. exercise_type_id IN (4, 6, 7)  [open_ended, form, poll]  AND subtype NOT IN ('99','991')
     *    AND created_at >= 2026-03-01 → 'engagement'
     *    These types were exclusively accessible via the engagement ("Add engagement") button,
     *    which was introduced in March 2026. Older exercises of the same types were created as
     *    comprehension activities and must keep that category.
     *
     * 3. Everything else → 'comprehension'
     *    Includes all pre-March-2026 open_ended/form/poll exercises and all
     *    drag_and_drop (1), multiple_choice (2), fill_in_the_gaps (3), voice_recognition (5)
     *    with non-metacognition subtypes.
     */
    public function up(): void
    {
        // 1. Metacognition: subtype 99 or 991
        DB::table('exercises')
            ->whereNull('category')
            ->whereIn('subtype', ['99', '991'])
            ->update(['category' => 'metacognition']);

        // 2. Engagement: open_ended (4), form (6), poll (7) created on/after 2026-03-01
        DB::table('exercises')
            ->whereNull('category')
            ->whereIn('exercise_type_id', [4, 6, 7])
            ->where('created_at', '>=', '2026-03-01')
            ->update(['category' => 'engagement']);

        // 3. Comprehension: everything remaining
        //    (includes pre-March-2026 open_ended/form/poll that are not metacognition)
        DB::table('exercises')
            ->whereNull('category')
            ->update(['category' => 'comprehension']);
    }

    public function down(): void
    {
        // Only revert exercises that were null before (i.e. set by this migration).
        // Since we cannot know which were already set, we reset all to null.
        DB::table('exercises')->update(['category' => null]);
    }
};
