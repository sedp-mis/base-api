# SedpMis\BaseApi

[![Build Status](https://travis-ci.org/sedp-mis/base-api.svg?branch=develop)](https://travis-ci.org/sedp-mis/base-api)

Abstraction for api resources in Laravel. Compatible to use with Laravel `4.2` and `5.*`.

## Installation
Clone repository and run `composer install`.

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

* Resource can be fetched with selective or specific fields or attributes by using query parameter `attributes[]`. Example:
 ```
 GET api/v1/posts?attributes[]=id&attributes[]=title
 ```
 ... or ...
 ```
 GET api/v1/posts/1129?attributes[]=id&attributes[]=title
 ```

* Resource can be fetched with eager loaded relations by using query parameter `relations[]`. Example:
 ```
 GET api/v1/posts?relations[]=comments&relations[]=labels
 ```
 ... or ...
 ```
 GET api/v1/posts/1129?relations[]=comments&relations[]=labels
 ```

* Fetched eager loaded relations can also have selective or specific attributes by using query parameter `rels_attrs[<relation>][]`. Example:
 ```
 GET api/v1/posts?relations[]=comments&rels_attrs[comments][]=id&rels_attrs[comments][]=text
 ```
 ... or ...
 ```
 GET api/v1/posts/1129?relations[]=comments&rels_attrs[comments][]=id&rels_attrs[comments][]=text
 ```

### `@index`
* For list of resources, it is recommended to have it paginated:
 ```
 GET api/v1/posts?page=1&per_page=100
 ```
 This example shows that it is currently on the 1st page and showing 100 records per page. 
 Without `page` parameter, the list will default to all resources to be fetched.
 
* It is also handy to filter list by its attributes using `filters[attribute][]` parameter. Example:
 ```
 GET api/v1/posts?filters[tag][]=cool&filters[tag][]=trending
 ```

* It is also possible to search by passing `search` query parameter.
 ```
 GET api/v1/posts?search[input]=SomeTextToSearch&search[compare][]=title&search[compare][]=description
 ```
