<?php

declare(strict_types=1);

namespace App\Domain\Career\Actions;

use App\Domain\Career\Models\Position;

final class CreatePositionApplicationAction
{
    public function handle(array $validatedData, string $rules, Position $position): void
    {
        $cvName = $validatedData['cv']->getClientOriginalName();
        $timeInMD5 = md5((string) time());
        $cvPath = $validatedData['cv']->storeAs('protected/cvs/'.$timeInMD5, $cvName);
        $position->applicants()->create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'mobile' => $validatedData['mobile'],
            'cv_url' => $cvPath,
            'wage' => $validatedData['wage'],
            'introduction' => $validatedData['introduction'],
            'residence' => $validatedData['residence'],
            'birthdate' => $validatedData['birthdate'],
            'position_specific_questions' => $rules,
            'status' => 'pending',
        ]);
    }
}
