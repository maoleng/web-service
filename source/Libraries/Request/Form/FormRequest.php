<?php

namespace Libraries\Request\Form;

use Libraries\Request\Request;
use Libraries\Response\Response;

abstract class FormRequest extends Request
{

    private array $data;
    private array $errors;

    public function __construct()
    {
        parent::__construct();
        $this->data = $this->only(array_keys($this->rules()));
    }

    public function validated(): array
    {
        $result = [];
        $rules = $this->rules();

        $is_fail = false;
        foreach ($rules as $input_name => $rule) {
            $value = $this->get($input_name);
            if ($rule($value) === false) {
                $is_fail = true;
            } else {
                $result[$input_name] = $value;
            }
        }
        if ($is_fail) {
            response()->json([
                'status' => false,
                'data' => [
                    'message' => $this->errors[0],
                ],
            ], Response::HTTP_BAD_REQUEST);
        }

        return array_merge($result, $this->data);
    }

    public function merge(array $data): void
    {
        $this->data = array_merge($this->data, $data);
    }

    public function fail($message): bool
    {
        $this->errors[] = $message;

        return false;
    }

    abstract public function rules();

}