<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckDateRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $create;

    public function __construct($create)
    {
        $this->create = $create;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $checkCreate = Carbon::create($this->create);
        $end = Carbon::create($value);
        if ($end->diffInDays($checkCreate) <= 3 && $checkCreate <= $end) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'bạn chỉ được phép mượn tối đa 4 ngày. xin cảm ơn';
    }
}
