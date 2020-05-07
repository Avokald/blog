## Testing

Uses phpunit and laravel Illuminate\Foundation\Testing
To run tests use

Local while in the root directory:
```shell
./vendor/bin/phpunit
```

With docker run
```shell
(sudo) docker-compose exec app ./vendor/phpunit/phpunit/phpunit
```

### Feature tests

Feature test cases consists of test methods written with snake_case and helper methods with camelCase.

**\<Model\>ViewTest** - are meant for testing elements that has full screen view and data related to this view.

**\<Model\>ListTest** - are meant for testing elements that has list view and data related to this view.

To test this data they have constant **DATA_FIELDS_FOR_CHECK** that contains field names, that are present in models

Abstract **TestCase** contains additional protected functions that help to initialize, save and test this model data.