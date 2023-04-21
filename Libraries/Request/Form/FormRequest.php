<?php

namespace Libraries\Request\Form;

use Libraries\Request\Request;

abstract class FormRequest extends Request
{

    private array $data;

    public function __construct()
    {
        parent::__construct();
        $this->data = $this->only(array_keys($this->rules()));
        session()->flash('old', $this->data);
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
            redirect()->back();
        }

        return array_merge($result, $this->data);
    }

    public function merge(array $data): void
    {
        $this->data = array_merge($this->data, $data);
    }

    public function fail($message): bool
    {
        $errors = session()->get('errors');
        $errors[] = $message;
        session()->flash('errors', $errors);

        return false;
    }

    abstract public function rules();

}