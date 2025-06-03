<?php
namespace App\Helpers;

use App\Models\Mom;

class MomNumberHelper {

    public static function generateMomNumber($mom_number = '') {
        $date_code = date('Ymd');

        if (!empty($mom_number)) {
            // Check if mom number exists
            $existing = Mom::withTrashed()->where('mom_number', $mom_number)->exists();

            if (!$existing) {
                // Extract date from provided mom number
                $parts = explode('-', $mom_number);

                if (count($parts) === 3) {
                    [$prefix, $provided_date, $provided_number] = $parts;

                    if ($provided_date === $date_code) {
                        // If the date matches today's date and doesn't exist, return it
                        return $mom_number;
                    } else {
                        // Otherwise, increment based on the provided date
                        $latest = Mom::withTrashed()
                            ->where('mom_number', 'like', "MOM-$provided_date-%")
                            ->orderBy('mom_number', 'desc')
                            ->first();

                        $last_number = $latest
                            ? (int)explode('-', $latest->mom_number)[2]
                            : 0;

                        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);

                        return "MOM-$provided_date-$new_number";
                    }
                }
            }
            // If it already exists, fall through to generate a new one for today
        }

        // Default case: generate based on today's date
        do {
            $latest = Mom::withTrashed()
                ->where('mom_number', 'like', "MOM-$date_code-%")
                ->orderBy('mom_number', 'desc')
                ->first();

            $last_number = $latest
                ? (int)explode('-', $latest->mom_number)[2]
                : 0;

            $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);

            $mom_number = "MOM-$date_code-$new_number";

        } while (Mom::withTrashed()->where('mom_number', $mom_number)->exists());

        return $mom_number;
    }
}