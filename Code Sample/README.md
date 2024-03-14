# Code Sample - Entity Reference Advanced Link Formatter

This is a relatively simple code sample, but I chose it because it's a perfect
example of the kind of thing I like to do. I try to find ways to speed up the
development / site building process and make things more consistent. I'm also a
firm believer that if I'm writing code, my code should be usable by someone with
less Drupal knowledge and understanding. In this case, a site builder could very
easily configure their link to output as an "icon link."

On some projects we have the idea of an "icon link." Our markup for icon links
is:

```HTML
<a class="icon-link" href="/path/to/some/page">
  <span class="icon-link__text">My link text</span>
  <span class="icon-link__icon"></span>
</a>
```

Depending on the context, the icon may have some visually hidden descriptive
text for screen readers, but generally the icon is aria-hidden as it would only
provide unnecessary noise for screen readers.

We needed the ability to regularly create this markup for entity reference link
fields (e.g. taxonomy terms) and we wanted to be able to configure it in the UI.

As a result, I created this "Entity Reference Advanced Link" formatter.
