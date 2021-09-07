#!/bin/bash

#./vendor/bin/codecept run unit FavouritesTest --debug

./vendor/bin/codecept run unit FavouritesTest
./vendor/bin/codecept run unit BookmarksTest
./vendor/bin/codecept run unit CategoriesTest