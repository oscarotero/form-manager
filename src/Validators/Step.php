<?php
declare(strict_types = 1);

namespace FormManager\Validators;

class Step
{
    private $options;

    public function __construct(array $options = [])
    {
        $this->options = $options + [
            'message' => 'This number is not valid.',
        ];
    }

    public function __invoke($input, $context)
    {
        $step = (float) $this->options['step'];
        $input = (float) $input;

        if (!$step || !$input) {
            return;
        }

        if ($input % $step) {
            $context->buildViolation($this->options['message'])->addViolation();
        }
    }
}
