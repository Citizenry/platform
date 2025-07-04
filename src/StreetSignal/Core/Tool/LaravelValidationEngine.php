<?php

namespace StreetSignal\Core\Tool;

/**
 * StreetSignal Core Laravel Validation Tool
 *
 * @author     StreetSignal Team <team@streetsignal.com>
 * @package    StreetSignal\Core
 * @copyright  2014 StreetSignal
 * @license    https://www.gnu.org/licenses/agpl-3.0.html
 *             GNU Affero General Public License Version 3 (AGPL3)
 */

use StreetSignal\Contracts\ValidationEngine;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\Validator;

class LaravelValidationEngine implements ValidationEngine
{
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $translator;

    /**
     * @var \Illuminate\Validation\Factory
     */
    private $validatorFactory;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var array
     */
    private $fullData = [];

    /**
     * @var array
     */
    private $rules = [];

    /**
     * @var array
     */
    private $messages = [];

    /**
     * @var \Illuminate\Validation\Validator
     */
    private $validator;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var mixed
     */
    private $currentFieldValue;

    public function __construct(Translator $translator, ValidatorFactory $validatorFactory)
    {
        $this->translator = $translator;
        $this->validatorFactory = $validatorFactory;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData($key = null)
    {
        if ($key === null) {
            return $this->data;
        }

        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return null;
    }

    public function setFullData(array $fullData)
    {
        $this->fullData = $fullData;
        return $this;
    }

    public function getFullData($key = null)
    {
        if ($key === null) {
            return $this->fullData;
        }

        if (array_key_exists($key, $this->fullData)) {
            return $this->fullData[$key];
        }

        return null;
    }

    public function rules($field, $rules)
    {
        if (!isset($this->rules[$field])) {
            $this->rules[$field] = [];
        }
        
        foreach ($rules as $rule) {
            if (is_array($rule)) {
                $ruleName = $rule[0];
                $params = isset($rule[1]) ? $rule[1] : [];
                
                // Handle custom validation methods
                if (is_array($ruleName) && count($ruleName) === 2) {
                    // This is a custom validation method like [[$this, 'checkValues'], [':value', ':fulldata']]
                    $object = $ruleName[0];
                    $method = $ruleName[1];
                    
                    // Call the custom validation method
                    $result = call_user_func_array([$object, $method], $this->resolveParams($params));
                    
                    // If validation fails, the method should have already added errors
                    if ($result === false) {
                        continue;
                    }
                } else {
                    // Standard validation rule
                    if (!empty($params)) {
                        $resolvedParams = $this->resolveParams($params);
                        $this->rules[$field][] = $ruleName . ':' . implode(',', array_slice($resolvedParams, 1));
                    } else {
                        $this->rules[$field][] = $ruleName;
                    }
                }
            } else {
                // Simple string rule
                $this->rules[$field][] = $rule;
            }
        }
        
        return $this;
    }

    public function rule($field, $rule, $params = [])
    {
        if (!isset($this->rules[$field])) {
            $this->rules[$field] = [];
        }
        
        if (is_array($params) && !empty($params)) {
            $this->rules[$field][] = $rule . ':' . implode(',', $params);
        } else {
            $this->rules[$field][] = $rule;
        }
        
        return $this;
    }

    public function check()
    {
        $this->validator = $this->validatorFactory->make(
            $this->data,
            $this->rules,
            $this->messages
        );

        if ($this->validator->fails()) {
            $this->errors = $this->validator->errors()->toArray();
            return false;
        }

        return true;
    }

    public function errors($field = null, $default = null)
    {
        if ($field === null) {
            return $this->errors;
        }

        return isset($this->errors[$field]) ? $this->errors[$field] : $default;
    }

    public function error($field, $error, $params = [])
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        
        $message = $this->translator->get("validation.$error", $params);
        $this->errors[$field][] = $message;
        
        return $this;
    }

    public function bind($key, $value)
    {
        // For compatibility with Kohana validation
        if ($key === ':fulldata') {
            $this->setFullData($value);
        }
        
        return $this;
    }

    public function getTranslationCallback()
    {
        return function ($file, $field, $error = null) {
            if ($error) {
                return $this->translator->has("$file.$field.$error") ?
                    $this->translator->get("$file.$field.$error") : false;
            } else {
                return $this->translator->has("$file.$field") ?
                    $this->translator->get("$file.$field") : false;
            }
        };
    }

    /**
     * Resolve Kohana-style validation parameters
     */
    private function resolveParams($params)
    {
        $resolved = [];
        
        foreach ($params as $param) {
            switch ($param) {
                case ':value':
                    $resolved[] = $this->getCurrentFieldValue();
                    break;
                case ':fulldata':
                    $resolved[] = $this->fullData;
                    break;
                case ':validation':
                    $resolved[] = $this;
                    break;
                default:
                    $resolved[] = $param;
                    break;
            }
        }
        
        return $resolved;
    }

    /**
     * Get the current field value being validated
     */
    private function getCurrentFieldValue()
    {
        // This will be set during validation processing
        return $this->currentFieldValue ?? null;
    }

    /**
     * Set the current field value for parameter resolution
     */
    public function setCurrentFieldValue($value)
    {
        $this->currentFieldValue = $value;
        return $this;
    }
}