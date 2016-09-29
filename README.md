# SedpMis\BaseApi

[![Build Status](https://travis-ci.org/sedp-mis/base-api.svg?branch=develop)](https://travis-ci.org/sedp-mis/base-api) 
[![Coverage Status](https://coveralls.io/repos/github/sedp-mis/base-api/badge.svg?branch=master)](https://coveralls.io/github/sedp-mis/base-api?branch=master)

Abstraction for api resources in Laravel. Compatible to use with Laravel `4.2` and `5.*`.

## Installation
Use composer to install base-api and dependencies:
```
composer require sedp-mis/base-api
```

## Introduction

The purpose of this repository is to create an abstraction for common use-cases of api resources. 
It is a good practice to version our api so we will set our base api to `api/v1`. 
So in the following api implementations, the example resource to be used is `posts`.

## Implementation
 METHOD     | URL                 | Description
---         | ---                 | ---
`GET`       | `api/v1/posts`      | `@index`, List of resources
`POST`      | `api/v1/posts`      | `@store`, Create or store new resource
`GET`       | `api/v1/posts/{id}` | `@show`, Show resource
`PUT|PATCH` | `api/v1/posts/{id}` | `@update`, Update resource
`DELETE`    | `api/v1/posts/{id}` | `@destroy`, Destroy or delete resource

Notice that `@<method>` are the same with the controller methods in laravel.

## Advance Implementation for `GET` methods like `@index` and `@show`.
### `@index` and `@show`

* __Selective Attributes__. Resource can be fetched with selective or specific fields or attributes by using query parameter `attributes[]`. Example:
 ```
 GET url?attributes[]=id&attributes[]=title
 ```
 
* __Relations__. Resource can be fetched with eager loaded relations by using query parameter `relations[]`. Example:
 ```
 GET url?relations[]=comments&relations[]=labels
 ```
 
* __Relations Attributes__. Fetched eager loaded relations can also have selective or specific attributes. Example:
 ```
 GET url?relations[comments][attributes][]=id&relations[comments][attributes][]=text
 ```

### `@index`
* __Pagination__. For list of resources, it is recommended to have it paginated:
 ```
 GET url?page=1&per_page=100
 ```
 This example shows that it is currently on the 1st page and showing 100 records per page. 
 Without `page` parameter, the list will default to all resources to be fetched.
 
* __Filtering__. It is also handy to filter list by its attributes using `filters[attribute][]` parameter.
 - Default:
  ```
  GET url?filters[tag][]=cool&filters[tag][]=trending
  ```
 - Using `equals` operator (behaves like the default example):
  ```
  GET url?filters[tag][equals][]=cool&filters[tag][equals][]=trending
  ```
 - Using `not_equals` operator:
  ```
  GET url?filters[tag][not_equals][]=bug&filters[tag][not_equals][]=foo
  ```

* __Searching__. It is also possible to search by passing `search` query parameter.
 ```
 GET url?search[input]=SomeTextToSearch&search[compare][]=title&search[compare][]=description
 ```

* __Sorting__. Sorting can be done by this syntax `sort[attribute_1]=asc&sort[attribute_n]=desc`. Example:
 ```
 GET url?sort[title]=asc
 ```
