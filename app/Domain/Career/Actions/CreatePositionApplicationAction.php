<?php

namespace App\Domain\Career\Actions;

use App\Domain\Career\Models\Position;

class CreatePositionApplicationAction
{

    public function __construct(
    )
    {

    }

    public function handle(array $validatedData, string $rules, Position $position): void
    {
        $cvName = $validatedData["cv"]->getClientOriginalName();
        $timeinmd5 = md5(time());
        $cvPath = $validatedData["cv"]->storeAs('protected/cvs/'.$timeinmd5, $cvName);
        $position->applicants()->create([
            'name' => $validatedData["name"],
            'email' => $validatedData["email"],
            'mobile' => $validatedData["mobile"],
            'cv_url' => $cvPath,
            'wage' => $validatedData["wage"],
            'introduction' => $validatedData["introduction"],
            'residence' => $validatedData["residence"],
            'birthdate' => $validatedData["birthdate"],
            'position_specific_questions' => $rules,
            'status' => 'pending',
        ]);
    }

}
