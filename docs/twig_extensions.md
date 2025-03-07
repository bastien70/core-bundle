# Twig Extensions

## Date extension

### `time_ago` filter

This filter allows you to display relative text to a given date (Datetime or string). It will use the current locale by default, but you can
force another locale as parameter.

```twig
{{ some_datetime_object|time_ago }} {# eg. "3 days ago" #}
{{ '2021-12-12'|time_ago('fr') }} {# eg. "Il y a 5 minutes" #}
```

## Gravatar extension

### `gravatar` filter

Get either a Gravatar URL or complete image tag for a specified email address.

## Text extension

### `camelize` filter

```twig
{{ 'Some.text.is.now.camelized.'|camelize }} {# will output "Some_Text_Is_Now_Camelized." #}
```

### `safe_truncate` filter

Returns truncated text without breaking HTML tags.

Parameters:

* `length` (int, default `30`)
* `preserve` (bool, default `true`) to preserve full words
* `separator` (string, default `...`)

```twig
{{ 'Lorem <strong class="super" style="display: none;">ipsum dolor sit</strong> amet'|safe_truncate(16) }}
{# will output "Lorem <strong class="super" style="display: none;">ipsum...</strong>" #}
```

## More extensions

* [Data lists](data_lists.md)
* [Navigation helper](navigation_helper.md)
* [Paginator](paginator.md)

More filters & functions exist but are not documented yet. You can find them in the following files:

* [FacebookExtension](https://github.com/leapt/core-bundle/tree/4.x/src/Twig/Extension/FacebookExtension.php)
* [GoogleExtension](https://github.com/leapt/core-bundle/tree/4.x/src/Twig/Extension/GoogleExtension.php)
* [SiteExtension](https://github.com/leapt/core-bundle/tree/4.x/src/Twig/Extension/SiteExtension.php)

PRs welcome :)
