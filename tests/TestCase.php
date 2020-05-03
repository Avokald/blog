<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // Note:
    // const can be overridden in subclasses
    // self:: points to TestCase's value, while $this:: to subclasses' value

    /**
     * Fields that would be saved, asserted and validated for existence / nonexistence
     */
    const DATA_FIELDS_FOR_CHECK = [];

    /**
     * Creates array of data with specified field
     * @param array|null $customFields
     * @return array
     */
    protected function initializeCommonData(?array $customFields = null)
    {
        $list = [];
        if (!is_null($customFields)) {
           foreach ($customFields as $field) {
               $list[$field] = [];
           }
        } else {
            foreach ($this::DATA_FIELDS_FOR_CHECK as $field) {
                $list[$field] = [];
            }
        }
        return $list;
    }

    /**
     * Saves data into array with pulling fields from the model
     * @param $list container for saved values of previous fields
     * @param $model model that contains specified fields
     * @param null $customFields
     */
    protected function saveCommonData(&$list, $model, $customFields = null)
    {
        if (!is_null($customFields)) {
           foreach ($customFields as $field) {
               $list[$field][] = $model->$field;
           }
        } else {
            foreach ($this::DATA_FIELDS_FOR_CHECK as $field) {
                $list[$field][] = $model->$field;
            }
        }
    }

    /**
     * Asserts that the response has values set in model
     * @param $response
     * @param $model
     * @param $customFields if DATA_FIELDS_FOR_CHECK are not suited
     */
    protected function assertSeeTextForCommonDataFromModel($response, $model, $customFields = null)
    {
        if (!is_null($customFields)) {
           foreach ($customFields as $field) {
                $response->assertSeeText($model->$field);
           }
        } else {
            foreach ($this::DATA_FIELDS_FOR_CHECK as $field) {
                $response->assertSeeText($model->$field);
            }
        }
    }

    /**
     * Asserts that response contains values in order from given list for each specified field
     * @param $response
     * @param $list container for previously saved field values
     * @param null $customFields
     */
    protected function assertSeeTextInOrderForCommonData($response, $list, $customFields = null)
    {
        if (!is_null($customFields)) {
           foreach ($customFields as $field) {
                $response->assertSeeTextInOrder($list[$field]);
           }
        } else {
            foreach ($this::DATA_FIELDS_FOR_CHECK as $field) {
                $response->assertSeeTextInOrder($list[$field]);
            }
        }
    }

    /**
     * Asserts that response does not contain values from given list
     * @param $response
     * @param $list container for previously saved field values
     * @param null $customFields
     */
    protected function assertDontSeeTextInOrderForCommonData($response, $list, $customFields = null)
    {
        if (!is_null($customFields)) {
           for ($i = 0; $i < count($list[$customFields[0]]); $i++) {
                foreach ($customFields as $field) {
                    $response->assertDontSeeText($list[$field][$i]);
                }
            }
        } else {
            for ($i = 0; $i < count($list[$this::DATA_FIELDS_FOR_CHECK[0]]); $i++) {
                foreach ($this::DATA_FIELDS_FOR_CHECK as $field) {
                    $response->assertDontSeeText($list[$field][$i]);
                }
            }
        }
    }
}

if (!defined('LARAVEL_START')) {
    define('LARAVEL_START', microtime(true));
}